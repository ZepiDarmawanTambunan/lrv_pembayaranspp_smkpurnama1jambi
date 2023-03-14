<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\User as Model;
use App\Models\Siswa;
use App\Http\Controllers\Controller;

class WaliController extends Controller
{
    private $viewIndex = 'wali_index';
    private $viewCreate = 'user_form';
    private $viewEdit = 'user_form';
    private $viewShow = 'wali_show';
    private $routePrefix = 'wali';

    /**
     * constructor.
     * @param array $lines
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->routePrefix = auth()->user()->akses . '.' . $this->routePrefix;
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $models = Model::wali()->latest();
        if ($request->filled('q')) {
            $models = $models->search($request->q);
        }

        return view('user.' . $this->viewIndex, [
            'models' => $models->paginate(settings()->get('app_pagination', '20')),
            'routePrefix' => $this->routePrefix,
            'title' => 'DATA WALI MURID'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'model' => new Model(),
            'method' => 'POST',
            'route' => $this->routePrefix . '.store',
            'button' => 'SIMPAN',
            'title' => 'Form Data Wali Murid',
        ];

        return view('user.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reqData = $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email|min:5|max:255',
            'nohp' => 'required|unique:users,nohp|min:11|max:14',
            'password' => 'required'
        ]);
        $reqData['password'] = bcrypt($reqData['password']);
        $reqData['email_verified_at'] = now();
        $reqData['akses'] = 'wali';
        Model::create($reqData);
        flash('Data berhasil disimpan');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('user.' . $this->viewShow, [
            'siswa' => Siswa::WhereNull('wali_id')
                ->pluck('nama', 'id'),
            'model' => Model::with('siswa')->wali()->findOrFail($id),
            'title' => 'DETAIL WALI MURID'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'model' => Model::findOrFail($id),
            'method' => 'PUT',
            'route' => [$this->routePrefix . '.update', $id],
            'button' => 'UPDATE',
            'title' => 'FORM DATA WALI MURID',
        ];

        return view('user.' . $this->viewEdit, $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reqData = $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|min:5|max:255|unique:users,email,' . $id,
            'nohp' => 'required|min:11|max:14|unique:users,nohp,' . $id,
            'password' => 'nullable'
        ]);
        $model = Model::findOrFail($id);
        if ($reqData['password'] == "") {
            unset($reqData['password']);
        } else {
            $reqData['password'] = bcrypt($reqData['password']);
        }
        $model->fill($reqData);
        $model->save();
        flash('Data berhasil diubah');
        return redirect()->route($this->routePrefix . '.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Model::findOrFail($id);
        if ($model->pembayaran->count() >= 1) {
            flash()->addError('Data tidak bisa dihapus karena memiliki relasi dengan data tagihan');
            return back();
        }
        $model->siswa()->update(['wali_id' => NULL]);
        $model->delete();
        flash('Data berhasil dihapus');
        return back();
    }
}
