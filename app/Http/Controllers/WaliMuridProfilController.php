<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class WaliMuridProfilController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'model' => User::findOrFail(Auth::user()->id),
            'method' => 'POST',
            'route' => 'wali.profil.store',
            'button' => 'UBAH',
            'title' => 'FORM UBAH PROFIL',
        ];

        return view('wali.profil_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = Auth::user()->id;
        $reqData = $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|min:5|max:255|unique:users,email,'.$id,
            'nohp' => 'required|min:11|max:14|unique:users,nohp,'.$id,
            'password' => 'nullable'
        ]);
        $model = User::findOrFail($id);
        if($reqData['password'] == ""){
            unset($reqData['password']);
        }else{
            $reqData['password'] = bcrypt($reqData['password']);
        }
        $model->fill($reqData);
        $model->save();
        flash('Data berhasil diubah');
        return back();
    }
}
