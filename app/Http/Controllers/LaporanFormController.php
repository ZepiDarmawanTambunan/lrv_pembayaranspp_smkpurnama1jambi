<?php

namespace App\Http\Controllers;

use App\Models\Biaya;
use Illuminate\Http\Request;

class LaporanFormController extends Controller
{
    public function create(Request $request)
    {

        return view('operator.laporanform_index', [
            'biayaList' => Biaya::whereNull('parent_id')->pluck('nama', 'id'),
        ]);
    }
}
