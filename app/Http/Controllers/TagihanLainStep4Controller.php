<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessTagihanLainStore;
use App\Models\Biaya;
use App\Models\Tagihan as Model;
use App\Models\Siswa;
use App\Models\TagihanDetail;
use App\Notifications\TagihanLainNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Notification;

class TagihanLainStep4Controller extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $biaya = Biaya::find(session('biaya_id'));
        $siswaId = [];
        if (session('tagihan_untuk') == 'semua') {
            $siswaId = Siswa::currentStatus('aktif')->pluck('id');
        } else if (session('tagihan_untuk') == 'pilihan') {
            $siswaId = session('data_siswa')->where('status', 'aktif')->pluck('id');
        } else {
            flash()->addError('terjadi kesalahan');
            return back();
        }

        $tanggalTagihan = $request->tanggal_tagihan;
        $tanggalJatuhTempo = $request->tanggal_jatuh_tempo;
        $requestData['biaya_id'] = $biaya->id;  // tambahan
        $requestData['siswa_id'] = $siswaId;
        $requestData['jenis'] = 'lain-lain';
        $requestData['tanggal_tagihan'] = $tanggalTagihan;
        $requestData['tanggal_jatuh_tempo'] = $tanggalJatuhTempo;
        $requestData['keterangan'] = $request->keterangan;

        $tanggalTagihan = Carbon::parse($requestData['tanggal_tagihan']);
        // $bulanTagihan = $tanggalTagihan->format('m');
        // $tahunTagihan = $tanggalTagihan->format('Y');
        $process = new ProcessTagihanLainStore($requestData, $biaya);
        $this->dispatch($process);

        return redirect()->route('jobstatus.index', ['job_status_id' => $process->getJobStatusId()]);
    }
}
