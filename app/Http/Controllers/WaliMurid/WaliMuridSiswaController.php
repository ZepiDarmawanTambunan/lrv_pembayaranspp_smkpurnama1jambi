<?php

namespace App\Http\Controllers\WaliMurid;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Http\Controllers\Controller;

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
        return view('wali.siswa_show', $data);
    }
}
