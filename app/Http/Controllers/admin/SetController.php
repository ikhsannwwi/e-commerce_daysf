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
    
                    $detail->update(['foto' => $fileName]);

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
        // Check permission for updating
        if (!isAllowed(static::$module, "update")) {
            abort(403);
        }

        // Validate input from the form
        $request->validate([
            'name' => 'required|string',
            'identifiers' => 'required|string',
            'modul_akses.*.tipe' => 'required|string',
            'modul_akses.*.kode_akses' => 'required_if:modul_akses.*.tipe,element|string',
            'modul_akses.*.kode_akses' => 'required_if:modul_akses.*.tipe,page|string',
        ]);

        $id = $request->id;
        // Find the module by ID
        $module = Set::find($id);

        // Check if the module exists
        if (!$module) {
            return redirect()->route('admin.set')->with('error', 'Modul tidak ditemukan.');
        }
        $log_module_before = $module;

        $module_access = ModuleAccess::where('module_id', $module->id)->get();

        $log_module_access_after = $module_access;

        // Update the module data
        $module->update([
            'name' => $request->name,
            'identifiers' => $request->identifiers,
        ]);

        // Delete existing module access records for this module
        $module->access()->delete();

        // Save the updated module access data
        foreach ($request->input('modul_akses') as $modulAkses) {
            $module->access()->create([
                'module_id' => $module->id,
                'name' => Str::ucfirst($modulAkses['kode_akses']),
                'identifiers' => Str::lower($modulAkses['kode_akses']),
            ]);
        }

        $log_module_access = ModuleAccess::where('module_id', $module->id)->get();

        createLog(static::$module, __FUNCTION__, $module->id, [
            'Data sebelum diupdate' => ['Modul' => $log_module_before, 'Modul Akses' => $log_module_access_after],
            'Data sesudah diupdate' => ['Modul' => $module, 'Modul Akses' => $log_module_access],
        ]);

        return redirect()->route('admin.set')->with('success', 'Data berhasil diupdate.');
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
