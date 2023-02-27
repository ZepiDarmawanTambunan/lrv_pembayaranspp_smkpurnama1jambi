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
                    @include('operator.laporan_header')
                    <h4 class="my-0 py-0">LAPORAN TAGIHAN</h4>
                    <div class="my-2">Laporan Berdasarkan: {!! $subtitle !!}</div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="{{ config('app.thead_style') }}">
                                <tr>
                                    <th width="1%">No</th>
                                    <th width="1%;">NISN</th>
                                    <th width="30%;">Nama</th>
                                    <th>Tanggal Tagihan</th>
                                    <th>Status</th>
                                    <th>Jenis</th>
                                    <th class="text-end">Total Tagihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tagihan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->siswa->nisn }}</td>
                                        <td>{{ $item->siswa->nama }}</td>
                                        <td>{{ $item->tanggal_tagihan->translatedFormat(config('app.format_tanggal')) }}
                                        </td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            {{ $item->biaya->nama }}
                                        </td>
                                        <td class="text-end">{{ formatRupiah($item->tagihanDetails->sum('jumlah_biaya')) }}
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center fw-bold">Tidak ada data</td>
                                    </tr>
                                @endforelse
                                <tr>
                                    <td colspan="5" class="text-center fw-bold">Total Tagihan</td>
                                    <td class="text-end fw-bold">
                                        {{ formatRupiah($tagihan->sum('total_tagihan')) }}
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
