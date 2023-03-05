@extends('layouts.app_niceadmin', ['title' => 'Data Tagihan'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header fw-bold fs-5" style="color: #012970;">TAGIHAN
                    {{ strtoupper($tagihan->jenis) }} {{ strtoupper($siswa->nama) }}</h5>
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-6 col-sm-12">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td rowspan="8" width="100" class="align-top">
                                        <img src="{{ \Storage::url($siswa->foto) }}" alt="{{ $siswa->nama }}"
                                            width="100" class="m-3">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50">NISN</td>
                                    <td>: {{ $siswa->nisn }}</td>
                                </tr>
                                <tr>
                                    <td>NAMA</td>
                                    <td>: {{ $siswa->nama }}</td>
                                </tr>
                                <tr>
                                    <td>JURUSAN</td>
                                    <td>: {{ $siswa->jurusan }}</td>
                                </tr>
                                <tr>
                                    <td>ANGKATAN</td>
                                    <td>: {{ $siswa->angkatan }}</td>
                                </tr>
                                <tr>
                                    <td>KELAS</td>
                                    <td>: {{ $siswa->kelas }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 col-sm-12 my-2 my-md-0">
                            <table>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td>No. Tagihan</td>
                                        <td>: #SMKP{{ $tagihan->id }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tgl Tagihan</td>
                                        <td>: {{ $tagihan->tanggal_tagihan->format('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tgl Jatuh Tempo</td>
                                        <td>: {{ $tagihan->tanggal_jatuh_tempo->format('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status Pembayaran</td>
                                        <td>: {{ $tagihan->getStatusTagihanWali() }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <a href="{{ route('invoice.show', $tagihan->id) }}" target="_blank">
                                                <i class="fa fa-print"></i>
                                                Cetak Invoice Tagihan
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </table>
                        </div>
                    </div>
                    <table class="{{ config('app.table_style') }}">
                        <thead class="{{ config('app.thead_style') }}">
                            <tr>
                                <th width="1%">No</th>
                                <th>Nama Tagihan</th>
                                <th class="text-end">Jumlah Tagihan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tagihan->tagihanDetails as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_biaya }}</td>
                                    <td class="text-end">{{ formatRupiah($item->jumlah_biaya) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="2" class="text-center fw-bold">Total Pembayaran</td>
                                <td class="text-end fw-bold">
                                    {{ formatRupiah($tagihan->tagihanDetails->sum('jumlah_biaya')) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="alert alert-secondary mt-4" role="alert" style="color: black; line-height: 30px;">
                        Pembayaran bisa dilakukan dengan cara langsung ke bendahara sekolah atau ditransfer melalui rekening
                        berikut: <br />
                        <u><i>Jangan melakukan transfer ke rekening selain dari rekening dibawah ini</i>.</u>
                        <br />
                        Silahkan lihat tata cara melakukan pembayaran melalui <a
                            href="{{ route('panduan.pembayaran', 'atm') }}" target="_blank">ATM</a> atau <a
                            href="{{ route('panduan.pembayaran', 'internet.banking') }}" target="_blank">Internet
                            Banking</a>
                        <br />
                        Setelah melakukan pembayaran, silahkan upload bukti pembayaran melalui tombol konfirmasi yang ada
                        dibawah ini:
                    </div>
                    <div class="row">
                        @forelse ($bankSekolah as $item)
                            <div class="col-md-6">
                                <div class="alert alert-success" role="alert">
                                    <table width="100%">
                                        <tbody>
                                            <tr>
                                                <td width="30%">Bank Tujuan</td>
                                                <td>: {{ Str::limit($item->nama_bank, 20) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Nomor Rekening</td>
                                                <td>: {{ $item->nomor_rekening }}</td>
                                            </tr>
                                            <tr>
                                                <td>Atas Nama</td>
                                                <td>: {{ $item->nama_rekening }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <a href="{{ route('wali.pembayaran.create', [
                                        'tagihan_id' => $tagihan->id,
                                        'bank_sekolah_id' => $item->id,
                                    ]) }}"
                                        class="btn btn-primary mt-4">Konfirmasi Pembayaran</a>
                                </div>
                            </div>
                        @empty
                            <div>Data Bank Belum Ada</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
