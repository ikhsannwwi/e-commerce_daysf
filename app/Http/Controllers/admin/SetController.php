<?php

namespace App\Http\Controllers\admin;

use File;
use DB;
Use DataTables;
use App\Models\Set;
use App\Models\SetImage;
use App\Models\SetDetail;
use App\Models\KategoriSet;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class SetController extends Controller
{
    private static $module = "set";

    public function index(){
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        return view('administrator.set.index');
    }
    
    public function getData(Request $request){
        $data = Set::query()->with('kategori');

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $btn = "";
                if (isAllowed(static::$module, "delete")) : //Check permission
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-danger btn-sm delete me-3 ">
                    Delete
                </a>';
                endif;
                if (isAllowed(static::$module, "edit")) : //Check permission
                    $btn .= '<a href="'.route('admin.set.edit',$row->id).'" class="btn btn-primary btn-sm me-3 ">
                    Edit
                </a>';
                endif;
                if (isAllowed(static::$module, "detail")) : //Check permission
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-secondary btn-sm me-3" data-bs-toggle="modal" data-bs-target="#detailSet">
                    Detail
                </a>';
                endif;
                return $btn;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
    
    public function add(){
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        return view('administrator.set.add');
    }
    
    public function save(Request $request){
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        // Validasi input dari form
        $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'total_harga' => 'required',
            'detail' => 'required',
        ]);

        // dd($request);

        try {
            DB::beginTransaction();
            $data = Set::Create([
                'nama' => $request->nama,
                'kategori_id' => $request->kategori,
                'deskripsi' => $request->deskripsi,
                'total_harga' => str_replace(['Rp ', '.'], '', $request->total_harga),
                'created_by' => auth()->user() ? auth()->user()->kode : '',
            ]);
            
            $log_image = [];

            if ($request->hasFile('img')) {
                $no = 0;
                foreach ($request->file('img') as $image) {
                    // Crop gambar
                    $croppedImage = Image::make($image->getRealPath())
                    ->crop(
                        ($request->dataImage[$no]['width'] !== null ? intVal($request->dataImage[$no]['width']) : 400),
                        ($request->dataImage[$no]['height'] !== null ? intVal($request->dataImage[$no]['height']) : 600),
                        ($request->dataImage[$no]['x'] !== null ? intVal($request->dataImage[$no]['x']) : 0),
                        ($request->dataImage[$no]['y'] !== null ? intVal($request->dataImage[$no]['y']) : 0)
                    );
    
                    // Kompres gambar dengan kualitas tertentu (contoh: 80%)
                    $compressedImage = $croppedImage->encode('jpg', 80);
    
                    // Simpan gambar hasil cropping dan kompresi
                    $fileName = Str::slug($data->nama) . '_' . $no . '_' . date('Y-m-d-H-i-s') . '_' . uniqid(2) . '.jpg';
                    $path = upload_path('set') . $fileName;
                    $compressedImage->save($path);
    
                    // Simpan data gambar ke database
                    $imageModel = SetImage::create([
                        'set_id' => $data->id,
                        'image' => $fileName,
                        'data_image_width' => $request->dataImage[$no]['width'] !== null ? intVal($request->dataImage[$no]['width']) : 400,
                        'data_image_height' => $request->dataImage[$no]['height'] !== null ? intVal($request->dataImage[$no]['height']) : 600,
                        'data_image_x' => $request->dataImage[$no]['x'] !== null ? intVal($request->dataImage[$no]['x']) : 0,
                        'data_image_y' => $request->dataImage[$no]['y'] !== null ? intVal($request->dataImage[$no]['y']) : 0,
                        'created_by' => auth()->user() ? auth()->user()->kode : '',
                    ]);
                    $log_image[] = $imageModel;
    
                    $no++;
                }
            }

            $log_detail = [];
    
            foreach ($request->detail as $key => $row) {
                $detail = SetDetail::create([
                    'set_id' => $data->id,
                    'nama' => $row['produk'],
                    'harga' => str_replace(['Rp ', '.'], '', $row['harga']),
                    'link' => $row['link_pembelian'],
                    'created_by' => auth()->user() ? auth()->user()->kode : '',
                ]);
    
                    $croppedImage = Image::make($request->file('detail')[$key]['image']->getRealPath())
                    ->crop(
                        ($row['dataImage_width'] !== null ? intVal($row['dataImage_width']) : 600),
                        ($row['dataImage_height'] !== null ? intVal($row['dataImage_height']) : 600),
                        ($row['dataImage_x'] !== null ? intVal($row['dataImage_x']) : 0),
                        ($row['dataImage_y'] !== null ? intVal($row['dataImage_y']) : 0)
                    );
    
                    // Kompres gambar dengan kualitas tertentu (contoh: 80%)
                    $compressedImage = $croppedImage->encode('jpg', 80);
    
                    // Simpan gambar hasil cropping dan kompresi
                    $fileName = 'detail_' . Str::slug($data->nama) . '_' . date('Y-m-d-H-i-s') . '_' . uniqid(2) . '.jpg';
                    $path = upload_path('set') . $fileName;
                    $compressedImage->save($path);
    
                    $detail->update([
                        'foto' => $fileName,
                        'data_image_width' => $row['dataImage_width'] !== null ? intVal($row['dataImage_width']) : 600,
                        'data_image_height' => $row['dataImage_height'] !== null ? intVal($row['dataImage_height']) : 600,
                        'data_image_x' => $row['dataImage_x'] !== null ? intVal($row['dataImage_x']) : 0,
                        'data_image_y' => $row['dataImage_y'] !== null ? intVal($row['dataImage_y']) : 0,
                    ]);

                    $log_detail[] = $detail;
            }
    
            createLog(static::$module, __FUNCTION__, $data->id, ['Data yang disimpan' => ['Data' => $data, 'Detail' => $log_detail, 'Image' => $log_image]]);
            DB::commit();
            return redirect()->route('admin.set')->with('success', 'Data berhasil disimpan.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
            DB::rollback();
        }
    }
    
    
    public function edit($id){
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $data = Set::with('detail')->with('image')->with('kategori')->find($id);

        return view('administrator.set.edit',compact('data'));
    }
    
    public function update(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $id = $request->id;
        $data = Set::find($id);

        $rules = [
            'nama' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'total_harga' => 'required',
            'detail' => 'required',
        ];

        $request->validate($rules);
        // dd($request);
        // Simpan data sebelum diupdate
        $previousData = $data->toArray();

        try {
            DB::beginTransaction();
            $updates = [
                'nama' => $request->nama,
                'kategori_id' => $request->kategori,
                'deskripsi' => $request->deskripsi,
                'total_harga' => str_replace(['Rp ', '.'], '', $request->total_harga),
                'updated_by' => auth()->user() ? auth()->user()->kode : '',
            ];

            $log_image = [];

            if ($request->hasFile('img')) {
                $no = SetImage::where('set_id', $id)->count();
                foreach ($request->file('img') as $image) {
                    // Crop gambar
                    $croppedImage = Image::make($image->getRealPath())
                    ->crop(
                        ($request->dataImage[$no]['width'] !== null ? intVal($request->dataImage[$no]['width']) : 400),
                        ($request->dataImage[$no]['height'] !== null ? intVal($request->dataImage[$no]['height']) : 600),
                        ($request->dataImage[$no]['x'] !== null ? intVal($request->dataImage[$no]['x']) : 0),
                        ($request->dataImage[$no]['y'] !== null ? intVal($request->dataImage[$no]['y']) : 0)
                    );
    
                    // Kompres gambar dengan kualitas tertentu (contoh: 80%)
                    $compressedImage = $croppedImage->encode('jpg', 80);
    
                    // Simpan gambar hasil cropping dan kompresi
                    $fileName = Str::slug($data->nama) . '_' . $no . '_' . date('Y-m-d-H-i-s') . '_' . uniqid(2) . '.jpg';
                    $path = upload_path('set') . $fileName;
                    $compressedImage->save($path);
    
                    // Simpan data gambar ke database
                    $imageModel = SetImage::create([
                        'set_id' => $data->id,
                        'image' => $fileName,
                        'data_image_width' => $request->dataImage[$no]['width'] !== null ? intVal($request->dataImage[$no]['width']) : 400,
                        'data_image_height' => $request->dataImage[$no]['height'] !== null ? intVal($request->dataImage[$no]['height']) : 600,
                        'data_image_x' => $request->dataImage[$no]['x'] !== null ? intVal($request->dataImage[$no]['x']) : 0,
                        'data_image_y' => $request->dataImage[$no]['y'] !== null ? intVal($request->dataImage[$no]['y']) : 0,
                        'created_by' => auth()->user() ? auth()->user()->kode : '',
                    ]);
                    $log_image[] = $imageModel;
    
                    $no++;
                }
            }

            foreach ($request->dataImage as $key => $row) {
                if (!empty($row['img_id'])) {
                    $img_updates = [
                        'data_image_width' => $row['width'],
                        'data_image_height' => $row['height'],
                        'data_image_x' => $row['x'],
                        'data_image_y' => $row['y'],
                        'updated_by' => auth()->user() ? auth()->user()->kode : '',
                    ];

                    $image = SetImage::find($row['img_id']);
                    $image_path = "./administrator/assets/media/set/" . $image->image;
                    if (File::exists($image_path)) {
                        if (($row['width'] !== null) || ($row['height'] !== null) || ($row['x'] !== null) || ($row['y'] !== null) ) {
                            $croppedImage = Image::make($image_path)
                                ->crop(
                                    intVal($row['width']),
                                    intVal($row['height']),
                                    ($row['x'] !== null ? intVal($row['x']) : 0),
                                    ($row['y'] !== null ? intVal($row['y']) : 0)
                                );
        
                            // Simpan gambar hasil cropping dan kompresi
                            $path = upload_path('set') . $image->image;
                            $croppedImage->save($path);
                        }
                    }

                    $image->update($img_updates);
                }
            }

            foreach ($request->detail as $key => $row) {
                $details = [
                    'set_id' => $data->id,
                    'nama' => $row['produk'],
                    'harga' => str_replace(['Rp ', '.'], '', $row['harga']),
                    'link' => $row['link_pembelian'],
                ];

                if (!empty($row['id'])) {
                    $detail = SetDetail::find($row['id']);
                    $details['updated_by'] = auth()->user() ? auth()->user()->kode : '';
                    if (isset($request->file('detail')[$key]['image'])) {
                        $image_path = "./administrator/assets/media/set/" . $detail->foto;
                        if (File::exists($image_path)) {
                            File::delete($image_path);
                        }
                        $croppedImage = Image::make($request->file('detail')[$key]['image']->getRealPath())
                        ->crop(
                            ($row['dataImage_width'] !== null ? intVal($row['dataImage_width']) : 600),
                            ($row['dataImage_height'] !== null ? intVal($row['dataImage_height']) : 600),
                            ($row['dataImage_x'] !== null ? intVal($row['dataImage_x']) : 0),
                            ($row['dataImage_y'] !== null ? intVal($row['dataImage_y']) : 0)
                        );
        
                        // Kompres gambar dengan kualitas tertentu (contoh: 80%)
                        $compressedImage = $croppedImage->encode('jpg', 80);
        
                        // Simpan gambar hasil cropping dan kompresi
                        $fileName = 'detail_' . Str::slug($data->nama) . '_' . date('Y-m-d-H-i-s') . '_' . uniqid(2) . '.jpg';
                        $path = upload_path('set') . $fileName;
                        $compressedImage->save($path);
        
                        $details['foto'] = $fileName;
                        $details['data_image_width'] = $row['dataImage_width'] !== null ? intVal($row['dataImage_width']) : 600;
                        $details['data_image_height'] = $row['dataImage_height'] !== null ? intVal($row['dataImage_height']) : 600;
                        $details['data_image_x'] = $row['dataImage_x'] !== null ? intVal($row['dataImage_x']) : 0;
                        $details['data_image_y'] = $row['dataImage_y'] !== null ? intVal($row['dataImage_y']) : 0;
                    
                    }else{
                        $image_path = "./administrator/assets/media/set/" . $detail->foto;
                        if (File::exists($image_path)) {
                            $croppedImage = Image::make($image_path)
                            ->crop(
                                intVal($row['dataImage_width']),
                                intVal($row['dataImage_height']),
                                ($row['dataImage_x'] !== null ? intVal($row['dataImage_x']) : 0),
                                ($row['dataImage_y'] !== null ? intVal($row['dataImage_y']) : 0)
                            );
            
                            // Simpan gambar hasil cropping dan kompresi
                            $path = upload_path('set') . $detail->foto;
                            $croppedImage->save($path);
            
                            $details['data_image_width'] = $row['dataImage_width'] !== null ? intVal($row['dataImage_width']) : 600;
                            $details['data_image_height'] = $row['dataImage_height'] !== null ? intVal($row['dataImage_height']) : 600;
                            $details['data_image_x'] = $row['dataImage_x'] !== null ? intVal($row['dataImage_x']) : 0;
                            $details['data_image_y'] = $row['dataImage_y'] !== null ? intVal($row['dataImage_y']) : 0;
                        }
                    }
                    $detail->update($details);
                } else {
                    $details['created_by'] = auth()->user() ? auth()->user()->kode : '';
                    $detail = SetDetail::create($details);
        
                        $croppedImage = Image::make($request->file('detail')[$key]['image']->getRealPath())
                        ->crop(
                            ($row['dataImage_width'] !== null ? intVal($row['dataImage_width']) : 600),
                            ($row['dataImage_height'] !== null ? intVal($row['dataImage_height']) : 600),
                            ($row['dataImage_x'] !== null ? intVal($row['dataImage_x']) : 0),
                            ($row['dataImage_y'] !== null ? intVal($row['dataImage_y']) : 0)
                        );
        
                        // Kompres gambar dengan kualitas tertentu (contoh: 80%)
                        $compressedImage = $croppedImage->encode('jpg', 80);
        
                        // Simpan gambar hasil cropping dan kompresi
                        $fileName = 'detail_' . Str::slug($data->nama) . '_' . date('Y-m-d-H-i-s') . '_' . uniqid(2) . '.jpg';
                        $path = upload_path('set') . $fileName;
                        $compressedImage->save($path);
        
                        $detail->update([
                            'foto' => $fileName,
                            'data_image_width' => $row['dataImage_width'] !== null ? intVal($row['dataImage_width']) : 600,
                            'data_image_height' => $row['dataImage_height'] !== null ? intVal($row['dataImage_height']) : 600,
                            'data_image_x' => $row['dataImage_x'] !== null ? intVal($row['dataImage_x']) : 0,
                            'data_image_y' => $row['dataImage_y'] !== null ? intVal($row['dataImage_y']) : 0,
                        ]);
                }
                
            }

    
            // Filter only the updated data
            $updatedData = array_intersect_key($updates, $data->getOriginal());
    
            $data->update($updates);
        
            createLog(static::$module, __FUNCTION__, $data->id, [
                'Data sebelum diupdate' => ['Data' => $updatedData, 'Detail' => $updatedData, 'Image' => $updatedData],
                // 'Data sesudah diupdate' => ['Data' => $module, 'Detail' => $log_module_access, 'Image' => $log_image],
            ]);

            DB::commit();
            return redirect()->route('admin.set')->with('success', 'Data berhasil diupdate.');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', $th->getMessage());
        }
    }

    public function delete(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }

        // Ensure you have authorization mechanisms here before proceeding to delete data.

        $id = $request->id;

        // Find the user based on the provided ID.
        $data = Set::findorfail($id);

        $log_detail = [];
        $log_image = [];

        if (!$data) {
            return response()->json([
                'code' => 404,
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
        $detail = SetDetail::where('set_id',$id)->get();
        if ($detail) {
            foreach ($detail as $row) {
                $log_detail[] = $row;
                $detail_image_path = "./administrator/assets/media/set/" . $row->foto;
                if (File::exists($detail_image_path)) {
                    File::delete($detail_image_path);
                }
                $row->delete();
            }
        }
        $image = SetImage::where('set_id',$id)->get();
        if ($image) {
            foreach ($image as $row) {
                $log_image[] = $row;
                $image_path = "./administrator/assets/media/set/" . $row->image;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
                $row->delete();
            }
        }

        $data->delete();

        createLog(static::$module, __FUNCTION__, $id, ['Data yang dihapus' => ['Data' => $data, 'Detail' => $log_detail, 'Image' => $log_image]]);
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Data telah dihapus.',
        ],200);
    }

    public function deleteDetail(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }
        $id = $request->id;

        // Find the data based on the provided ID.
        $data = SetDetail::findorfail($id);

        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $deletedData = $data->toArray();

        // Delete the transaction
        try {
            DB::beginTransaction();
            $image_path = "./administrator/assets/media/set/" . $data->image;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $data->delete();
    
            createLog(static::$module, __FUNCTION__, $id, ['Data yang dihapus' => $deletedData]);
            
            DB::commit();
            return response()->json([
                'status'  => 'success',
                'message' => 'Data telah dihapus.',
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status'  => 'error',
                'message' => 'Error : ' .$th->getMessage(),
            ], 500);
        }
    }

    public function deleteImage(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }
        $id = $request->id;

        $data = SetImage::find($id);

        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $deletedData = $data->toArray();
        $image_path = "./administrator/assets/media/set/" . $data->image;
        if (File::exists($image_path)) {
            File::delete($image_path);
        }
        $data->delete();

        createLog(static::$module, __FUNCTION__, $id, ['Data yang dihapus' => $deletedData]);
        return response()->json([
            'status' => 'success',
            'message' => 'Data telah dihapus.',
        ]);
    }

    public function getDetail($id){
        //Check permission
        if (!isAllowed(static::$module, "detail")) {
            abort(403);
        }

        $data = Set::findOrFail($id);
        $access = ModuleAccess::where('module_id',$id)->get();

        return response()->json([
            'data' => $data,
            'status' => 'success',
            'message' => 'Sukses memuat detail module.',
        ]);
    }

    public function getKategori(){
        $data = KategoriSet::all();

        return response()->json([
            'kategori' => $data,
            'status' => 'success',
            'message' => 'Sukses memuat detail module.',
        ]);
    }
}
