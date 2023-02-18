<div class="card">
    <div class="card-body">
        <h5 class="card-title">
            <i class="bi bi-patch-exclamation"></i>
            Kartu SPP {{ getTahunAjaranFull(request('bulan'), request('tahun')) }}
        </h5>
        <table class="{{ config('app.table_style') }}">
            <thead class="{{ config('app.thead_style') }}">
                <tr>
                    <th style="text-align: center" width="1%;">No</th>
                    <th style="text-align: start">Bulan</th>
                    <th style="text-align: end">Jumlah Tagihan</th>
                    <th style="text-align: center">Tanggal Bayar</th>
                    {{-- <td>Paraf</td> --}}
                </tr>
            </thead>
            @foreach ($kartuSpp as $item)
                <tr class="item">
                    <td style="text-align: center">{{ $loop->iteration }}</td>
                    <td style="text-align: start">{{ $item['bulan'] . ' ' . $item['tahun'] }}</td>
                    <td style="text-align: end">{{ formatRupiah($item['total_tagihan']) }}</td>
                    <td style="text-align: center">{{ $item['tanggal_bayar'] }}</td>
                    {{-- <td>&nbsp;</td> --}}
                </tr>
            @endforeach
        </table>
        <a href="{{ route('kartuspp.index', [
            'siswa_id' => $siswa->id,
            'tahun' => request('tahun'),
            'bulan' => request('bulan'),
        ]) }}"
            class="mt-3" target="_blank">
            <i class="fa fa-print"></i>
            Cetak Kartu SPP
        </a>
    </div>
</div>
