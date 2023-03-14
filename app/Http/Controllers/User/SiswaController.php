<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Biaya;
use App\Charts\SiswaKelasChart;
use App\Models\Siswa as Model;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class SiswaController extends Controller
{
    private $viewIndex = 'siswa_index';
    private $viewCreate = 'siswa_form';
    private $viewEdit = 'siswa_form';
    private $viewShow = 'siswa_show';
    private $routePrefix = 'siswa';

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
    public function index(Request $request, SiswaKelasChart $siswaKelasChart)
    {
        $models = Model::with('wali', 'user')->latest();
        if ($request->filled('q')) {
            $models = $models->search($request->q);
        }

        return view('user.' . $this->viewIndex, [
            'models' => $models->paginate(settings()->get('app_pagination', '20')),
            'routePrefix' => $this->routePrefix,
            'title' => 'DATA SISWA',
            'siswaKelasChart' => $siswaKelasChart->build(),
        ]);

        // return $dataTable->render('operator.siswa_indexv2');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'listBiaya' => Biaya::whereNull('parent_id')->has('children')->pluck('nama', 'id'),
            'model' => new Model(),
            'method' => 'POST',
            'route' => $this->routePrefix . '.store',
            'button' => 'SIMPAN',
            'title' => 'FORM DATA SISWA',
            'wali' => User::where('akses', 'wali')->pluck('name', 'id'),
        ];
        return view('user.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSiswaRequest $request)
    {
        // $requestData = $request->validate([...]); old
        $requestData = $request->validated();
        if ($request->hasFile('foto')) {
            $reqData['foto'] = $request->file('foto')->store('public');
        }

        Model::create($requestData);

        // tes
        return response()->json([
            'message' => 'Data berhasil disimpan',
        ], 200);
        // tes

        // flash()->addSuccess('Data berhasil disimpan');
        // return back();
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
            'model' => Model::findOrFail($id),
            'title' => 'DETAIL SISWA'
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
            'listBiaya' => Biaya::whereNull('parent_id')->has('children')->pluck('nama', 'id'),
            'model' => Model::findOrFail($id),
            'method' => 'PUT',
            'route' => [$this->routePrefix . '.update', $id],
            'button' => 'UPDATE',
            'title' => 'FORM DATA SISWA',
            'wali' => User::where('akses', 'wali')->pluck('name', 'id'),
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
    public function update(UpdateSiswaRequest $request, $id)
    {
        $reqData = $request->validated();

        $model = Model::findOrFail($id);

        if ($request->hasFile('foto')) {
            if ($model->foto != null && Storage::exists($model->foto)) {
                Storage::delete($model->foto);
            }
            $reqData['foto'] = $request->file('foto')->store('public');
        }

        $model->fill($reqData);
        $model->save();
        // tes
        return response()->json([
            'message' => 'Data berhasil diubah',
        ], 201);
        // tes

        // flash()->addSuccess('Data berhasil diubah');
        // return redirect()->route($this->routePrefix.'.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $siswa = Model::findOrFail($id);
        if ($siswa->tagihan->count() >= 1) {
            flash()->addError('Data tidak bisa dihapus karena memiliki relasi dengan data tagihan');
            return back();
        }
        if ($siswa->foto != null && Storage::exists($siswa->foto)) {
            Storage::delete($siswa->foto);
        }
        $siswa->delete();
        flash()->addSuccess('Data berhasil dihapus');
        return back();
    }
}
