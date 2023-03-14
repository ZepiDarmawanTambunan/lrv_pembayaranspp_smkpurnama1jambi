<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\StoreBankSekolahRequest;
use App\Http\Requests\UpdateBankSekolahRequest;
use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\BankSekolah as Model;
use App\Http\Controllers\Controller;

class BankSekolahController extends Controller
{
    private $viewIndex = 'banksekolah_index';
    private $viewCreate = 'banksekolah_form';
    private $viewEdit = 'banksekolah_form';
    private $viewShow = 'banksekolah_show';
    private $routePrefix = 'banksekolah';

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
        $models = Model::paginate(settings()->get('app_pagination', '20'));

        return view('user.' . $this->viewIndex, [
            'models' => $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'DATA REKENING SEKOLAH'
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
            'title' => 'FORM DATA REKENING SEKOLAH',
            'listBank' => Bank::pluck('nama_bank', 'id'),
        ];

        return view('user.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBankSekolahRequest $request)
    {
        $reqData = $request->validated();
        $bank = Bank::findOrFail($request['bank_id']);
        unset($reqData['bank_id']);
        $reqData['kode'] = $bank->sandi_bank;
        $reqData['nama_bank'] = $bank->nama_bank;
        Model::create($reqData);
        flash('Data berhasil disimpan');
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Model::findOrFail($id);
        $data = [
            'model' => $model,
            'method' => 'PUT',
            'route' => [$this->routePrefix . '.update', $id],
            'button' => 'UPDATE',
            'title' => 'FORM DATA REKENING SEKOLAH',
            'listBank' => Bank::pluck('nama_bank', 'sandi_bank'),
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
    public function update(UpdateBankSekolahRequest $request, $id)
    {
        $reqData = $request->validated();
        $model = Model::findOrFail($id);
        $bank = Bank::where('sandi_bank', $reqData['bank_id'])->first();
        unset($reqData['bank_id']);
        $reqData['kode'] = $bank->sandi_bank;
        $reqData['nama_bank'] = $bank->nama_bank;
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
            flash()->addError('data gagal dihapus karena terkait data lain');
            return back();
        }
        $model->delete();
        flash('Data berhasil dihapus');
        return back();
    }
}
