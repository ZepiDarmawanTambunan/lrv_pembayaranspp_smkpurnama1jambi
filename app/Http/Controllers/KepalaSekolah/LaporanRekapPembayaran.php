<?php


namespace App\Http\Controllers\KepalaSekolah;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Http\Controllers\Controller;

class LaporanRekapPembayaran extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Laporan Rekap Pembayaran';
        // old
        // $data['subtitle'] = 'Laporan Berdasarkan: '.'Tahun Ajaran: '.getTahunAjaranFull(date('7'), $request->tahun);
        // new
        $data['subtitle'] = 'Laporan Berdasarkan: ' . '<span class="badge rounded-pill bg-primary">Tahun Ajaran: ' . getTahunAjaranFull(date('7'), $request->tahun) . '</span>';

        $data['dataRekap'] = [];
        $siswa = Siswa::with(['tagihan' => function ($q) {
            $q->where('tagihans.jenis', '=', 'spp');
        }])->orderBy('nama', 'asc');

        if ($request->filled('kelas')) {
            $siswa->where('kelas', $request->kelas);
            // old
            // $data['subtitle'] = $data['subtitle']. '| Kelas: '.$request->kelas;
            // new
            $data['subtitle'] = $data['subtitle'] . '| <span class="badge rounded-pill bg-success">Kelas: ' . $request->kelas . '</span>';
        }
        if ($request->filled('jurusan')) {
            $siswa->where('jurusan', $request->jurusan);
            $data['subtitle'] = $data['subtitle'] . '| <span class="badge rounded-pill bg-warning">Jurusan: ' . $request->jurusan . '</span>';
        }
        $siswa = $siswa->get();
        foreach ($siswa as $itemSiswa) {
            // setiap siswa, ambil data tagihan selama 1 tahun, kalau sudah dihapus ulang. utk perulangan siswa lain nya
            $dataTagihan = [];
            $tahun = $request->tahun;
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

                $dataTagihan[] = [
                    'bulan' => ubahNamaBulan($bulan),
                    'tahun' => $tahun,
                    'tanggal_lunas' => $tagihan->tanggal_lunas ?? '-',
                    'total_tagihan' => $tagihan->total_tagihan ?? '-',
                ];
            }
            $data['dataRekap'][] = [
                'siswa' => $itemSiswa,
                'dataTagihan' => $dataTagihan
            ];
        }
        $data['header'] = bulanSPP();
        return view('kepala_sekolah.laporanrekappembayaran_index', $data);
    }
}
