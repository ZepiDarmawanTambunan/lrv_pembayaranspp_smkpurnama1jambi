@extends('layouts.app_niceadmin', ['title' => 'Data Rekening'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold fs-5" style="color: #012970;">{{ $title }}</h5>
                <div class="card-body">
                    <a href="{{ route($routePrefix . '.create') }}" class="btn btn-sm btn-primary my-3">Tambah Data</a>
                    <div class="table-responsive">
                        <table class="{{ config('app.table_style') }}">
                            <thead class="{{ config('app.thead_style') }}">
                                <tr>
                                    <th width="1%;">No</th>
                                    <th>Nama Bank</th>
                                    <th>Kode Transfer</th>
                                    <th>Pemilik Rekening</th>
                                    <th>Nomor Rekening</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama_bank }}</td>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->nama_rekening }}</td>
                                        <td>{{ $item->nomor_rekening }}</td>
                                        <td class="text-center">
                                            {!! Form::open([
                                                'route' => [$routePrefix . '.destroy', $item->id],
                                                'method' => 'DELETE',
                                                'onsubmit' => 'return confirm("Yakin ingin menghapus data ini?")',
                                            ]) !!}
                                            <a href="{{ route($routePrefix . '.edit', $item->id) }}"
                                                class="btn btn-sm btn-warning mx-2 mb-1 mb-md-0">
                                                <i class="bi bi-pencil-square d-md-inline d-none"></i>
                                                Edit
                                            </a>
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash d-md-inline d-none"></i> Hapus
                                            </button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center fw-bold">Data tidak ada</td>
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
