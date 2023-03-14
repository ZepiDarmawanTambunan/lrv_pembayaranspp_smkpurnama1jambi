@extends('layouts.app_niceadmin_blank')

@section('content')
    <style>
        @media print {
            * {
                color: black !important;
            }

            table,
            thead,
            tbody,
            tfoot,
            th,
            td {
                border: 1px solid black;
            }

            @page {
                size: landscape;
            }

            .table-striped>tbody>tr:nth-of-type(odd)>* {
                --bs-table-accent-bg: #fff;
            }
        }
    </style>
    <div class="row justify-content-center pr-0">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @include('kepala_sekolah.laporan_header')
                    <h4 class="my-0 py-0">LAPORAN PEMBAYARAN</h4>
                    <div class="my-2">Laporan Berdasarkan: {!! $subtitle !!}</div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="{{ config('app.thead_style') }}">
                                <tr>
                                    <th width="1%">No</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th width="1%">Tanggal Bayar</th>
                                    <th width="1%">Metode Bayar</th>
                                    <th>Status Konfirmasi</th>
                                    <th width="1%">Tanggal Konfirmasi</th>
                                    <th class="text-end">Jumlah Dibayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pembayaran as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->tagihan->siswa->nama }} ({{ $item->tagihan->siswa->nisn }})</td>
                                        <td>{{ $item->tagihan->siswa->kelas . '-' . $item->tagihan->siswa->jurusan }}</td>
                                        <td>{{ $item->tanggal_bayar->translatedFormat(config('app.format_tanggal')) }}</td>
                                        <td>{{ $item->metode_pembayaran }}</td>
                                        <td>{{ $item->status_konfirmasi }}</td>
                                        <td>{{ optional($item->tanggal_konfirmasi)->translatedFormat(config('app.format_tanggal')) }}
                                        </td>
                                        <td class="text-end">{{ formatRupiah($item->jumlah_dibayar) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center fw-bold">Tidak ada data</td>
                                    </tr>
                                @endforelse
                                <tr>
                                    <td colspan="7" class="text-center fw-bold">Total Pembayaran</td>
                                    <td class="text-end fw-bold">
                                        {{ formatRupiah($totalPembayaran) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
