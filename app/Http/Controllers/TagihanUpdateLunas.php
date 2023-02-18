<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Notifications\PembayaranKonfirmasiNotification;

class TagihanUpdateLunas extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        for($i = 0; $i < count($request->tagihan_id); $i++){
            $tagihan = Tagihan::where('status', 'baru')
            ->where('id', $request->tagihan_id[$i])
            ->first();

            if($tagihan != null){
                $dataPembayaran['tanggal_konfirmasi'] = now();
                $dataPembayaran['metode_pembayaran'] = 'manual';
                $dataPembayaran['tanggal_bayar'] = now();
                $dataPembayaran['jumlah_dibayar'] = $tagihan->total_tagihan;
                $dataPembayaran['tagihan_id'] = $tagihan->id;
                $dataPembayaran['wali_id'] = $tagihan->siswa->wali_id ?? 0;

                $pembayaran = Pembayaran::create($dataPembayaran);
                $wali = $pembayaran->wali;
                if($wali != null){
                    $wali->notify(new PembayaranKonfirmasiNotification($pembayaran));
                }
            }
        }
        return response()->json([
            'message' => 'Data berhasil disimpan',
        ], 200);
    }
}
