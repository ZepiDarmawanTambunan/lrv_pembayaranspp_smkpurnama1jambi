<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use Barryvdh\DomPDF\Facade\Pdf;

class KwitansiPembayaranController extends Controller
{
    public function show($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $data['pembayaran'] = $pembayaran;
        $data['title'] = 'Kwitansi Pembayaran NO #'.$pembayaran->id;
        if(request('output') == 'pdf'){
            $pdf = Pdf::loadView('kwitansi_pembayaran', $data);
            $namaFile = 'Kwitansi Pembayaran '.$data['pembayaran']->tagihan->siswa->nama.' bulan '.$data['pembayaran']->tagihan->tanggal_tagihan->translatedFormat('d F Y').'.pdf';
            return $pdf->download($namaFile);
        }
        return view('kwitansi_pembayaran', $data);
    }
}
