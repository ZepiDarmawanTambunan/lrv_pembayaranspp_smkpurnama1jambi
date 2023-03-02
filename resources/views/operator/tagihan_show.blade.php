@extends('layouts.app_niceadmin', ['title' => 'Detail Tagihan'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('components.operator.tagihan_show.data_siswa')
        </div>
    </div>

    <div class="row">
        <div class="col-md-{{ $tagihan->jenis == 'spp' ? '5' : '12' }}">
            @include('components.operator.tagihan_show.data_tagihan')
            @include('components.operator.tagihan_show.data_form')
        </div>
        @if ($tagihan->jenis == 'spp')
            <div class="col-md-7">
                @include('components.operator.tagihan_show.data_kartuspp')
            </div>
        @endif
    </div>
@endsection
