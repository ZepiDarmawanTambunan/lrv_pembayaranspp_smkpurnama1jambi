<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBiayaRequest;
use App\Http\Requests\UpdateBiayaRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Biaya as Model;

class BiayaController extends Controller
{
    private $viewIndex = 'biaya_index';
    private $viewCreate = 'biaya_form';
    private $viewEdit = 'biaya_form';
    private $viewShow = 'biaya_show';
    private $routePrefix = 'biaya';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->filled('q')){
            $models = Model::with('user')->whereNull('parent_id')->search($request->q)->paginate(settings()->get('app_pagination', '20'));
        }else{
            $models = Model::with('user')->whereNull('parent_id')->latest()->paginate(settings()->get('app_pagination', '20'));
        }

        return view('operator.'.$this->viewIndex, [
            'models' => $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'DATA BIAYA'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $biaya = new Model();
        if($request->filled('parent_id')){
            $biaya = Model::with('children')->findOrFail($request->parent_id);
        }

        $data = [
            'parentData' => $biaya,
            'model' => new Model(),
            'method' => 'POST',
            'route' => $this->routePrefix.'.store',
            'button' => 'SIMPAN',
            'title' => 'FORM DATA BIAYA',
        ];

        return view('operator.'.$this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBiayaRequest $request)
    {
        $reqData = $request->validated();

        // jika parent Id tidak ada maka apa
        $hasParentId = array_key_exists('parent_id', $reqData);
        if(!$hasParentId){
            $request->validate([
                'nama' => 'required|min:3|max:255|unique:biayas,nama',
            ]);
        }else{
            $request->validate([
                'jumlah' => 'required|numeric|min:1000|max:999999',
            ]);
        }

        Model::create($reqData);
        flash()->addSuccess('Data berhasil ditambahkan!');
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
        return view('operator.'.$this->viewShow, [
            'model' => Model::findOrFail($id),
            'title' => 'DETAIL BIAYA'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $data = [
            'model' => Model::findOrFail($id),
            'method' => 'PUT',
            'route' => [$this->routePrefix.'.update', $id],
            'button' => 'UPDATE',
            'title' => 'FORM DATA BIAYA',
        ];

        return view('operator.'.$this->viewEdit, $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBiayaRequest $request, $id)
    {
        $reqData = $request->validated();
        $model = Model::findOrFail($id);
        $model->fill($reqData);
        $model->save();
        flash('Data berhasil diubah');
        return redirect()->route($this->routePrefix.'.index');
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
        if($model->siswa->count() >= 1){
            flash()->addError('Data gagal dihapus karena terkait data lain');
            return back();
        }
        if($model->children->count() >= 1){
            // cara manual bapak
            // flash()->addError('data tidak bisa dihapus karena masih ada item biaya, silahkan hapus terlebih dahulu');
            // return back();
            // cara otomatis saya
            $model->children()->delete();
        }
        $model->delete();
        flash('Data berhasil dihapus');
        return back();
    }

    public function deleteItem($id)
    {
        $model = Model::findOrFail($id);
        if($model->parent->siswa->count() >= 1){
            flash()->addError('Data gagal dihapus karena terkait data lain');
            return back();
        }
        $model->delete();
        flash('Data berhasil dihapus');
        return back();
    }
}
