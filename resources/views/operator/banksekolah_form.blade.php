@extends('layouts.app_niceadmin', ['title' => 'Form Rekening'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold fs-5" style="color: #012970;">{{ $title }}</h5>

                <div class="card-body">
                    {!! Form::model($model, ['route' => $route, 'method' => $method, 'files' => true]) !!}
                    <div class="form-group mt-3">
                        <label for="bank_id" class="form-label">Nama Bank</label>
                        {!! Form::select('bank_id', $listBank, $model->kode ?? null, [
                            'class' => 'form-control select2',
                            $method == 'PUT' ? 'disabled' : '',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('bank_id') }}</small>
                    </div>
                    <div class="form-group mt-3">
                        <label for="nomor_rekening" class="form-label">Nomor Rekening</label>
                        {!! Form::number('nomor_rekening', null, [
                            'class' => 'form-control',
                            'required' => 'required',
                            $method == 'PUT' ? 'disabled' : '',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('nomor_rekening') }}</small>
                    </div>
                    <div class="form-group mt-3">
                        <label for="nama_rekening" class="form-label">Pemilik Rekening</label>
                        {!! Form::text('nama_rekening', null, [
                            'class' => 'form-control',
                            'required' => 'required',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('nama_rekening') }}</small>
                    </div>
                    {!! Form::submit($button, ['class' => 'btn btn-primary pull-right mt-3']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
