<?php

namespace App\Http\Controllers\KepalaSekolah;

use Illuminate\Http\Request;
use App\Services\WhacenterService;
use App\Http\Controllers\Controller;


class SettingWhacenterController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $ws = new WhacenterService();
            $statusKoneksiWa = $ws->getDeviceStatus();
        } catch (\Throwable $th) {
            $statusKoneksiWa = false;
        }
        return view('kepala_sekolah.settingwhacenter_form', [
            'statusKoneksiWa' => $statusKoneksiWa,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->wha_device_id == null) {
            $request['wha_device_id'] = settings('wha_device_id') ?? "752b407354a24d4d0d530caaf921562c";
        }
        $dataSetting = $request->except('_token');
        settings()->set($dataSetting);
        if ($request->has('tes_whacenter')) {
            $ws = new WhacenterService();
            $statusSend = $ws->line('Testing koneksi WA')->to($request->tes_whacenter)->send();
            if ($statusSend) {
                flash('Data sudah diproses. Status ' . $ws->getMessage());
                return back();
            }
            flash()->addError('Data gagal diproses. Status ' . $ws->getMessage());
            return back();
        }
        flash('Data sudah disimpan');
        return back();
    }
}
