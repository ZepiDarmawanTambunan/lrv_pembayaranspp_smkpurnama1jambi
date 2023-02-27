<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

class BerandaWaliController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with('tagihan')->where('wali_id', Auth::id())
            ->whereHas('tagihan', function ($q) {
                $q->where('jenis', 'spp');
            })
            ->orderBy('nama', 'asc')->get();

        // $siswa = Siswa::with('tagihan')->where('wali_id', Auth::id())->orderBy('nama', 'asc')->get();

        $dataRekap = [];
        foreach ($siswa as $itemSiswa) {
            // setiap siswa, ambil data tagihan selama 1 tahun, kalau sudah dihapus ulang. utk perulangan siswa lain nya
            $dataTagihan = [];
            $tahun = date('Y');
            $bulan = date('m');
            if ($bulan < bulanSpp()[0]) {
                $tahun = $tahun - 1;
            }
            foreach (bulanSPP() as $bulan) {
                // jika bulan 1 maka tahun ditambah 1
                if ($bulan == 1) {
                    $tahun = $tahun + 1;
                }

                // mencari tagihan berdasarkan siswa, bulan dan tahun
                $tagihan = $itemSiswa->tagihan->filter(function ($value) use ($bulan, $tahun) {
                    return $value->tanggal_tagihan->year == $tahun
                        && $value->tanggal_tagihan->month == $bulan;
                })->first();

                $statusBayarTeks = "baru";
                if ($tagihan == null) {
                    $statusBayarTeks = "-";
                } else if ($tagihan->status != '') {
                    $statusBayarTeks = $tagihan->status;
                    $pembayaran = $tagihan->pembayaran->whereNull('tanggal_konfirmasi');
                    if ($pembayaran->count() >= 1) {
                        $statusBayarTeks = "belum dikonfirmasi";
                    }
                }

                $dataTagihan[] = [
                    'bulan' => ubahNamaBulan($bulan),
                    'tahun' => $tahun,
                    'tagihan' => $tagihan,
                    'tanggal_lunas' => $tagihan?->tanggal_lunas ?? '-',
                    // 'total_tagihan' => $tagihan?->total_tagihan ?? '-',
                    'status_bayar' => $tagihan?->status == 'baru' ? false : true,
                    'status_bayar_teks' => $statusBayarTeks,
                ];
            }
            $dataRekap[] = [
                'siswa' => $itemSiswa,
                'dataTagihan' => $dataTagihan
            ];
        }

        $data['header'] = bulanSPP();
        $data['dataRekap'] = $dataRekap;

        return view('wali.beranda_index', $data);
    }
}
