@extends('layouts.app_niceadmin', ['title' => $title])

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold fs-5" style="color: #012970;">{{ strtoupper($title) }}</h5>
                <div class="card-body">
                    {!! Form::model($model, ['route' => $route, 'method' => $method]) !!}
                    <div class="form-group mt-3">
                        <label for="name" class="form-label">Nama</label>
                        {!! Form::text('name', null, ['class' => 'form-control', 'autofocus', 'required']) !!}
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                    </div>
                    <div class="form-group mt-3">
                        <label for="email" class="form-label">Email</label>
                        {!! Form::email('email', null, [
                            'class' => 'form-control',
                            'required' => 'required',
                            'placeholder' => 'eg: foo@bar.com',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('email') }}</small>
                    </div>
                    <div class="form-group mt-3">
                        <label for="nohp" class="form-label">No HP</label>
                        {!! Form::number('nohp', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        <small class="text-danger">{{ $errors->first('nohp') }}</small>
                    </div>
                    @if (\Route::is(auth()->user()->akses . '.user.create'))
                        {!! Form::hidden('akses', 'operator', []) !!}
                    @endif
                    @if (\Route::is(auth()->user()->akses . '.user.edit'))
                        {!! Form::hidden('akses', null, []) !!}
                    @endif
                    <div class="form-group mt-3">
                        <label for="password" class="form-label">Password</label>
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                        <small class="text-danger">{{ $errors->first('password') }}</small>
                    </div>
                    {!! Form::submit($button, ['class' => 'btn btn-primary pull-right mt-3']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
