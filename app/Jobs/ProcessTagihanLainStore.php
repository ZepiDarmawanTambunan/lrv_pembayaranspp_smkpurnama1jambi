<?php

namespace App\Jobs;

use App\Models\Siswa;
use App\Models\Tagihan as Model;
use App\Models\TagihanDetail;
use App\Notifications\TagihanLainNotification;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use Imtigger\LaravelJobStatus\Trackable;

class ProcessTagihanLainStore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Trackable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $requestData;
    private $biaya;
    public function __construct($requestData, $biaya)
    {
        $this->prepareStatus();
        $this->requestData = $requestData;
        $this->biaya = $biaya;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $requestData = $this->requestData;
        $biaya = $this->biaya;
        $siswa = [];
        if (isset($requestData['siswa_id']) && $requestData['siswa_id'] != null) {
            $siswa = Siswa::whereIn('id', $requestData['siswa_id']);
        }
        $siswa = $siswa->get();

        $this->setProgressMax($siswa->count());
        $i = 1;

        DB::beginTransaction();
        foreach ($siswa as $itemSiswa) {
            $this->setProgressNow($i);
            $i++;
            $requestData['siswa_id'] = $itemSiswa->id;
            $tagihan = Model::create($requestData);
            if ($tagihan->siswa->wali != null) {
                Notification::send($tagihan->siswa->wali, new TagihanLainNotification($tagihan));
            }

            foreach ($biaya->children as $itemBiaya) {
                TagihanDetail::create([
                    'tagihan_id' => $tagihan->id,
                    'nama_biaya' => $itemBiaya->nama,
                    'jumlah_biaya' => $itemBiaya->jumlah,
                ]);
            }
            // }
        }
        DB::commit();
        $this->setOutput(['message' => 'Tagihan biaya lain ' . $biaya->nama . ' berhasil dibuat']);
    }
}
