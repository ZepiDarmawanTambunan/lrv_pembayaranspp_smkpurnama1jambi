@extends('layouts.app_niceadmin', ['title' => 'Data Tagihan'])

@section('js')
    <script>
        $(document).ready(function() {
            $('#btn-lunas').hide();
            $('#btn-hapus').hide();
            $('.check-tagihan-id').change(function(e) {
                if ($(this).prop('checked')) {
                    $('#btn-lunas').show();
                    $('#btn-hapus').show();
                }
                if ($('.check-tagihan-id:checked').length == 0) {
                    $('#btn-lunas').hide();
                    $('#btn-hapus').hide();
                }
            });
            $('#checked-all').click(function(e) {
                if ($(this).is(":checked")) {
                    $('#btn-lunas').show();
                    $('#btn-hapus').show();
                    $('.check-tagihan-id').prop('checked', true);
                } else {
                    $('#btn-lunas').hide();
                    $('#btn-hapus').hide();
                    $('.check-tagihan-id').prop('checked', false);
                }
            });
            $('#btn-lunas').click(function(e) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: "{{ route(auth()->user()->akses . '.tagihanupdate.lunas') }}",
                    data: $('.check-tagihan-id').serialize(),
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
            });
            $('#btn-hapus').click(function(e) {
                let confirmHapus = confirm('Yakin hapus ?');
                if (confirmHapus) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: "{{ route(auth()->user()->akses . '.tagihandestory.ajax') }}",
                        data: $('.check-tagihan-id').serialize(),
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
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="alert d-none my-1" role="alert" id="alert-message"></div>
                <h5 class="card-header fw-bold fs-5" style="color: #012970;">{{ $title }}</h5>
                <div class="card-body">
                    <div class="row my-4">
                        <div class="col-md-12">
                            {!! Form::open(['route' => $routePrefix . '.index', 'method' => 'GET']) !!}
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
                    <button type="button" id="btn-lunas" class="btn btn-success btn-sm mb-3">Ubah menjadi lunas</button>
                    <button type="button" id="btn-hapus" class="btn btn-danger btn-sm mb-3">Hapus</button>
                    <div class="table-responsive">
                        <table class="{{ config('app.table_style') }}">
                            <thead class="{{ config('app.thead_style') }}">
                                <tr>
                                    <th width="1%;">
                                        <input type="checkbox" id="checked-all">
                                    </th>
                                    <th>Nama</th>
                                    <th>Tgl Dibuat</th>
                                    <th width="1%;">Status</th>
                                    <th width="10%;">Jenis</th>
                                    <th>Total</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr valign="middle">
                                        <td>{!! Form::checkbox('tagihan_id[]', $item->id, null, ['class' => 'check-tagihan-id']) !!}</td>
                                        <td>{{ $item->siswa->nama }} ({{ $item->siswa->nisn }})</td>
                                        <td>{{ $item->tanggal_tagihan->translatedFormat('d-M-Y') }}</td>
                                        <td>
                                            <span class="badge rounded-pill bg-{{ $item->status_style }}">
                                                {{ $item->status == 'baru' ? 'Belum bayar' : $item->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge rounded bg-{{ $item->jenis == 'spp' ? 'primary' : 'success' }}">
                                                {{ $item->jenis }}
                                            </span>
                                        </td>
                                        <td>{{ formatRupiah($item->tagihanDetails->sum('jumlah_biaya')) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route($routePrefix . '.show', [
                                                $item->id,
                                                'siswa_id' => $item->siswa_id,
                                                'bulan' => $item->tanggal_tagihan->format('m'),
                                                'tahun' => $item->tanggal_tagihan->format('Y'),
                                            ]) }}"
                                                class="btn btn-sm btn-info mx-2 mb-1 mb-md-0">
                                                <i class="bi bi-info-circle d-md-inline d-none"></i>
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center fw-bold">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {!! $models->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
