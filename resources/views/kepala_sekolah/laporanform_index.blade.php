@extends('layouts.app_niceadmin', ['title' => 'Form Laporan'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold fs-5" style="color: #012970;">FORM LAPORAN</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-title">
                                <i class="bi bi-patch-exclamation"></i>
                                Laporan Tagihan
                            </div>
                            @include('components.laporanform_tagihan')
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-title">
                                <i class="bi bi-patch-exclamation"></i>
                                Laporan Pembayaran
                            </div>
                            @include('components.laporanform_pembayaran')
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-title">
                                <i class="bi bi-patch-exclamation"></i>
                                Laporan Rekap Pembayaran
                            </div>
                            @include('components.laporanform_rekappembayaran')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
