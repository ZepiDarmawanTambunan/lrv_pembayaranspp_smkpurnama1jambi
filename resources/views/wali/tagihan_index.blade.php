@extends('layouts.app_niceadmin', ['title' => 'Data tagihan'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold fs-5" style="color: #012970;">DATA TAGIHAN SPP</h5>
                <div class="card-body">
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
