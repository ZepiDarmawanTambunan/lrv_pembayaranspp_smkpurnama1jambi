<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\User as Model;
use Auth;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    private $viewIndex = 'user_index';
    private $viewCreate = 'user_form';
    private $viewEdit = 'user_form';
    private $viewShow = 'user_show';
    private $routePrefix = 'user';

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
    public function index()
    {
        return view('user.' . $this->viewIndex, [
            'models' => Model::where('akses', '!=', 'wali')
                ->latest()
                ->paginate(settings()->get('app_pagination', '20')),
            'routePrefix' => $this->routePrefix,
            'title' => 'DATA USER'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // new Model() berfungsi
        $data = [
            'model' => new Model(),
            'method' => 'POST',
            'route' => $this->routePrefix . '.store',
            'button' => 'SIMPAN',
            'title' => 'Form Data User',
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
            'akses' => 'required|in:operator,admin',
            'password' => 'required'
        ]);
        $reqData['password'] = bcrypt($reqData['password']);
        $reqData['email_verified_at'] = now();
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
        //
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
            'title' => 'FORM DATA USER',
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
            'akses' => 'required|in:operator,admin',
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
        if (auth()->user()->akses == 'operator') {
            return back();
        }
        return redirect()->route(auth()->user()->akses . '.user.index');
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
        if ($model->email == 'operator@gmail.com') {
            flash()->addError('Data tidak bisa dihapus');
            return back();
        }
        if ($model->email == Auth::user()->email) {
            flash()->addError('Data tidak bisa dihapus');
            return back();
        }
        $model->delete();
        flash('Data berhasil dihapus');
        return back();
    }
}
