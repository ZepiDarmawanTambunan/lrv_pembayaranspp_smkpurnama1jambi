<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class KartuSppController extends Controller
{
    public function index(Request $request)
    {
        $siswa = Siswa::with('tagihan')->whereHas('tagihan', function($q){
            $q->where('jenis', 'spp');
        })->where('id', $request->siswa_id);

        if(Auth::user()->akses == 'wali'){
            $siswa = $siswa->where('wali_id', Auth::id());
        }
        $siswa = $siswa->firstOrFail();

        $tahun = $request->tahun;
        if($request->bulan < bulanSpp()[0]){
            $tahun = $tahun - 1;
        }
        $arrayData = [];
        foreach (bulanSPP() as $bulan) {
            // jika bulan 1 maka tahun ditambah 1
            if($bulan == 1){
                $tahun = $tahun+1;
            }

            // mencari tagihan berdasarkan siswa, bulan dan tahun
            $tagihan = $siswa->tagihan->filter(function($value) use($bulan, $tahun){
                return $value->tanggal_tagihan->year == $tahun &&
                $value->tanggal_tagihan->month == $bulan;
            })->first();

            $tanggalBayar = '';
            // jika tagihan tdk kosong dan status != baru maka sudah bayar, kita ambil tgl bayarny
            if($tagihan != null && $tagihan->status != 'baru'){
                $tanggalBayar = $tagihan->pembayaran->first()->tanggal_bayar->format('d/m/y');
            }

            $arrayData[] = [
                'bulan' => ubahNamaBulan($bulan),
                'tahun' => $tahun,
                'total_tagihan' => $tagihan->total_tagihan ?? 0,
                'status_tagihan' => ($tagihan == null) ? false : true,
                'status_pembayaran' => ($tagihan == null) ? 'Belum Bayar' : $tagihan->status,
                'tanggal_bayar' => $tanggalBayar,
            ];
        }

        $data['kartuSpp'] = collect($arrayData);
        $data['siswa'] = $siswa;

        if(request('output') == 'pdf'){
            $pdf = Pdf::loadView('kartuspp_index', $data);
            $namaFile = 'kartu spp '.$siswa->nama.' tahun '.$request->tahun.'.pdf';
            return $pdf->stream($namaFile);
        }
        return view('kartuspp_index', $data);
    }
}
