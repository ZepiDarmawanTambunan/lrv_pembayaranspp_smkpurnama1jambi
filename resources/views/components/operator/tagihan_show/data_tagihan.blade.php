<div class="card">
    <div class="card-body">
        <h5 class="card-title">
            <i class="bi bi-patch-exclamation"></i>
            Data Tagihan {{ $periode }}
        </h5>
        <table class="{{ config('app.table_style') }} mt-2">
            <thead class="{{ config('app.thead_style') }}">
                <tr>
                    <th width="1%;">No</th>
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
                    <td colspan="2" class="fw-bold text-center">Total Tagihan</td>
                    <td class="fw-bold text-end">{{ formatRupiah($tagihan->total_tagihan) }}</td>
                </tr>
            </tbody>
        </table>
        <a href="{{ route('invoice.show', $tagihan->id) }}" target="_blank">
            <i class="bi bi-file-earmark-arrow-down"></i> Download invoice
        </a>
    </div>
</div>
