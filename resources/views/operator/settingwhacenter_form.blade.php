@extends('layouts.app_niceadmin', ['title' => 'Pengaturan Wha Center'])

@section('content')
    @include('components.operator.setting.setting_menu')

    <div class="row justify-content-center" style="min-height: 80vh;">
        <div class="col-md-12">
            {!! Form::open(['route' => 'settingwhacenter.store', 'method' => 'POST']) !!}
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-patch-exclamation"></i>
                        Pengaturan Whacenter
                    </h5>
                    <div class="form-group mt-3">
                        Device ID : {{ settings('wha_device_id') }}
                    </div>
                    <div class="form-group mt-3">
                        <label for="wha_device_id" class="form-label">Device ID Whacenter: </label>
                        {!! Form::text('wha_device_id', null, [
                            'class' => 'form-control',
                            'autocomplete' => 'off',
                            'placeholder' => 'Masukan Device ID WhaCenter',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('wha_device_id') }}</small>
                    </div>
                    <div class="form-group mt-3">
                        Status Device : <span class="badge bg-{{ $statusKoneksiWa ? 'primary' : 'danger' }}">
                            {{ $statusKoneksiWa ? 'Connected' : 'Not Connected' }}
                        </span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="tes_whacenter" class="form-label">Tes Kirim Whatsapp ke Nomor berikut: </label>
                        {!! Form::number('tes_whacenter', settings()->get('tes_whacenter'), [
                            'class' => 'form-control',
                            'placeholder' => 'Masukan nomor wa cth: 6282131231',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('tes_whacenter') }}</small>
                    </div>
                    {!! Form::submit('UPDATE', ['class' => 'btn btn-primary pull-right mt-3']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
