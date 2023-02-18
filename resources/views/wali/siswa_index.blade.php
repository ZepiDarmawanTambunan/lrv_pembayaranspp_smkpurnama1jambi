@extends('layouts.app_niceadmin', ['title' => 'Data Siswa'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold fs-5" style="color: #012970;">DATA SISWA</h5>

                <div class="card-body">
                    <div class="table-responsive mt-3">
                        <table class="{{ config('app.table_style') }}">
                            <thead class="{{ config('app.thead_style') }}">
                                <tr>
                                    <th width="1%">No</th>
                                    <th>Nama Siswa</th>
                                    <th>Jurusan</th>
                                    <th>Kelas</th>
                                    <th>Angkatan</th>
                                    <th class="text-center">Kartu SPP</th>
                                    <th class="text-end">Biaya Sekolah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div>{{ $item->nama }}</div>
                                            <div>{{ $item->nisn }}</div>
                                        </td>
                                        <td>{{ $item->jurusan }}</td>
                                        <td>{{ $item->kelas }}</td>
                                        <td>{{ $item->angkatan }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('kartuspp.index', [
                                                'siswa_id' => $item->id,
                                                'tahun' => date('Y'),
                                            ]) }}"
                                                target="_blank">
                                                <i class="bi bi-file-earmark-arrow-down"></i>
                                                <span class="d-md-inline d-none">Download</span>
                                            </a>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('wali.siswa.show', $item->id) }}">
                                                {{ formatRupiah($item->biaya->total_tagihan) }}
                                                <i class="bi bi-arrow-right-circle"></i>
                                            </a>
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
