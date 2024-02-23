<?php

namespace App\Http\Controllers\admin;

use DB;
use DataTables;
use App\Models\KategoriSet;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KategoriSetController extends Controller
{
    private static $module = "kategori_set";

    public function index(){
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        return view('administrator.kategori_set.index');
    }
    
    public function getData(Request $request){
        $data = KategoriSet::query();

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $btn = "";
                if (isAllowed(static::$module, "delete")) : //Check permission
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-danger btn-sm delete me-3 ">
                    Delete
                </a>';
                endif;
                if (isAllowed(static::$module, "edit")) : //Check permission
                    $btn .= '<a href="'.route('admin.kategori_set.edit',$row->id).'" class="btn btn-primary btn-sm me-3 ">
                    Edit
                </a>';
                endif;
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    
    public function add(){
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        return view('administrator.kategori_set.add');
    }
    
    public function save(Request $request){
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        $rules = [
            'nama' => 'required',
        ];

        $request->validate($rules);
        
        $slug = Str::slug($request->nama);
        $cekSlugCount = KategoriSet::where('slug', $slug)->count();

        // Handle duplicate slug
        if ($cekSlugCount > 0) {
            $slug = $slug . '-' . ($cekSlugCount + 1);
        }
    
        $data = KategoriSet::create([
            'nama' => $request->nama,
            'slug' => $slug,
        ]);
    
        createLog(static::$module, __FUNCTION__, $data->id, ['Data yang disimpan' => $data]);
        return redirect()->route('admin.kategori_set')->with('success', 'Data berhasil disimpan.');
    }
    
    
    public function edit($id){
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $data = KategoriSet::find($id);

        return view('administrator.kategori_set.edit',compact('data'));
    }
    
    public function update(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $id = $request->id;
        $data = KategoriSet::find($id);

        $rules = [
            'nama' => 'required',
        ];

        $request->validate($rules);

        // Simpan data sebelum diupdate
        $previousData = $data->toArray();

        $slug = Str::slug($request->nama);
        $cekSlugCount = KategoriSet::where('slug', $slug)->where('id', '!=', $id)->count();

        // Handle duplicate slug
        if ($cekSlugCount > 0) {
            $slug = $slug . '-' . ($cekSlugCount + 1);
        }

        $updates = [
            'nama' => $request->nama,
            'slug' => $slug,
        ];

        // Filter only the updated data
        $updatedData = array_intersect_key($updates, $data->getOriginal());

        $data->update($updates);

        createLog(static::$module, __FUNCTION__, $data->id, ['Data sebelum diupdate' => $previousData, 'Data sesudah diupdate' => $updatedData]);
        return redirect()->route('admin.kategori_set')->with('success', 'Data berhasil diupdate.');
    }
    
    public function delete(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }

        // Ensure you have authorization mechanisms here before proceeding to delete data.

        $id = $request->id;

        // Find the data based on the provided ID.
        $data = KategoriSet::findorfail($id);

        if (!$data) {
            return response()->json([
                'code' => 404,
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Store the data to be logged before deletion
        $deletedData = $data->toArray();

        // Delete the data.
        $data->delete();
        // Write logs only for soft delete (not force delete)
        createLog(static::$module, __FUNCTION__, $id, ['Data yang dihapus' => ['Data' => $deletedData]]);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Data telah dihapus.',
        ],200);
    }

    public function checkNama(Request $request){
        if($request->ajax()){
            $data = KategoriSet::where('nama', $request->nama);
            
            if(isset($request->id)){
                $data->where('id', '!=', $request->id);
            }
    
            if($data->exists()){
                return response()->json([
                    'message' => 'Nama sudah dipakai',
                    'valid' => false
                ]);
            } else {
                return response()->json([
                    'valid' => true
                ]);
            }
        }
    }
}
