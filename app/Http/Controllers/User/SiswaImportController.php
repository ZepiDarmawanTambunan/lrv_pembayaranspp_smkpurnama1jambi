<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Imports\SiswaImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class SiswaImportController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'template' => 'required|mimes:xlsx,xls'
        ]);
        Excel::import(new SiswaImport, $request->file('template')->store('temp'));
        flash('Data berhasil ditambahkan');
        return back();
    }
}
