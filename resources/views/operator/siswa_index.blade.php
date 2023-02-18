@extends('layouts.app_niceadmin', ['title' => 'Data Siswa'])

@section('js')
    <script>
        $(document).ready(function() {
            $('#btn-hapus').hide();
            $('.check-siswa-id').change(function(e) {
                if ($(this).prop('checked')) {
                    $('#btn-hapus').show();
                }
                if ($('.check-siswa-id:checked').length == 0) {
                    $('#btn-hapus').hide();
                }
            });
            $('#checked-all').click(function(e) {
                if ($(this).is(":checked")) {
                    $('#btn-hapus').show();
                    $('.check-siswa-id').prop('checked', true);
                } else {
                    $('#btn-hapus').hide();
                    $('.check-siswa-id').prop('checked', false);
                }
            });
            $('#btn-hapus').click(function(e) {
                let confirmHapus = confirm('Yakin hapus ?');
                if (confirmHapus) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: "{{ route('siswadestory.ajax') }}",
                        data: $('.check-siswa-id').serialize(),
                        dataType: 'json',
                        beforeSend: function() {},
                        success: function(response) {
                            $('#alert-message').removeClass('d-none');
                            $('#alert-message').addClass('alert-success');
                            $('#alert-message').html(response.message);
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            $('#alert-message').removeClass('d-none');
                            $('#alert-message').addClass('alert-danger');
                            $('#alert-message').html(xhr.responseJSON.message);
                        },
                    });
                    e.preventDefault();
                    return;
                }
            });
        })
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="card p-3">
                <div class="card-body">
                    {!! $siswaKelasChart->container() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="alert d-none my-1" role="alert" id="alert-message"></div>
                <h5 class="card-header fw-bold fs-5" style="color: #012970;">{{ $title }}</h5>
                <div class="card-body">
                    <div class="row my-3">
                        <div class="col-md-6">
                            <a href="{{ route($routePrefix . '.create') }}" class="btn btn-sm btn-primary">Tambah
                                Data</a>
                        </div>
                        <div class="col-md-6">
                            {!! Form::open(['route' => $routePrefix . '.index', 'method' => 'GET']) !!}
                            <div class="input-group">
                                <input name="q" type="text" class="form-control" placeholder="Cari Nama Siswa"
                                    aria-label="cari nama" aria-describedby="button-addon2" value="{{ request('q') }}">
                                <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    {{-- <div class="row my-3">
                        <div class="col-md-5">

                        </div>
                        <div class="col-md-7">
                            {!! Form::open(['route' => 'siswaimport.store', 'method' => 'POST', 'files' => true]) !!}
                            <div class="input-group">
                                <input name="template" type="file" class="form-control" id="inputGroupFile04"
                                    aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                <button class="btn btn-primary" type="submit" id="inputGroupFileAddon04">Upload
                                    Excel</button>
                                <a href="{{ asset('template_excel.xlsx') }}" class="btn btn-outline-primary"
                                    target="_blank">
                                    Download Template Excel</a>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div> --}}
                    <button type="button" id="btn-hapus" class="btn btn-danger mb-3">Hapus</button>
                    <div class="table-responsive">
                        <table class="{{ config('app.table_style') }}">
                            <thead class="{{ config('app.thead_style') }}">
                                <tr>
                                    <th width="1%;">
                                        <input type="checkbox" id="checked-all">
                                    </th>
                                    <th>Nama</th>
                                    <th>Wali Murid</th>
                                    <th>Kelas</th>
                                    <th>Biaya SPP</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{!! Form::checkbox('siswa_id[]', $item->id, null, ['class' => 'check-siswa-id']) !!}</td>
                                        <td width="20%">{{ $item->nama }}</td>
                                        <td>{{ $item->wali->name ?? 'Belum ada wali murid' }}</td>
                                        <td>{{ $item->kelas }} ({{ $item->jurusan }})</td>
                                        <td>{{ formatRupiah($item->biaya->total_tagihan) }}</td>
                                        {{-- cara pak aim <td>{{ formatRupiah($item->biaya?->first()->total_tagihan) }}</td> --}}
                                        <td class="text-center">
                                            {!! Form::open([
                                                'route' => [$routePrefix . '.destroy', $item->id],
                                                'method' => 'DELETE',
                                                'onsubmit' => 'return confirm("Jika data ini dihapus maka data tagihan dan pembayaran akan terhapus, yakin ?")',
                                            ]) !!}
                                            <a href="{{ route($routePrefix . '.edit', $item->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil-square d-md-inline d-none"></i> Edit
                                            </a>
                                            <a href="{{ route($routePrefix . '.show', $item->id) }}"
                                                class="btn btn-sm btn-info mx-2 my-1 my-md-0">
                                                <i class="bi bi-info-circle d-md-inline d-none"></i> Detail
                                            </a>
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash d-md-inline d-none"></i> Hapus
                                            </button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center fw-bold">Tidak ada data</td>
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

    <script src="{{ $siswaKelasChart->cdn() }}"></script>
    {{ $siswaKelasChart->script() }}
@endsection
