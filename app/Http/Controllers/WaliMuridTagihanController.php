<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\BankSekolah;

class WaliMuridTagihanController extends Controller
{
    public function index()
    {
        $tagihan = Tagihan::waliSiswa()->latest();
        if(request()->filled('q')){
            $tagihan = $tagihan->search(request('q'));
        }
        $data['tagihan'] = $tagihan->get();
        return view('wali.tagihan_index', $data);
    }

    public function show($id)
    {
        auth()->user()->unreadNotifications->where('id', request('id'))->first()?->markAsRead();
        $tagihan = Tagihan::waliSiswa()->findOrFail($id);
        if($tagihan->status == 'lunas'){
            $pembayaranId = $tagihan->pembayaran->last()->id;
            return redirect()->route('wali.pembayaran.show', $pembayaranId);
        }
        $bankSekolah = BankSekolah::all();
        $siswa = $tagihan->siswa;
        return view('wali.tagihan_show', compact('tagihan', 'siswa', 'bankSekolah'));
    }
}
