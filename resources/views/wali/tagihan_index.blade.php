@extends('layouts.app_niceadmin', ['title' => 'Data tagihan'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold fs-5" style="color: #012970;">DATA TAGIHAN SPP</h5>
                <div class="card-body">
                    <div class="row my-4">
                        <div class="col-md-12">
                            {!! Form::open(['route' => 'wali.tagihan.index', 'method' => 'GET']) !!}
                            <div class="row justify-content-end gx-2">
                                <div class="col-md-3 col-sm-12 my-3 my-md-0">
                                    {!! Form::text('q', request('q'), ['class' => 'form-control', 'placeholder' => 'Pencarian Data Siswa']) !!}
                                </div>
                                <div class="col-md-2 col-sm-12 mb-3 mb-md-0">
                                    {!! Form::select(
                                        'status',
                                        [
                                            'lunas' => 'Lunas',
                                            'baru' => 'Baru',
                                            'angsur' => 'Angsur',
                                        ],
                                        request('status'),
                                        ['class' => 'form-select', 'placeholder' => 'pilih status'],
                                    ) !!}
                                </div>

                                <div class="col-md-2 col-sm-12 mb-3 mb-md-0">
                                    {!! Form::select('biaya_id', $biayaList, request('biaya_id'), [
                                        'class' => 'form-select',
                                        'placeholder' => 'Pilih biaya',
                                    ]) !!}
                                </div>
                                <div class="col-md-2 col-sm-12 mb-3 mb-md-0">
                                    {!! Form::selectMonth('bulan', request('bulan'), ['class' => 'form-control', 'placeholder' => 'Pilih Bulan']) !!}
                                </div>
                                <div class="col-md-1 col-sm-12 mb-3 mb-md-0">
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
                                    <th>Nama Siswa</th>
                                    <th>Jurusan</th>
                                    <th>Kelas</th>
                                    <th>Tgl Tagihan</th>
                                    <th>Jenis Tagihan</th>
                                    <th>Status Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tagihan as $item)
                                    <tr valign="middle">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->siswa->nama }}</td>
                                        <td>{{ $item->siswa->jurusan }}</td>
                                        <td>{{ $item->siswa->kelas }}</td>
                                        <td>{{ $item->tanggal_tagihan->translatedFormat('F Y') }}</td>
                                        <td>{{ $item->biaya->nama }}</td>
                                        <td>
                                            @if ($item->pembayaran->count() >= 1)
                                                <a href="{{ route('wali.pembayaran.show', $item->pembayaran->first()->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    {{ $item->pembayaran->first()->tanggal_konfirmasi == null ? 'Belum dikonfirmasi' : 'Sudah dibayar' }}
                                                </a>
                                            @else
                                                {{ $item->getStatusTagihanWali() }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->status == 'baru' || $item->status == 'angsur')
                                                <a href="{{ route('wali.tagihan.show', $item->id) }}"
                                                    class="btn btn-sm btn-primary">Lakukan Pembayaran</a>
                                            @else
                                                <a href="" class="btn btn-sm btn-success">Pembayaran sudah lunas</a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="fw-bold text-center">Tidak ada data</td>
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
