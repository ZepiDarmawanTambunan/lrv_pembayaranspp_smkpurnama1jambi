@extends('layouts.app_niceadmin', ['title' => 'Pengaturan'])

@section('content')
    @include('components.operator.setting.setting_menu')
    <div class="row justify-content-center" style="min-height: 80vh;">
        <div class="col-md-12">
            {!! Form::open(['route' => 'setting.store', 'method' => 'POST', 'files' => true]) !!}
            <div class="card">
                <h5 class="card-header fw-bold fs-5" style="color: #012970;">PENGATURAN</h5>
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-patch-exclamation"></i>
                        Pengaturan Intansi
                    </h5>
                    <div class="form-group">
                        <label for="app_name" class="form-label">Nama Instansi</label>
                        {!! Form::text('app_name', settings()->get('app_name'), ['class' => 'form-control', 'autofocus', 'required']) !!}
                        <small class="text-danger">{{ $errors->first('app_name') }}</small>
                    </div>
                    <div class="form-group mt-3">
                        <label for="app_email" class="form-label">Email Intansi</label>
                        {!! Form::text('app_email', settings()->get('app_email'), [
                            'class' => 'form-control',
                            'required',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('app_email') }}</small>
                    </div>
                    <div class="form-group mt-3">
                        <label for="app_phone" class="form-label">No HP Intansi</label>
                        {!! Form::text('app_phone', settings()->get('app_phone'), [
                            'class' => 'form-control',
                            'required',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('app_phone') }}</small>
                    </div>
                    <div class="form-group mt-3">
                        <label for="app_address" class="form-label">Alamat Intansi</label>
                        {!! Form::text('app_address', settings()->get('app_address'), [
                            'class' => 'form-control',
                            'required',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('app_address') }}</small>
                    </div>
                    {!! Form::submit('UPDATE', ['class' => 'btn btn-primary pull-right mt-3']) !!}
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-patch-exclamation"></i>
                        Pengaturan Penanggung Jawab (<i style="font-size: 14px;">Data ini akan tampil di kwitansi dan kartu
                            spp</i>)
                    </h5>
                    <div class="form-group mt-3">
                        <label for="pj_nama" class="form-label">Nama Penanggung Jawab (cth: nama bendahara)</label>
                        {!! Form::text('pj_nama', settings()->get('pj_nama'), [
                            'class' => 'form-control',
                            'required',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('pj_nama') }}</small>
                    </div>
                    <div class="form-group mt-3">
                        <label for="pj_jabatan" class="form-label">Jabatan Penanggung Jawab (cth: bendahara)</label>
                        {!! Form::text('pj_jabatan', settings()->get('pj_jabatan'), [
                            'class' => 'form-control',
                            'required',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('pj_jabatan') }}</small>
                    </div>
                    <div class="form-group mt-3">
                        <label for="pj_ttd">Upload Gambar Tanda Tangan <u>(Format: jpg, jpeg, png. Maks: 5MB)</u>
                        </label>
                        {!! Form::file('pj_ttd', ['class' => 'form-control', 'accept' => 'image/*']) !!}
                        <span class="text-danger">{{ $errors->first('pj_ttd') }}</span>
                        @if (settings()->get('pj_ttd') != null)
                            <div class="mt-3">
                                <img src="{{ \Storage::url(settings()->get('pj_ttd')) }}" width="200"
                                    class="img-thumbnail">
                            </div>
                        @endif
                    </div>
                    {!! Form::submit('UPDATE', ['class' => 'btn btn-primary pull-right mt-3']) !!}
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-patch-exclamation"></i>
                        Pengaturan Aplikasi
                    </h5>
                    <div class="form-group">
                        <label for="app_pagination" class="form-label">Data Per Halaman</label>
                        {!! Form::text('app_pagination', settings()->get('app_pagination'), [
                            'class' => 'form-control',
                            'required' => 'required',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('app_pagination') }}</small>
                    </div>
                    <div class="form-group mt-3">
                        <label for="no_wa_operator" class="form-label">Nomor Whatsapp Operator (Cth: 62812434334)</label>
                        {!! Form::text('no_wa_operator', settings()->get('no_wa_operator'), [
                            'class' => 'form-control',
                            'required' => 'required',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('no_wa_operator') }}</small>
                    </div>
                    <div class="form-group mt-3">
                        <label for="app_logo">Upload Logo Sekolah <u>(Format: jpg, jpeg, png. Maks: 5MB)</u>
                        </label>
                        {!! Form::file('app_logo', ['class' => 'form-control', 'accept' => 'image/*']) !!}
                        <span class="text-danger">{{ $errors->first('app_logo') }}</span>
                        @if (settings()->get('app_logo') != null)
                            <div class="mt-3">
                                <img src="{{ \Storage::url(settings()->get('app_logo')) }}" width="200"
                                    class="img-thumbnail">
                            </div>
                        @endif
                    </div>
                    {!! Form::submit('UPDATE', ['class' => 'btn btn-primary pull-right mt-3']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
