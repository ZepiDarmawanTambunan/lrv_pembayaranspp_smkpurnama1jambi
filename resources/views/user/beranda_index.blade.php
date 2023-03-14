@extends('layouts.app_niceadmin', ['title' => 'Beranda Operator'])

@section('content')
    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Selamat Datang, {{ ucwords(auth()->user()->name) }}
                                🎉
                            </h5>
                            <p class="mb-4">
                                Kamu mendapat <span class="fw-bold">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                                notifikasi yang belum kamu lihat. Klik
                                tombol
                                dibawah
                                untuk melihat informasi pembayaran.
                            </p>

                            <a href="{{ route(auth()->user()->akses . '.pembayaran.index') }}"
                                class="btn btn-sm btn-outline-primary">Lihat
                                Data
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
        </div>

        <div class="col-lg-5">
            <div class="row">
                <div class="col col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="card-icon my-2 rounded d-flex align-items-center justify-content-center"
                                    style="height: 35px; width: 35px;">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="text-secondary fw-bold mx-2">Total Data</div>
                            </div>
                            <div class="mt-1">
                                <h6 class="m-0">{{ $siswa->count() }} Siswa</h6>
                                <span class="text-warning small fw-bold">Data Siswa</span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="card-icon my-2 rounded d-flex align-items-center justify-content-center"
                                    style="height: 35px; width: 35px;">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <div class="text-secondary fw-bold mx-2" style="font-size: 15px;">Total Bayar Bulan Ini
                                </div>
                            </div>
                            <div class="mt-3">
                                <h6 class="m-0">{{ $totalSiswaSudahBayar }} Siswa</h6>
                                <span class="text-warning small fw-bold">{{ formatRupiah($totalPembayaran) }}</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-4 order-2 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Tagihan {{ $bulanTeks }} {{ $tahun }}</h5>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex flex-column align-items-center gap-1">
                            <h2 class="mb-2">{{ $tagihanSudahBayar->count() }}/{{ $tagihanBelumBayar->count() }}</h2>
                            <span class="text-center">Total Tagihan: {{ $totalTagihan }}</span>
                        </div>
                        {!! $tagihanChart->container() !!}
                    </div>

                    <ul class="list-group">
                        @foreach ($tagihanPerKelas as $key => $item)
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-3 icon-sm me-3 bg-primary bg-gradient shadow text-center px-2 py-1">
                                        <div class="text-white opacity-10 fs-5">
                                            {{ $item->count() }}
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">Kelas {{ $key }}</h6>
                                        <small class="text-secondary" style="font-size: 13px;">Sudah Bayar / Belum</small>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="my-auto" style="font-size: 13px;">
                                        {{ $item->where('status', 'lunas')->count() }}
                                        /
                                        {{ $item->where('status', '<>', 'lunas')->count() }}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @if ($totalPembayaranBelumKonfirmasi->count() >= 1)
            <div class="col-md-6 col-lg-4 order-2 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Pembayaran Belum Dikonfirmasi</h5>
                        <ul class="list-group">
                            @foreach ($totalPembayaranBelumKonfirmasi->take(5) as $item)
                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="rounded-3 icon-sm me-3 bg-success bg-gradient shadow text-center px-2 py-1">
                                            <i class="bi bi-person text-white opacity-10 fs-5"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-1 text-dark text-sm">{{ $item->tagihan->siswa->nama }}</h6>
                                            <small class="text-secondary"
                                                style="font-size: 13px;">{{ $item->tanggal_bayar->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <a href="{{ route(auth()->user()->akses . '.pembayaran.show', $item->id) }}"
                                            class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i
                                                class="bi bi-arrow-right-circle fs-5 text-success"></i></a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        @if ($tagihanBelumBayar->count() >= 1)
            <div class="col-md-6 col-lg-4 order-2 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Tagihan Belum Dibayar</h5>
                        <div class="fs-6 fw-semibold">
                            {{ $tagihanBelumBayar->count() }} /
                            {{ $totalTagihan }}
                        </div>

                        <ul class="list-group">
                            @foreach ($tagihanBelumBayar->take(5) as $item)
                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="rounded-3 icon-sm me-3 bg-warning bg-gradient shadow text-center px-2 py-1">
                                            <i class="bi bi-person text-white opacity-10 fs-5"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-1 text-dark text-sm">{{ $item->siswa->nama }}</h6>
                                            <small class="text-secondary"
                                                style="font-size: 13px;">{{ $item->tanggal_tagihan->translatedFormat('F Y') }}</small>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <a href="{{ route(auth()->user()->akses . '.tagihan.show', [$item->id, 'siswa_id' => $item->siswa_id, 'tahun' => $item->tanggal_tagihan->year]) }}"
                                            class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i
                                                class="bi bi-arrow-right-circle fs-5 text-warning"></i></a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>


    <script src="{{ $tagihanChart->cdn() }}"></script>
    {{ $tagihanChart->script() }}
@endsection
