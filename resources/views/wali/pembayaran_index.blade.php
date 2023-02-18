@extends('layouts.app_niceadmin', ['title' => 'Data Pembayaran'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold fs-5" style="color: #012970;">DATA PEMBAYARAN</h5>
                <div class="card-body">
                    <div class="row my-3">
                        <div class="col-md-6">
                            {!! Form::open(['route' => 'wali.pembayaran.index', 'method' => 'GET']) !!}
                            <div class="row">
                                <div class="col-md-4 col-sm-12 mb-3 mb-md-0">
                                    {!! Form::selectMonth('bulan', request('bulan'), ['class' => 'form-control']) !!}
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3 mb-md-0">
                                    {!! Form::selectRange('tahun', 2022, date('Y') + 1, request('tahun'), ['class' => 'form-control']) !!}
                                </div>
                                <div class="col">
                                    <button class="btn btn-primary" type="submit">Tampil</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="{{ config('app.table_style') }}">
                            <thead class="{{ config('app.thead_style') }}">
                                <tr>
                                    <th width="1%;">No</th>
                                    <th>NISN</th>
                                    <th>Nama</th>
                                    <th>Nama Wali</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Status Konfirmasi</th>
                                    <th>Tanggal Konfirmasi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->tagihan->siswa->nisn }}</td>
                                        <td>{{ $item->tagihan->siswa->nama }}</td>
                                        <td>{{ $item->metode_pembayaran }}</td>
                                        <td>{{ optional($item->tanggal_bayar)->translatedFormat('d-M-Y') }}</td>
                                        <td>{{ $item->status_konfirmasi }}</td>
                                        <td>
                                            @if ($item->tanggal_konfirmasi == null)
                                                Belum Dikonfirmasi
                                            @else
                                                {{ $item->tanggal_konfirmasi->format('d/m/Y') }}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            {!! Form::open([
                                                'route' => ['wali.pembayaran.destroy', $item->id],
                                                'method' => 'DELETE',
                                                'onsubmit' => 'return confirm("Yakin ingin menghapus data ini?")',
                                            ]) !!}
                                            <a href="{{ route('wali.pembayaran.show', $item->id) }}"
                                                class="btn btn-sm btn-info mb-1 mb-xxl-0">
                                                <i class="bi bi-info-circle d-md-inline d-none"></i>
                                                Detail
                                            </a>
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash d-md-inline d-none"></i> Hapus
                                            </button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="fw-bold text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {!! $models->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
