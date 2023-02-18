<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;

class WaliSiswaController extends Controller
{
    public function store(Request $request)
    {
        $reqData = $request->validate([
            'wali_id' => 'required|exists:users,id',
            'siswa_id' => 'required|exists:siswas,id'
        ]);

        $siswa = Siswa::find($request->siswa_id);
        $siswa->wali_id = $request->wali_id;
        $siswa->save();
        flash('Data sudah ditambahkan');
        return back();
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->wali_id = null;
        $siswa->save();
        flash('Data sudah dihapus');
        return back();
    }
}
