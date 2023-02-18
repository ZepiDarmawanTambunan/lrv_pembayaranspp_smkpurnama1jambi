@extends('layouts.app_niceadmin', ['title' => 'Detail Siswa'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold fs-5" style="color: #012970;">DETAIL DATA SISWA</h5>

                <div class="card-body">
                    <div class="table-responsive mt-3">
                        <img src="{{ \Storage::url($model->foto) }}" width="150" class="my-3">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <td width="15%">Status Siswa</td>
                                    <td>:
                                        <span class="badge {{ $model->status == 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $model->status }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>: {{ $model->nama }}</td>
                                </tr>
                                <tr>
                                    <td>NISN</td>
                                    <td>: {{ $model->nisn }}</td>
                                </tr>
                                <tr>
                                    <td>Jurusan</td>
                                    <td>: {{ $model->jurusan }}</td>
                                </tr>
                                <tr>
                                    <td>Kelas</td>
                                    <td>: {{ $model->kelas }}</td>
                                </tr>
                                <tr>
                                    <td>Angkatan</td>
                                    <td>: {{ $model->angkatan }}</td>
                                </tr>
                                <tr>
                                    <td>Tgl Dibuat</td>
                                    <td>: {{ $model->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td>Tgl Diubah</td>
                                    <td>: {{ $model->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td>Dibuat Oleh</td>
                                    <td>: {{ $model->user->name }}</td>
                                </tr>
                            </thead>
                        </table>
                        <h5 class="card-title">
                            <i class="bi bi-patch-exclamation"></i>
                            Tagihan SPP
                        </h5>
                        <table class="{{ config('app.table_style') }}">
                            <thead class="{{ config('app.thead_style') }}">
                                <tr>
                                    <td width="1%;">No</td>
                                    <td>Item Tagihan</td>
                                    <td class="text-end">Jumlah Tagihan</td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($model->biaya->children as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td class="text-end">
                                            {{ formatRupiah($item->jumlah) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center fw-bold">Data tidak ada</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <td colspan="2" class="text-center fw-bold">Total Tagihan</td>
                                <td class="text-end fw-bold">
                                    {{ formatRupiah($model->biaya->children->sum('jumlah')) }}
                                </td>
                            </tfoot>
                        </table>
                        <a href="{{ route('kartuspp.index', [
                            'siswa_id' => $model->id,
                            'tahun' => date('Y'),
                            'bulan' => date('m'),
                        ]) }}"
                            target="_blank">
                            <i class="bi bi-file-earmark-arrow-down mt-2"></i> Download Kartu SPP
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
