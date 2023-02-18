@extends('layouts.app_niceadmin', ['title' => 'Form Data Pembayaran'])

@section('js')
    <script>
        $(function() {
            $("#checkboxtoggle").click(function() {
                if ($(this).is(":checked")) {
                    $("#pilihan_bank").fadeOut();
                    $("#form_bank_pengirim").fadeIn();
                    $("#checkboxrekeningbaru").removeClass('mt-3');
                } else {
                    $("#pilihan_bank").fadeIn();
                    $("#form_bank_pengirim").fadeOut();
                    $("#checkboxrekeningbaru").addClass('mt-3');
                }
            });
        });

        $(document).ready(function() {
            @if (count($listWaliBank) >= 1)
                $("#form_bank_pengirim").hide();
            @else
                $("#form_bank_pengirim").show();
            @endif
            $('#pilih_bank').change(function(e) {
                var bankId = $(this).find(':selected').val();
                window.location.href = '{!! $url !!}&bank_sekolah_id=' + bankId;
            });
        });
    </script>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold fs-5" style="color: #012970;">KONFIRMASI PEMBAYARAN</h5>
                <div class="card-body mt-3">
                    {!! Form::model($model, ['route' => $route, 'method' => $method, 'files' => true]) !!}
                    {!! Form::hidden('tagihan_id', request('tagihan_id'), []) !!}
                    <h5 class="card-title">
                        <i class="bi bi-patch-exclamation"></i>
                        Informasi Rekening Pengirim
                    </h5>

                    @if (count($listWaliBank) >= 1)
                        <div class="alert alert-dark" role="alert">
                            <div class="form-group" id="pilihan_bank">
                                <label for="wali_bank_id">Bank Pengirim</label>
                                {!! Form::select('wali_bank_id', $listWaliBank, null, [
                                    'class' => 'form-control select2',
                                    'placeholder' => 'Pilih Bank Pengirim',
                                ]) !!}
                                <span class="text-danger">{{ $errors->first('wali_bank_id') }}</span>
                            </div>

                            <div class="form-check mt-3" id="checkboxrekeningbaru">
                                {!! Form::checkbox('pilihan_bank', 1, false, [
                                    'class' => 'form-check-input',
                                    'id' => 'checkboxtoggle',
                                ]) !!}
                                <label class="form-check-label" for="checkboxtoggle"> Buat Rekening Baru
                                    akan datang </label>
                            </div>
                        </div>
                    @else
                        {!! Form::hidden('pilihan_bank', 1, []) !!}
                    @endif

                    <div class="alert alert-dark" role="alert" id="form_bank_pengirim">
                        <div class="form-group">
                            <label for="bank_id">Bank Pengirim</label>
                            {!! Form::select('bank_id', $listBank, null, [
                                'class' => 'form-control select2',
                                'placeholder' => 'Pilih Bank Pengirim',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('bank_id') }}</span>
                        </div>
                        <div class="form-group mt-3">
                            <label for="nama_rekening">Nama Pemilik Rekening</label>
                            {!! Form::text('nama_rekening', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('nama_rekening') }}</span>
                        </div>
                        <div class="form-group mt-3">
                            <label for="nomor_rekening">Nomor Rekening Pengirim</label>
                            {!! Form::text('nomor_rekening', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('nomor_rekening') }}</span>
                        </div>
                    </div>


                    <h5 class="card-title">
                        <i class="bi bi-patch-exclamation"></i>
                        Informasi Rekening Tujuan
                    </h5>
                    <div class="alert alert-dark" role="alert">
                        <div class="form-group">
                            <label for="bank_sekolah_id">Bank Tujuan</label>
                            {!! Form::select('bank_sekolah_id', $listBankSekolah, request('bank_sekolah_id'), [
                                'class' => 'form-control',
                                'placeholder' => 'Pilih Bank Tujuan',
                                'id' => 'pilih_bank',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('bank_sekolah_id') }}</span>
                        </div>
                        @if (request('bank_sekolah_id') != '')
                            <div class="mt-3 mb-2">
                                <table width="100%">
                                    <tbody>
                                        <tr>
                                            <td width="18%">Bank Tujuan</td>
                                            <td>: {{ Str::limit($bankYangDipilih->nama_bank, 20) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nomor Rekening</td>
                                            <td>: {{ $bankYangDipilih->nomor_rekening }}</td>
                                        </tr>
                                        <tr>
                                            <td>Atas Nama</td>
                                            <td>: {{ $bankYangDipilih->nama_rekening }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <h5 class="card-title">
                        <i class="bi bi-patch-exclamation"></i>
                        Informasi Pembayaran
                    </h5>
                    <div class="alert alert-dark" role="alert">
                        <div class="form-group">
                            <label for="tanggal_bayar">Tanggal Bayar</label>
                            {!! Form::date('tanggal_bayar', $model->tanggal_bayar ?? date('Y-m-d'), ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('tanggal_bayar') }}</span>
                        </div>
                        <div class="form-group mt-3">
                            <label for="jumlah_dibayar">Jumlah Yang Dibayarkan</label>
                            {!! Form::text('jumlah_dibayar', $tagihan->tagihanDetails->sum('jumlah_biaya'), [
                                'class' => 'form-control rupiah',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('jumlah_dibayar') }}</span>
                        </div>
                        <div class="form-group mt-3">
                            <label for="bukti_bayar">Bukti Pembayaran <u>(Format: jpg, jpeg, png. Maks: 5MB)</u>
                            </label>
                            {!! Form::file('bukti_bayar', ['class' => 'form-control', 'accept' => 'image/*']) !!}
                            <span class="text-danger">{{ $errors->first('bukti_bayar') }}</span>
                        </div>
                        {!! Form::submit('SIMPAN', ['class' => 'btn btn-primary mt-3']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
