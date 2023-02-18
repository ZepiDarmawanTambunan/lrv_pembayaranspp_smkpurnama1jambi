<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tagihan;
use App\Services\WhacenterService;

class KirimPesanWaPengingatTagihan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kirim:watagihan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tagihan = Tagihan::with('siswa')->where('status', 'baru')->get();
        foreach ($tagihan as $item) {
            $pesan = "Assalamu'alaikum dan salam sejahtera ayah bunda.\nKami informasikan tagihan spp bulan ".$item->tanggal_tagihan->translatedFormat('F').' Tahun '.$item->tanggal_tagihan->year.' Atas nama '.$item->siswa->nama." belum dibayar.\nAbaikan pesan pengingat ini jika sudah membayar.\nterimakasih. \n";

            if($item->siswa->wali != null && $item->siswa->wali->nohp != null){
                $ws = new WhacenterService();
                $ws->line($pesan)->to($item->siswa->wali->nohp)->send();
            }
        }
        $this->info("Pesan WA pengingat tagihan berhasil dikirim");
        // $ws = new WhacenterService();
        // $ws->line('test')->to('083121893686')->send();
        // php artisan schedule:work
    }
}
