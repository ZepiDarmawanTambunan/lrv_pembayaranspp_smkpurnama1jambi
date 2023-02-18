@extends('layouts.app_niceadmin', ['title' => 'Detail Wali Murid'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold fs-5" style="color: #012970;">{{ $title }}</h5>
                <div class="card-body mt-3">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <td width="15%">ID</td>
                                    <td>: {{ $model->id }}</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>: {{ $model->name }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>: {{ $model->email }}</td>
                                </tr>
                                <tr>
                                    <td>No HP</td>
                                    <td>: {{ $model->nohp }}</td>
                                </tr>
                                <tr>
                                    <td>Tgl Dibuat</td>
                                    <td>: {{ $model->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td>Tgl Diubah</td>
                                    <td>: {{ $model->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <h4 class="card-title">
                        <i class="bi bi-patch-exclamation"></i>
                        Tambah Data Anak
                    </h4>
                    {!! Form::open(['route' => 'walisiswa.store', 'method' => 'POST']) !!}
                    {!! Form::hidden('wali_id', $model->id, []) !!}
                    <div class="form-group">
                        <label for="siswa_id" class="form-label">Pilih Data Siswa</label>
                        {!! Form::select('siswa_id', $siswa, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
                    </div>
                    {!! Form::submit('SIMPAN', ['class' => 'btn btn-primary btn-sm mt-3']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <h4 class="card-title">
                        <i class="bi bi-patch-exclamation"></i>
                        Data Anak
                    </h4>
                    <div class="table-responsive">
                        <table class="{{ config('app.table_style') }}">
                            <thead class="{{ config('app.thead_style') }}">
                                <tr>
                                    <th width="1%;">No</th>
                                    <th>Nisn</th>
                                    <th>Nama</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($model->siswa as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nisn }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td class="text-center">
                                            {!! Form::open([
                                                'route' => ['walisiswa.update', $item->id],
                                                'method' => 'PUT',
                                                'onsubmit' => 'return confirm("Yakin ingin menghapus data ini?")',
                                            ]) !!}
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash d-md-inline d-none"></i> Hapus
                                            </button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center fw-bold" colspan="4">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
