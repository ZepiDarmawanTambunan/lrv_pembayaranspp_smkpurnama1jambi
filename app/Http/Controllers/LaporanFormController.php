<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanFormController extends Controller
{
    public function create(Request $request)
    {
        return view('operator.laporanform_index');
    }
}
