<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Session;

class TagihanLainStep2Controller extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if ($request->action == 'delete') {
            $siswaSession = session('data_siswa');
            $siswaData = $siswaSession->reject(function ($value) use ($request) {
                return $value->id == $request->id;
            });
            session(['data_siswa' => $siswaData]);
            flash('data berhasil dihapus');
            return back();
        }

        if ($request->action == 'deleteall') {
            session()->forget('data_siswa');
            flash('data berhasil dihapus');
            return back();
        }

        $siswaIdArray = $request->siswa_id;
        session(['data_siswa' => $siswaIdArray]);
        $siswa = Siswa::whereIn('id', $siswaIdArray)->get();
        Session::put('data_siswa', $siswa);
        return back();
    }
}
