@extends('layouts.app_niceadmin', ['title' => 'Aktivitas User'])

@section('js')
    <script>
        $(document).ready(function() {
            $('#btn-hapus').hide();
            $('.check-activity-id').change(function(e) {
                if ($('.check-activity-id:checked').length == $('.check-activity-id').length) {
                    $('#checked-all').prop('checked', true);
                }
                if ($(this).prop('checked')) {
                    $('#btn-hapus').show();
                }
                if ($('.check-activity-id:checked').length == 0) {
                    $('#btn-hapus').hide();
                }
                if ($('.check-activity-id:checked').length < $('.check-activity-id').length) {
                    $('#checked-all').prop('checked', false);
                }
            });
            $('#checked-all').click(function(e) {
                if ($(this).is(":checked")) {
                    $('#btn-hapus').show();
                    $('.check-activity-id').prop('checked', true);
                } else {
                    $('#btn-hapus').hide();
                    $('.check-activity-id').prop('checked', false);
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
                        url: "{{ route('kepala_sekolah.logactivitydestroy.ajax') }}",
                        data: $('.check-activity-id').serialize(),
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
                        <div class="col-md-8">
                            {!! Form::open(['route' => 'kepala_sekolah.logactivity.index', 'method' => 'GET']) !!}
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
                    <div class="table-responsive">
                        <table class="{{ config('app.table_style') }}">
                            <thead class="{{ config('app.thead_style') }}">
                                <tr>
                                    <th width="1%;">
                                        <input type="checkbox" id="checked-all">
                                    </th>
                                    <th>User</th>
                                    <th>Event</th>
                                    <th>Before</th>
                                    <th>After</th>
                                    <th>Description</th>
                                    <th>Log At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{!! Form::checkbox('activity_id[]', $item->id, null, ['class' => 'check-activity-id']) !!}</td>
                                        <td width="20%">{{ $item->causer->name ?? '' }}</td>
                                        <td>{{ $item->event ?? '' }}</td>
                                        <td>
                                            @if (@is_array($item->changes['old']))
                                                @foreach ($item->changes['old'] as $key => $itemChange)
                                                    {{ $key }} : {{ $itemChange }} <br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @if (@is_array($item->changes['attributes']))
                                                @foreach ($item->changes['attributes'] as $key => $itemChange)
                                                    {{ $key }} : {{ $itemChange }} <br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{ $item->description ?? '' }}</td>
                                        <td>{{ $item->created_at ?? '' }}</td>
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
@endsection
