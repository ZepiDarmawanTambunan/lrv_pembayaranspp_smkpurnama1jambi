@extends('layouts.app_niceadmin', ['title' => 'Beranda Wali'])

@section('content')
    <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-9 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Selamat Datang, {{ ucwords(auth()->user()->name) }} 🎉</h5>
                            <p class="mb-4">
                                Kamu mendapat <span class="fw-bold">10</span> notifikasi yang belum kamu lihat. Klik tombol
                                dibawah
                                untuk melihat informasi pembayaran.
                            </p>

                            <a href="{{ route('wali.tagihan.index') }}" class="btn btn-sm btn-outline-primary">Lihat Data
                                Pembayaran</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-2">
                            <img src="{{ asset('niceadmin') }}/assets/img/man-laptop.png" height="200"
                                alt="View Badge User" class="d-none d-sm-block">
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-3">
            <div class="card info-card revenue-card">
                <div class="card-body">
                    <h5 class="card-title">Total Data</h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ auth()->user()->siswa->count() }} Anak</h6>
                            <span class="text-success small pt-1 fw-bold">Peserta Didik</span>
                            {{-- <span class="text-muted small pt-2 ps-1">increase</span> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Right side columns -->
    </div>

    <div class="row m-0 p-0">
        @foreach ($dataRekap as $item)
            <div class="col-md-6 col-lg-4 order-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-truncate">Kartu SPP <strong>{{ $item['siswa']['nama'] }}</strong></h5>
                        <a href="{{ route('kartuspp.index', [
                            'siswa_id' => $item['siswa']['id'],
                            'tahun' => date('Y'),
                            'bulan' => date('m'),
                        ]) }}"
                            target="_blank">
                            <i class="bi bi-file-earmark-arrow-down"></i>
                            <span class="d-md-inline d-none">Kartu SPP {{ getTahunAjaranFUll(date('m'), date('Y')) }}</span>
                        </a>
                        <div class="list-group">
                            <div
                                class="list-group-item d-flex justify-content-between align-items-center list-group-item-secondary">
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <div class="mb-0 h-6 fw-bold">Bulan</div>
                                    </div>
                                    <span class="fw-bold">Status</span>
                                </div>
                            </div>
                            @foreach ($item['dataTagihan'] as $itemTagihan)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <div class="mb-0 h-6">{{ $itemTagihan['bulan'] }}</div>
                                        </div>
                                        @if ($itemTagihan['tagihan'] != null)
                                            <span
                                                class="badge {{ $itemTagihan['status_bayar_teks'] == 'lunas' ? 'bg-primary ' : 'bg-danger' }}">
                                                <a class="text-white"
                                                    href="{{ route('wali.tagihan.show', $itemTagihan['tagihan']->id) }}">
                                                    {{ $itemTagihan['status_bayar_teks'] }}
                                                </a>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        @if (auth()->user()->unreadNotifications->count() >= 1)
            <div class="col-md-6 col-lg-4 order-2 mb-4">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Notifikasi</h5>
                        <ul class="list-group list-group-flush">
                            @foreach (auth()->user()->unreadNotifications->take(4) as $notification)
                                <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                    <a href="{{ url($notification->data['url'] . '?id=' . $notification->id) }}">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <div class="mb-1 text-black fw-bold" style="font-size: 16px;">
                                                    {{ $notification->data['title'] }}
                                                </div>
                                                <p class="mb-0" style="font-size: 13px;">
                                                    {{ ucwords($notification->data['messages']) }}</p>
                                                <small class="text-muted"
                                                    style="font-size: 13px;">{{ $notification->created_at->diffForHumans() }}</small>
                                            </div>
                                            <div class="flex-shrink-0 dropdown-notifications-actions">
                                                {!! Form::open([
                                                    'route' => ['wali.notifikasi.update', $notification->id],
                                                    'method' => 'PUT',
                                                ]) !!}
                                                <button type="submit" class="btn dropdown-notifications-archive">
                                                    <i class="bi bi-x-lg text-danger"></i>
                                                </button>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
