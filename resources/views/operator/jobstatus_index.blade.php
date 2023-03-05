@extends('layouts.app_niceadmin', ['title' => 'Buat Tagihan'])

@section('js')
    <script>
        $(document).ready(function() {
            var bar = document.querySelector('.progress-bar');
            var intervalId = window.setInterval(() => {
                @if (request('job_status_id') != '')
                    $.getJSON("{{ route('jobstatus.show', request('job_status_id')) }}",
                        function(data, textStatus, jqXHR) {
                            var progressPercent = data['progress_percentage'];
                            var progressNow = data['progress_now'];
                            var progressMax = data['progress_max'];
                            var isEnded = data['is_ended'];
                            var id = data['id'];
                            bar.style.width = progressPercent + '%';
                            bar.innerText = progressPercent + '%';
                            $("#progress-now" + id).text(progressNow);
                            $("#progress-max" + id).text(progressMax);
                            console.log(isEnded);
                            if (isEnded) {
                                window.location.href = "{{ route('jobstatus.index') }}";
                            }
                        }
                    );
                @else
                    clearInterval(intervalId);
                @endif
                console.log('job running');
            }, 1000);
        });
    </script>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold fs-5" style="color: #012970;">{{ $title }}</h5>
                <div class="card-body">
                    <div class="row my-3">
                        <div class="col-md-6">
                            <a href="{{ route('tagihan.create') }}" class="btn btn-primary mt-4">
                                Tambah Tagihan SPP
                            </a>
                            <a href="{{ route('tagihanlainstep.create', ['step' => 1]) }}"
                                class="btn btn-success mt-4 ml-2">
                                Tambah Tagihan Lain
                            </a>
                        </div>
                        <div class="col-md-6">
                            {!! Form::open(['route' => $routePrefix . '.index', 'method' => 'GET']) !!}
                            <div class="input-group mr-auto">
                                <input name="q" type="text" class="form-control" placeholder="Cari Data"
                                    aria-label="Cari Data" aria-describedby="button-addon2" value="{{ request('q') }}">
                                <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    @if (request('job_status_id') != '')
                        <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
                                aria-valuemin="0" aria-valuemax="100">0%</div>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="{{ config('app.table_style') }}">
                            <thead class="{{ config('app.thead_style') }}">
                                <tr>
                                    <th width="1%;">No</th>
                                    <th>Job Modul</th>
                                    <th>Progress</th>
                                    <th>Status</th>
                                    <th>Tanggal dibuat</th>
                                    <th>Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($item->status == 'finished')
                                                {{ substr($item->type, 9) }}
                                            @else
                                                <a href="{{ route('jobstatus.index', ['job_status_id' => $item->id]) }}">
                                                    {{ $item->type }}
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            <span id="progress-now{{ $item->id }}">{{ $item->progress_now }}</span> /
                                            <span id="progress-max{{ $item->id }}">{{ $item->progress_max }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge rounded bg-{{ $item->status == 'finished' ? 'primary' : 'info' }}">
                                                {{ $item->status }}
                                            </span>

                                        </td>
                                        <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                                        <td>{{ json_encode($item->output) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center fw-bold">Tidak ada data</td>
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
