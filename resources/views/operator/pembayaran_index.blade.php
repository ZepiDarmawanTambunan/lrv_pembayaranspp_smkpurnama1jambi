@extends('layouts.app_niceadmin', ['title' => 'Data Pembayaran'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold fs-5" style="color: #012970;">DATA PEMBAYARAN</h5>
                <div class="card-body">
                    <div class="row my-3">
                        <div class="col-md-12">
                            {!! Form::open(['route' => 'pembayaran.index', 'method' => 'GET']) !!}
                            <div class="row justify-content-end">
                                <div class="col-md-4 col-sm-12 mb-3 mb-md-0">
                                    {!! Form::text('q', request('q'), ['class' => 'form-control', 'placeholder' => 'Pencarian Data Siswa']) !!}
                                </div>
                                <div class="col-md-2 col-sm-12 mb-3 mb-md-0">
                                    {!! Form::select(
                                        'status',
                                        [
                                            '' => 'Pilih Status',
                                            'belum-dikonfirmasi' => 'Belum Dikonfirmasi',
                                            'sudah-dikonfirmasi' => 'Sudah Dikonfirmasi',
                                        ],
                                        request('status'),
                                        ['class' => 'form-select'],
                                    ) !!}
                                </div>
                                <div class="col-md-2 col-sm-12 mb-3 mb-md-0">
                                    {!! Form::selectMonth('bulan', request('bulan'), ['class' => 'form-control', 'placeholder' => 'Pilih Bulan']) !!}
                                </div>
                                <div class="col-md-2 col-sm-12 mb-3 mb-md-0">
                                    {!! Form::selectRange('tahun', date('Y') - 3, date('Y') + 1, request('tahun') ?? date('Y'), [
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                                <div class="col">
                                    <button class="btn btn-primary" type="submit">Tampil</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="{{ config('app.table_style') }}">
                            <thead class="{{ config('app.thead_style') }}">
                                <tr>
                                    <th width="1%;">No</th>
                                    <th>Nama</th>
                                    <th width="1%;">Metode Pembayaran</th>
                                    <th width="5%;">Status Konfirmasi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->tagihan->siswa->nama }} ({{ $item->tagihan->siswa->nisn }})</td>
                                        <td>{{ $item->metode_pembayaran }}</td>
                                        <td>
                                            <span class="badge rounded-pill bg-{{ $item->status_style }}">
                                                {{ $item->status_konfirmasi }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            {!! Form::open([
                                                'route' => ['pembayaran.destroy', $item->id],
                                                'method' => 'DELETE',
                                                'onsubmit' => 'return confirm("Yakin ingin menghapus data ini?")',
                                            ]) !!}
                                            <a href="{{ route('pembayaran.show', $item->id) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-info-circle d-md-inline d-none"></i>
                                                Detail
                                            </a>
                                            @if ($item->metode_pembayaran == 'manual' || $item->tanggal_konfirmasi == null)
                                                <button type="submit" class="btn btn-sm btn-danger mx-2 mt-1 mt-md-0">
                                                    <i class="bi bi-trash d-md-inline d-none"></i>
                                                    Hapus
                                                </button>
                                            @endif
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center fw-bold">Tidak ada data</td>
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
