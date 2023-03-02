<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\BankSekolah;
use App\Models\Biaya;

class WaliMuridTagihanController extends Controller
{
    public function index()
    {
        $tagihan = Tagihan::waliSiswa()->latest();
        if (request()->filled('bulan')) {
            $tagihan->whereMonth('tanggal_tagihan', request('bulan'));
        }
        if (request()->filled('tahun')) {
            $tagihan->whereYear('tanggal_tagihan', request('tahun'));
        }
        if (request()->filled('status')) {
            $tagihan->where('status', request('status'));
        }
        if (request()->filled('biaya_id')) {
            $tagihan->where('biaya_id', request('biaya_id'));
        }
        if (request()->filled('q')) {
            $tagihan = $tagihan->search(request('q'));
        }
        $data['tagihan'] = $tagihan->get();
        $data['biayaList'] = Biaya::whereNull('parent_id')->pluck('nama', 'id');
        return view('wali.tagihan_index', $data);
    }

    public function show($id)
    {
        auth()->user()->unreadNotifications->where('id', request('id'))->first()?->markAsRead();
        $tagihan = Tagihan::waliSiswa()->findOrFail($id);
        if ($tagihan->status == 'lunas') {
            $pembayaranId = $tagihan->pembayaran->last()->id;
            return redirect()->route('wali.pembayaran.show', $pembayaranId);
        }
        $bankSekolah = BankSekolah::all();
        $siswa = $tagihan->siswa;
        return view('wali.tagihan_show', compact('tagihan', 'siswa', 'bankSekolah'));
    }
}
