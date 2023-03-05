<?php

namespace App\Http\Controllers;

use App\Models\Biaya;
use App\Models\Siswa;
use Illuminate\Http\Request;

class TagihanLainStepController extends Controller
{
    public function create(Request $request)
    {
        if ($request->step == 1) {
            return $this->step1();
        }
        if ($request->step == 2) {
            return $this->step2();
        }
        if ($request->step == 3) {
            return $this->step3();
        }
        if ($request->step == 4) {
            return $this->step4();
        }
    }

    public function step1()
    {
        session()->forget('step');
        session()->forget('data_siswa');
        session()->forget('tagihan_untuk');
        $data['activeStep1'] = 'active';
        return view('operator.tagihanlain_step1', $data);
    }

    public function step2()
    {
        session(['tagihan_untuk' => request('tagihan_untuk') ?? session('tagihan_untuk')]);

        // handle null request
        if (session('tagihan_untuk') == "" || !session()->has('tagihan_untuk')) {
            flash()->addError('Silahkan pilih tagihan untuk siapa');
            return redirect()->route('tagihanlainstep.create', ['step' => 1]);
        }

        // step 1 (semua) -> step 3
        if (session('tagihan_untuk') == 'semua' && !session()->has('step')) {
            return redirect()->route('tagihanlainstep.create', ['step' => 3]);
        }

        // step 3 (semua) -> step 1
        if (session('tagihan_untuk') == 'semua' && session('step') == 'step3') {
            return redirect()->route('tagihanlainstep.create', ['step' => 1]);
        }

        // step 1 (pilihan) -> step 2
        $query = Siswa::query();
        if (request()->filled('cari')) {
            $query->when(request()->filled('nama'), function ($query) {
                $query->where('nama', 'like', '%' . request('nama') . '%');
            })->when(request()->filled('kelas'), function ($query) {
                $query->where('kelas', request('kelas'));
            })->when(request()->filled('angkatan'), function ($query) {
                $query->where('angkatan', request('angkatan'));
            });
        }
        $data['siswa'] = $query->get()->each(function ($q) {
            $q->checked = false; // set data
            if (!empty(session('data_siswa'))) {
                if (session('data_siswa')->contains('id', $q->id)) {
                    $q->checked = true; // set data
                }
            }
        });

        $data['activeStep2'] = 'active';
        return view('operator.tagihanlain_step2', $data);
    }

    public function step3()
    {
        session(['step' =>  'step3']);

        // handle null
        if (!session()->has('tagihan_untuk')) {
            flash()->addError('silahkan pilih tagihan untuk siapa');
            return redirect()->route('tagihanlainstep.create', ['step' => 1]);
        }

        if (!session()->has('data_siswa') && session('tagihan_untuk') == 'pilihan') {
            flash()->addError('silahkan cari lalu simpan siswa');
            return redirect()->route('tagihanlainstep.create', ['step' => 2]);
        }

        $data['activeStep3'] = 'active';
        $data['biayaList'] = Biaya::whereNull('parent_id')->pluck("nama", "id");
        return view('operator.tagihanlain_step3', $data);
    }

    public function step4()
    {
        // handle null
        if (!session()->has('tagihan_untuk') && request('biaya_id') == "") {
            flash()->addError('silahkan pilih biaya yang akan ditagihkan');
            return redirect()->route('tagihanlainstep.create', ['step' => 3]);
        }
        session(['biaya_id' => request('biaya_id')]);
        $data['activeStep4'] = 'active';
        $data['biaya'] = Biaya::findOrFail(request('biaya_id'));
        if (session('tagihan_untuk') == 'semua') {
            $data['siswa'] = Siswa::all();
        } else {
            $data['siswa'] = Siswa::whereIn('id', session('data_siswa')->pluck('id'))->get();
        }
        return view('operator.tagihanlain_step4', $data);
    }
}
