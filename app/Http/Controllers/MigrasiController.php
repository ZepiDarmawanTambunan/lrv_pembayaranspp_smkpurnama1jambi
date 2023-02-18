<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Biaya;
use App\Models\User;
use DB;

class MigrasiController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'listKelas' => getNamaKelas(),
            'listStatus' => getStatusSiswa(),
            'listJurusan' => getNamaJurusan(),
            'listBiaya' => Biaya::whereNull('parent_id')->pluck('nama', 'id'),
            'method' => 'POST',
            'route' => ['migrasiform.store'],
            'button' => 'PINDAH',
            'title' => 'FORM MIGRASI SISWA',
            'url' => route('migrasiform.index'),
            'siswa' => Siswa::orderBy('kelas', 'DESC')->orderBy('jurusan', 'DESC')->orderBy('biaya_id', 'DESC'),
        ];
        $data['siswa_all'] = $data['siswa']->pluck('id')->toArray();

        if($request->kelas_asal_id != null){
            $data['siswa'] = $data['siswa']->where('kelas', $request->kelas_asal_id);
        }
        if($request->jurusan_asal_id != null){
            $data['siswa'] = $data['siswa']->where('jurusan', $request->jurusan_asal_id);
        }
        if($request->biaya_asal_id != null){
            $data['siswa'] = $data['siswa']->where('biaya_id', $request->biaya_asal_id);
        }

        if($request->status_asal_id != null){
            $data['siswa'] = $data['siswa']->get()->where('status', $request->status_asal_id);
        }else{
            $data['siswa'] = $data['siswa']->get();
        }
        return view('operator.migrasi_form', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id.*' => 'required|exists:siswas,id',
            'kelas_tujuan_id' => 'nullable',
            'jurusan_tujuan_id' => 'nullable',
            'biaya_tujuan_id' => 'nullable',
            'status_tujuan_id' => 'nullable',
        ]);

        if($request->siswa_id != null){
            $siswa = Siswa::query()->whereIn('id', $request->siswa_id);

            if($request->kelas_tujuan_id != null){
                // ubah kelas
                $siswa->update(['kelas' => $request->kelas_tujuan_id]);
            }
            if($request->jurusan_tujuan_id != null){
                // ubah jurusan
                $siswa->update(['jurusan' => $request->jurusan_tujuan_id]);
            }
            if($request->biaya_tujuan_id != null){
                // ubah biaya
                $siswa->update(['biaya_id' => $request->biaya_tujuan_id]);
            }
            if($request->status_tujuan_id != null){
                // ubah status
                foreach ($siswa->get() as $key => $value) {
                    $value->setStatus($request->status_tujuan_id);
                    $value->save();
                }
            }
        }

        flash()->addSuccess('Data berhasil dimigrasi');
        return back();
    }
}
