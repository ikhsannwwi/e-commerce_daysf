<?php

namespace App\Http\Controllers\frontpage;

use App\Models\Set;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(){
        return view('frontpage.home.index');
    }

    public function getSet(){
        $data = Set::with('detail')->with('image')->with('kategori')->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Data successfully',
            'data' => $data
        ], 200);
    }
}
