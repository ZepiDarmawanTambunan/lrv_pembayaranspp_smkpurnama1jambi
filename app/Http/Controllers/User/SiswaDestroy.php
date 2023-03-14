<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class SiswaDestroy extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $berhasilDihapus = 0;
        $gagalDihapus = 0;
        $message = 'Data berhasil dihapus';

        for ($i = 0; $i < count($request->siswa_id); $i++) {
            $siswa = Siswa::where('id', $request->siswa_id[$i])->first();
            if ($siswa != null) {
                if ($siswa->tagihan->count() < 1) {
                    if ($siswa->foto != null && Storage::exists($siswa->foto)) {
                        Storage::delete($siswa->foto);
                    }
                    $siswa->delete();
                    $berhasilDihapus += 1;
                } else {
                    $gagalDihapus += 1;
                }
            }
        }
        $message  = $message . ' : ' . $berhasilDihapus;
        if ($gagalDihapus > 0) {
            $message = $message . ' | Data gagal dihapus : ' . $gagalDihapus;
        }

        return response()->json([
            'message' => $message,
        ], 200);
    }
}
