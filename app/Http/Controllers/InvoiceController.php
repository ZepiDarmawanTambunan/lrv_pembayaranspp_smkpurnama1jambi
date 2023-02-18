<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function show($id)
    {
        $data['tagihan'] = Tagihan::findOrFail($id);
        if(Auth::user()->akses == 'wali'){
            $data['tagihan'] = Tagihan::waliSiswa()->findOrFail($id);
        }
        $data['title'] = 'Cetak Invoice Tagihan Bulan '.$data['tagihan']->tanggal_tagihan->translatedFormat('d F Y');
        if(request('output') == 'pdf'){
            $pdf = Pdf::loadView('invoice_pdf', $data);
            $namaFile = 'invoice tagihan '.$data['tagihan']->siswa->nama.' bulan '.$data['tagihan']->tanggal_tagihan->translatedFormat('d F Y').'.pdf';
            return $pdf->download($namaFile);
        }
        return view('invoice', $data);
    }
}
