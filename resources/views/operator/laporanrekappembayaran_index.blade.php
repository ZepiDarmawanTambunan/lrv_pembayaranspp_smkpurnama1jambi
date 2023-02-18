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

            th,
            td {
                padding: 0px !important;
                margin: 0px !important;
            }

            @page {
                size: A4 landscape;
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
                    <h4 class="my-0 py-0">LAPORAN REKAP PEMBAYARAN</h4>
                    <div class="my-2">{!! $subtitle !!}</div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="{{ config('app.thead_style') }}">
                                <tr>
                                    <th width="1%;">No</th>
                                    <th width="1%;">NISN</th>
                                    <th>Nama</th>
                                    @foreach ($header as $bulan)
                                        <th>
                                            {{ ubahNamaBulan($bulan) }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataRekap as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item['siswa']['nisn'] }}</td>
                                        <td>{{ $item['siswa']['nama'] }}</td>
                                        @foreach ($item['dataTagihan'] as $itemTagihan)
                                            <td class="text-center">
                                                @if ($itemTagihan['tanggal_lunas'] != '-')
                                                    {{ optional($itemTagihan['tanggal_lunas'])->format(config('app.format_tanggal')) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="15" class="text-center fw-bold">
                                            Tidak ada data
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
