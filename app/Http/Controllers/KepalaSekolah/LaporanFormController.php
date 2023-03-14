<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Models\Biaya;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LaporanFormController extends Controller
{
    public function create(Request $request)
    {

        return view('kepala_sekolah.laporanform_index', [
            'biayaList' => Biaya::whereNull('parent_id')->pluck('nama', 'id'),
        ]);
    }
}
