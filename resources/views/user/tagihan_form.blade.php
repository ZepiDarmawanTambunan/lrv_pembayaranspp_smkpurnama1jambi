@extends('layouts.app_niceadmin', ['title' => 'Form Data Tagihan'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold fs-5" style="color: #012970;">{{ $title }}</h5>
                <div class="card-body">
                    {!! Form::model($model, ['route' => $route, 'method' => $method, 'id' => 'form-ajax']) !!}

                    <div class="form-group mt-3">
                        <label for="siswa_id" class="form-label">Pilih Siswa atau Biarkan kosong</label>
                        {!! Form::select('siswa_id', $siswaList, null, [
                            'class' => 'form-control select2',
                            'placeholder' => 'Pilih Siswa',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('siswa_id') }}</small>
                    </div>

                    <div class="form-group mt-3">
                        <label for="tanggal_tagihan" class="form-label">Tanggal Tagihan</label>
                        {!! Form::date('tanggal_tagihan', $model->tanggal_tagihan ?? date('Y-m-') . '01', [
                            'class' => 'form-control',
                            'required' => 'required',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('tanggal_tagihan') }}</small>
                    </div>

                    <div class="form-group mt-3">
                        <label for="tanggal_jatuh_tempo" class="form-label">Tanggal Jatuh Tempo</label>
                        {!! Form::date('tanggal_jatuh_tempo', $model->tanggal_jatuh_tempo ?? date('Y-m-15', strtotime('+1 month')), [
                            'class' => 'form-control',
                            'required' => 'required',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('tanggal_jatuh_tempo') }}</small>
                    </div>

                    <div class="form-group mt-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        {!! Form::textarea('keterangan', null, [
                            'class' => 'form-control',
                            'rows' => 3,
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('keterangan') }}</small>
                    </div>

                    {!! Form::submit($button, ['class' => 'btn btn-primary pull-right mt-3']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
