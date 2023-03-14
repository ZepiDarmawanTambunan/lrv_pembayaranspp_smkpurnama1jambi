<?php

namespace App\Http\Controllers\User;

use App\Models\Pembayaran as Model;
use App\Models\Tagihan;
use App\Models\Siswa;
use App\Http\Requests\StorePembayaranRequest;
use Illuminate\Http\Request;
use App\Notifications\PembayaranKonfirmasiNotification;
use App\Http\Controllers\Controller;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $models = Model::latest();
        if ($request->filled('bulan')) {
            $models->whereMonth('tanggal_bayar', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $models->whereYear('tanggal_bayar', $request->tahun);
        }
        if ($request->filled('status')) {
            if ($request->status == 'sudah-dikonfirmasi') {
                $models->whereNotNull('tanggal_konfirmasi');
            }
            if ($request->status == 'belum-dikonfirmasi') {
                $models->whereNull('tanggal_konfirmasi');
            }
        }
        if ($request->filled('q')) {
            // CARA ZEPI
            $siswa = Siswa::search($request->q)->pluck('id');
            $tagihan = Tagihan::whereIn('siswa_id', $siswa)->pluck('id');
            $models->whereIn('tagihan_id', $tagihan);

            // CARA PAK AIM
            $models->whereHas('tagihan', function ($t) use ($request) {
                $t->whereHas('siswa', function ($s) use ($request) {
                    $s->where('nama', 'like', '%' . $request->q . '%');
                });
            });
        }
        return view('user.pembayaran_index', [
            'models' => $models->orderBy('tanggal_konfirmasi', 'desc')
                ->paginate(settings()->get('app_pagination', '20')),
        ]);
    }

    public function store(StorePembayaranRequest $request)
    {
        $requestData = $request->validated();
        $tagihan = Tagihan::findOrFail($requestData['tagihan_id']);
        $requestData['tanggal_konfirmasi'] = now();
        $requestData['metode_pembayaran'] = 'manual';
        $requestData['wali_id'] = $tagihan->siswa->wali_id;
        $pembayaran = Model::create($requestData);
        // $tagihan->updateStatus();
        $wali = $pembayaran->wali;
        if ($wali != null) {
            $wali->notify(new PembayaranKonfirmasiNotification($pembayaran));
        }
        flash('Pembayaran berhasil disimpan');
        return back();
    }

    public function show(Model $pembayaran)
    {
        auth()->user()->unreadNotifications->where('id', request('id'))->first()?->markAsRead();

        return view('user.pembayaran_show', [
            'model' => $pembayaran,
            'route' => [auth()->user()->akses . '.pembayaran.update', $pembayaran->id],
        ]);
    }

    public function update(Request $request, Model $pembayaran)
    {
        $pembayaran->tanggal_konfirmasi = now();
        $pembayaran->user_id = auth()->user()->id;
        $pembayaran->save();
        // $pembayaran->tagihan->updateStatus();
        $wali = $pembayaran->wali;
        if ($wali != null) {
            $wali->notify(new PembayaranKonfirmasiNotification($pembayaran));
        }
        flash('Data pembayaran berhasil disimpan');
        return back();
    }

    public function destroy(Model $pembayaran)
    {
        // if transfer namun blm konfirmasi dak boleh dihapus
        if ($pembayaran->metode_pembayaran == 'transfer' && $pembayaran->tanggal_konfirmasi != null) {
            flash()->addError('Data pembayaran yang telah dikonfirmasi tidak bisa dihapus !');
            return back();
        }
        // bekas hapus notif wali
        // bekas hapus bukti bayar
        $pembayaran->delete();
        flash('Data pembayaran berhasil dihapus');
        return back();
    }
}
