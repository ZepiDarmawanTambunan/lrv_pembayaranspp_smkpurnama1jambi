<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Settings;
use Illuminate\Support\Facades\Storage;
use App\Services\WhacenterService;

class SettingController extends Controller
{
    public function create()
    {
        return view('operator.setting_form');
    }

    public function store(Request $request)
    {
        $dataSetting = $request->except('_token');
        if($request->hasFile('pj_ttd')){
            $request->validate([
                'pj_ttd' => 'required|image|mimes:jpeg,png,jpg,svg|max:5048',
            ]);
            if(settings()->get('pj_ttd') && Storage::exists(settings()->get('pj_ttd'))){
                Storage::delete(settings()->get('pj_ttd'));
            }
            $dataSetting['pj_ttd'] = $request->file('pj_ttd')->store('public');
        }

        if($request->hasFile('app_logo')){
            $request->validate([
                'app_logo' => 'required|image|mimes:jpeg,png,jpg,svg|max:5048',
            ]);
            if(settings()->get('app_logo') && Storage::exists(settings()->get('app_logo'))){
                Storage::delete(settings()->get('app_logo'));
            }
            $dataSetting['app_logo'] = $request->file('app_logo')->store('public');
        }

        settings()->set($dataSetting);
        flash('Data sudah disimpan');
        return back();
    }
}
