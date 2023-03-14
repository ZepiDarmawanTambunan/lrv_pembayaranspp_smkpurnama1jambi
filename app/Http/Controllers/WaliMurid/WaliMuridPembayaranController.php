<?php

namespace App\Http\Controllers\WaliMurid;

use App\Models\Bank;
use App\Models\User;
use App\Models\Tagihan;
use App\Models\WaliBank;
use App\Models\Pembayaran;
use App\Models\BankSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PembayaranNotification;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use DB;

class WaliMuridPembayaranController extends Controller
{
    public function index()
    {
        $data['models'] = Pembayaran::where('wali_id', auth()->user()->id)
            ->latest()
            ->orderBy('tanggal_konfirmasi', 'desc')
            ->paginate(50);
        return view('wali.pembayaran_index', $data);
    }

    public function show(Pembayaran $pembayaran)
    {
        auth()->user()->unreadNotifications->where('id', request('id'))->first()?->markAsRead();

        return view('wali.pembayaran_show', [
            'model' => $pembayaran,
        ]);
    }

    public function create(Request $request)
    {
        $data['listWaliBank'] = WaliBank::where('wali_id', Auth::user()->id)
            ->get()
            ->pluck('nama_bank_full', 'id');
        $data['tagihan'] = Tagihan::waliSiswa()
            ->findOrFail($request->tagihan_id);
        $data['model'] = new Pembayaran();
        $data['method'] = 'POST';
        $data['route'] = 'wali.pembayaran.store';
        $data['listBankSekolah'] = BankSekolah::pluck('nama_bank', 'id');
        $data['listBank'] = Bank::pluck('nama_bank', 'id');
        $data['url'] = route('wali.pembayaran.create', [
            'tagihan_id' => $request->tagihan_id,
        ]);

        if ($request->bank_sekolah_id != '') {
            $data['bankYangDipilih'] = BankSekolah::findOrFail($request->bank_sekolah_id);
        }

        return view('wali.pembayaran_form', $data);
    }

    public function store(Request $request)
    {
        if ($request->wali_bank_id == '' && $request->nomor_rekening == '') {
            return back()
                ->withErrors(['wali_bank_id' => 'Silahkan pilih bank pengirim'])
                ->withInput();
        }
        // cara pak aim $request->nama_rekening != '' && $request->nomor_rekening != ''
        // cara kita dipembayaran form bagian else {!! Form::hidden('pilihan_bank', 1, []) !!}

        if ($request->filled('pilihan_bank')) {
            $requestDataBank = $request->validate([
                'nama_rekening' => 'required',
                'nomor_rekening' => 'required',
                'bank_id' => 'required|exists:banks,id'
            ]);
            $bank = Bank::findOrFail($request->bank_id);
            $waliBank = WaliBank::firstOrCreate(
                ['nomor_rekening' => $requestDataBank['nomor_rekening']],
                [
                    'nama_rekening' => $requestDataBank['nama_rekening'],
                    'wali_id' =>  Auth::user()->id,
                    'kode' => $bank->sandi_bank,
                    'nama_bank' => $bank->nama_bank,
                ]
            );
        } else {
            // wali membayar memilih rekening dari select
            $waliBank = WaliBank::findOrFail($request->wali_bank_id);
        }

        $jumlahDibayar = str_replace('.', '', $request->jumlah_dibayar);
        $pembayaran = [];

        $validasiPembayaran = Pembayaran::where('jumlah_dibayar', $jumlahDibayar)
            ->where('tagihan_id', $request->tagihan_id)
            ->whereNull('tanggal_konfirmasi')
            ->first();

        if ($validasiPembayaran != null) {
            flash()->addWarning('Data pembayaran ini sudah ada, dan akan segera dikonfirmasi oleh operator');
            return back();
        }

        $request->validate([
            'bank_sekolah_id' => 'required|exists:bank_sekolahs,id',
            'tanggal_bayar' => 'required',
            'jumlah_dibayar' => 'required',
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:5048',
        ]);

        $buktiBayar = $request->file('bukti_bayar')->store('public');

        $dataPembayaran = [
            'bank_sekolah_id' => $request->bank_sekolah_id,
            'wali_bank_id' => $waliBank->id,
            'tagihan_id' => $request->tagihan_id,
            'wali_id' => auth()->user()->id,
            'tanggal_bayar' => $request->tanggal_bayar . ' ' . date('H:i:s'),
            'jumlah_dibayar' => $jumlahDibayar,
            'bukti_bayar' => $buktiBayar,
            'metode_pembayaran' => 'transfer',
            'user_id' => 0,
        ];

        $tagihan = Tagihan::findOrFail($request->tagihan_id);
        if ($jumlahDibayar >= $tagihan->total_tagihan) {
            DB::beginTransaction();
            try {
                // CARA CREATE TANPA MENJALANKAN LIFECYCLE CREATED CREATING DI MODEL
                $pembayaran = new Pembayaran();
                $pembayaran->fill($dataPembayaran);
                $pembayaran->saveQuietly();

                $userOperator = User::where('akses', 'operator')->get();
                Notification::send($userOperator, new PembayaranNotification($pembayaran));

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                flash()->addError('Gagal menyimpan data pembayaran, ' . $th->getMessage());
                return back();
            }
        } else {
            flash()->addError('Jumlah pembayaran tidak boleh kurang dari total tagihan');
            return back();
        }

        flash('Pembayaran berhasil disimpan dan akan segera dikonfirmasi oleh operator');
        return redirect()->route('wali.pembayaran.show', $pembayaran->id);
    }

    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        if ($pembayaran->tanggal_konfirmasi != null) {
            return back();
            flash()->addError('Data pembayaran sudah dikonfirmasi, tidak bisa dihapus');
        }
        // bekas hapus notif operator
        // bekas hapus bukti bayar
        $pembayaran->delete();
        flash('Data pembayaran berhasil dibatalkan');
        return redirect()->route('wali.tagihan.index');
    }
}
