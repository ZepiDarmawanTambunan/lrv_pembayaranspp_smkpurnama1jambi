@extends('layouts.app_niceadmin', ['title' => 'Aktivitas User'])

@section('js')
    <script>
        $(document).ready(function() {
            $('#btn-hapus').hide();
            $('.check-visitor-id').change(function(e) {
                if ($('.check-visitor-id:checked').length == $('.check-visitor-id').length) {
                    $('#checked-all').prop('checked', true);
                }
                if ($(this).prop('checked')) {
                    $('#btn-hapus').show();
                }
                if ($('.check-visitor-id:checked').length == 0) {
                    $('#btn-hapus').hide();
                }
                if ($('.check-visitor-id:checked').length < $('.check-visitor-id').length) {
                    $('#checked-all').prop('checked', false);
                }
            });
            $('#checked-all').click(function(e) {
                if ($(this).is(":checked")) {
                    $('#btn-hapus').show();
                    $('.check-visitor-id').prop('checked', true);
                } else {
                    $('#btn-hapus').hide();
                    $('.check-visitor-id').prop('checked', false);
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
                        url: "{{ route('kepala_sekolah.logvisitordestroy.ajax') }}",
                        data: $('.check-visitor-id').serialize(),
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
                    <div class="row my-3">
                        <div class="col-md-6">
                            <h5>User yang aktif {{ $userActive->count() }}</h5>
                            <ul>
                                <small>NAMA</small>
                                @forelse ($userActive as $item)
                                    <li>
                                        <span class="badge rounded bg-success">
                                            {{ $item->name ?? '' }}
                                        </span>
                                    </li>
                                @empty
                                    <li colspan="10" class="text-center fw-bold">Tidak ada data</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-md-8">
                            {!! Form::open(['route' => 'kepala_sekolah.logvisitor.index', 'method' => 'GET']) !!}
                            <div class="input-group">
                                <input name="q" type="text" class="form-control" placeholder="Cari Nama User"
                                    aria-label="cari nama" aria-describedby="button-addon2" value="{{ request('q') }}">
                                <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <button type="button" id="btn-hapus" class="btn btn-danger mb-3">Hapus</button>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="{{ config('app.table_style') }}">
                                    <thead class="{{ config('app.thead_style') }}">
                                        <tr>
                                            <th width="1%;">
                                                <input type="checkbox" id="checked-all">
                                            </th>
                                            <th>Visitor</th>
                                            <th>Start URL (Referer)</th>
                                            <th>Destination URL (URL)</th>
                                            <th>Request</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($models as $item)
                                            <tr>
                                                <td>{!! Form::checkbox('visitor_id[]', $item->id, null, ['class' => 'check-visitor-id']) !!}</td>
                                                <td>{{ $user->find($item->visitor_id)->name ?? '' }}</td>
                                                <td>{{ $item->referer ?? '' }}</td>
                                                <td>{{ $item->url ?? '' }}</td>
                                                <td>{{ Str::limit($item->request, 20) ?? '' }}</td>
                                                <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                                                <td>{{ date('d/m/Y', strtotime($item->updated_at)) ?? '' }}</td>
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
        </div>
    </div>
@endsection
