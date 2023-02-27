<?php

namespace App\Http\Controllers;

use App\Models\Biaya;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class LaporanPembayaranController extends Controller
{
    public function index(Request $request)
    {
        $title = "Laporan Pembayaran";
        $subtitle = "";
        $pembayaran = Pembayaran::latest();
        if ($request->filled('tahun')) {
            $pembayaran->whereYear('tanggal_bayar', $request->tahun);
            // $subtitle = "Tahun: ".$request->tahun;
            $subtitle = "<span class='badge rounded-pill bg-success'> Tahun: " . $request->tahun . "</span>";
        }
        if ($request->filled('bulan')) {
            $pembayaran->whereMonth('tanggal_bayar', $request->bulan);
            // $subtitle = $subtitle." | Bulan: ".ubahNamaBulan($request->bulan);
            $subtitle = $subtitle . " | <span class='badge rounded-pill bg-primary'>Bulan: " . ubahNamaBulan($request->bulan) . "</span>";
        }
        if ($request->filled('biaya_id')) {
            $pembayaran->whereHas('tagihan', function ($t) use ($request) {
                $t->where('biaya_id', $request->biaya_id);
            });
            // $subtitle = $subtitle." | Jenis: ".$request->biaya_id;
            $biayaNama = Biaya::findOrFail($request->biaya_id);
            $subtitle = $subtitle . " | <span class='badge rounded-pill bg-warning'>Jenis: " . $biayaNama->nama . "</span>";
            $biayaNama = '';
        }
        if ($request->filled('status')) {
            if ($request->status == 'sudah-dikonfirmasi') {
                $pembayaran->whereNotNull('tanggal_konfirmasi');
            }
            if ($request->status == 'belum-dikonfirmasi') {
                $pembayaran->whereNull('tanggal_konfirmasi');
            }
            // $subtitle = $subtitle." | Status: ".$request->status;
            $subtitle = $subtitle . " | <span class='badge rounded-pill bg-warning'>Status: " . $request->status . "</span>";
        }
        if ($request->filled('jurusan')) {
            $pembayaran->whereHas('tagihan', function ($t) use ($request) {
                $t->whereHas('siswa', function ($s) use ($request) {
                    $s->where('jurusan', $request->jurusan);
                });
            });
            // $subtitle = $subtitle." Jurusan: ".$request->jurusan;
            $subtitle = $subtitle . " | <span class='badge rounded-pill bg-warning'>Status: " . $request->status . "</span>";
        }
        if ($request->filled('kelas')) {
            $pembayaran->whereHas('tagihan', function ($t) use ($request) {
                $t->whereHas('siswa', function ($s) use ($request) {
                    $s->where('kelas', $request->kelas);
                });
            });
            // $subtitle = $subtitle." Kelas: ".$request->kelas;
            $subtitle = $subtitle . " | <span class='badge rounded-pill bg-danger'>Kelas: " . $request->kelas . "</span>";
        }
        if ($request->filled('angkatan')) {
            $pembayaran->whereHas('tagihan', function ($t) use ($request) {
                $t->whereHas('siswa', function ($s) use ($request) {
                    $s->where('angkatan', $request->angkatan);
                });
            });
            // $subtitle = $subtitle." Angkatan: ".$request->angkatan;
            $subtitle = $subtitle . " | <span class='badge rounded-pill bg-secondary'>Angkatan: " . $request->angkatan . "</span>";
        }

        $pembayaran = $pembayaran->get();
        $totalPembayaran = $pembayaran->sum('jumlah_dibayar') ?? 0;
        return view('operator.laporanpembayaran_index', compact('pembayaran', 'subtitle', 'title', 'totalPembayaran'));
    }
}
