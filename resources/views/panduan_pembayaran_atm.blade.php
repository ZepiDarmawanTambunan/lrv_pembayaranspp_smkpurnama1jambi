@extends('layouts.app_niceadmin_blank')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-5">
                    <h5 class="card-header fw-bold fs-5" style="color: #012970;">
                        PANDUAN PEMBAYARAN MELALUI ATM
                    </h5>
                    <div class="card-body">
                        <h4 class="card-title">
                            <b>Berikut cara melakukan transfer lewat ATM : </b>
                        </h4>
                        <div>
                            <ol>
                                <li>Masukkan kartu debit ke mesin <b>ATM</b>.</li>
                                <li>Pilih bahasa.</li>
                                <li>Masukkan nomor PIN.</li>
                                <li>Pilih menu <b>transfer</b>.</li>
                                <li>Pilih tujuan <b>transfer</b>: antarrekening atau antarbank.</li>
                                <li>Masukkan kode bank jika memilih <b>transfer</b> antarbank.</li>
                                <li>Masukkan nominal <b>transfer</b>.</li>
                                <li>Cek kembali informasi <b>transfer</b>.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
