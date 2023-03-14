@extends('layouts.app_niceadmin', ['title' => 'Detail Pembayaran'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold fs-5" style="color: #012970;">DETAIL PEMBAYARAN</h5>
                <div class="card-body mt-3">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td colspan="2" class="bg-secondary text-white fw-bold shadow-sm">
                                        INFORMASI SISWA
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nama Siswa</td>
                                    <td>: {{ $model->tagihan->siswa->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Nama Wali</td>
                                    <td>: {{ $model->wali->name ?? 'Belum ada wali murid' }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="bg-secondary text-white fw-bold shadow-sm">
                                        INFORMASI TAGIHAN
                                    </td>
                                </tr>
                                <tr>
                                    <td width="20%">Nomor Tagihan</td>
                                    <td>: {{ $model->id }}</td>
                                </tr>
                                <tr>
                                    <td>Jenis Tagihan</td>
                                    <td>: {{ $model->tagihan->biaya->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Invoice Tagihan</td>
                                    <td>:
                                        <a href="{{ route('invoice.show', $model->tagihan_id) }}" target="_blank">
                                            <i class="fa fa-print"></i>
                                            Cetak
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total Tagihan</td>
                                    <td>: {{ formatRupiah($model->tagihan->total_tagihan) }}</td>
                                </tr>
                                @if ($model->metode_pembayaran != 'manual')
                                    <tr>
                                        <td colspan="2" class="bg-secondary text-white fw-bold shadow-sm">
                                            INFORMASI BANK PENGIRIM
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Bank Pengirim</td>
                                        <td>: {{ $model->waliBank->nama_bank }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Rekening</td>
                                        <td>: {{ $model->waliBank->nomor_rekening }}</td>
                                    </tr>
                                    <tr>
                                        <td>Pemilik Rekening</td>
                                        <td>: {{ $model->waliBank->nama_rekening }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="bg-secondary text-white fw-bold shadow-sm">
                                            INFORMASI BANK TUJUAN
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Bank Tujuan</td>
                                        <td>: {{ $model->bankSekolah->nama_bank }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Rekening</td>
                                        <td>: {{ $model->bankSekolah->nomor_rekening }}</td>
                                    </tr>
                                    <tr>
                                        <td>Pemilik Rekening</td>
                                        <td>: {{ $model->bankSekolah->nama_rekening }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="2" class="bg-secondary text-white fw-bold shadow-sm">
                                        INFORMASI PEMBAYARAN
                                    </td>
                                </tr>
                                <tr>
                                    <td>Metode Pembayaran</td>
                                    <td>: {{ $model->metode_pembayaran }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Pembayaran</td>
                                    <td>: {{ optional($model->tanggal_bayar)->translatedFormat('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td>Jumlah Total Tagihan</td>
                                    <td>: {{ formatRupiah($model->tagihan->tagihanDetails->sum('jumlah_biaya')) }}</td>
                                </tr>
                                <tr>
                                    <td>Jumlah Yang Dibayar</td>
                                    <td>: {{ formatRupiah($model->jumlah_dibayar) }}</td>
                                </tr>
                                @if ($model->bukti_bayar != null && \Storage::exists($model->bukti_bayar))
                                    <tr>
                                        <td>Bukti Pembayaran</td>
                                        <td>:
                                            <a href="javascript:void[0]"
                                                onclick="popupCenter({url: '{{ \Storage::url($model->bukti_bayar) }}', title: 'Bukti Pembayaran', w: 900, h: 700}); ">
                                                Lihat Bukti Bayar
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>Status Konfirmasi</td>
                                    <td>: {{ $model->status_konfirmasi }}</td>
                                </tr>
                                <tr>
                                    <td>Status Pembayaran</td>
                                    <td>: {{ $model->tagihan->getStatusTagihanWali() }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Konfirmasi</td>
                                    <td>: {{ optional($model->tanggal_konfirmasi)->translatedFormat('d F Y H:i') }}</td>
                                </tr>
                            </thead>
                        </table>
                        @if ($model->tanggal_konfirmasi == null)
                            {!! Form::open([
                                'route' => $route,
                                'method' => 'PUT',
                                'onsubmit' => 'return confirm("Apakah Anda Yakin")',
                            ]) !!}
                            {!! Form::hidden('pembayaran_id', $model->id, []) !!}
                            {!! Form::submit('Konfirmasi Pembayaran', ['class' => 'btn btn-primary mt-3']) !!}
                            {!! Form::close() !!}
                        @else
                            <div class="alert alert-primary" role="alert">
                                <h3>Pembayaran telah dikonfirmasi</h3>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
