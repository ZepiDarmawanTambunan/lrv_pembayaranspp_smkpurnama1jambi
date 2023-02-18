<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;

class WaliMuridSiswaController extends Controller
{
    public function index()
    {
        $models = Auth::user()->siswa;
        return view('wali.siswa_index', compact('models'));
    }


    function show($id)
    {
        $data['model'] = Siswa::with('biaya', 'biaya.children')
        ->where('id', $id)
        ->where('wali_id', Auth::user()->id)
        ->firstOrFail();
        return view('wali.siswa_show',$data);
    }
}
