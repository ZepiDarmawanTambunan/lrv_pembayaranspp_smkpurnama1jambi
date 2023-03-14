<div class="card">
    <div class="card-body">
        <h5 class="card-title">
            <i class="bi bi-patch-exclamation"></i>
            Data Pembayaran
        </h5>
        <table class="{{ config('app.table_style') }}">
            <thead class="{{ config('app.thead_style') }}">
                <tr>
                    <th width="1%">#</th>
                    <th>TANGGAL</th>
                    <th>METODE</th>
                    <th class="text-end">JUMLAH</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tagihan->pembayaran as $item)
                    <tr>
                        <td class="text-center">
                            <a href="{{ route('kwitansipembayaran.show', $item->id) }}" target="_blank">
                                <i class="fa fa-print"></i>
                            </a>
                            {!! Form::open([
                                'route' => [auth()->user()->akses . '.pembayaran.destroy', $item->id],
                                'method' => 'DELETE',
                                'onsubmit' => 'return confirm("Yakin ingin menghapus data ini?")',
                            ]) !!}
                            <button type="submit" class="text-danger border-0 rounded-pill bg-transparent">
                                <i class="bi bi-trash d-md-inline d-none"></i>
                            </button>
                            {!! Form::close() !!}
                        </td>
                        <td>{{ $item->tanggal_bayar->translatedFormat('d/m/y') }}</td>
                        <td>{{ $item->metode_pembayaran }}</td>
                        <td class="text-end">{{ formatRupiah($item->jumlah_dibayar) }}</td>
                    </tr>
                @empty
                    <tr class="text-center">
                        <td colspan="4">Data Belum Ada</td>
                    </tr>
                @endforelse
                <tr>
                    <td colspan="3" class="fw-bold text-center">Total Pembayaran</td>
                    <td class="text-end fw-bold">{{ formatRupiah($tagihan->total_pembayaran) }}</td>
                    {{-- <td>&nbsp;</td> --}}
                </tr>
                <tr>
                    <td colspan="4" class="fw-bold text-center">Status Pembayaran: {{ strtoupper($tagihan->status) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @if ($tagihan->status != 'lunas')
        <div class="card-body">
            <h5 class="card-title">
                <i class="bi bi-patch-exclamation"></i>
                Form Pembayaran
            </h5>
            {!! Form::model($model, ['route' => auth()->user()->akses . '.pembayaran.store', 'method' => 'POST']) !!}
            {!! Form::hidden('tagihan_id', $tagihan->id, []) !!}
            <div class="form-group">
                <label for="tanggal_bayar" class="form-label">Tanggal Pembayaran</label>
                {!! Form::date('tanggal_bayar', $model->tanggal_bayar ?? date('Y-m-d'), [
                    'class' => 'form-control',
                ]) !!}
                <span class="text-danger">{{ $errors->first('tanggal_bayar') }}</span>
            </div>
            <div class="form-group mt-3">
                <label for="jumlah_dibayar" class="form-label">Jumlah Bayar</label>
                {!! Form::text('jumlah_dibayar', $tagihan->total_tagihan, [
                    'class' => 'form-control rupiah',
                ]) !!}
                <span class="text-danger">{{ $errors->first('jumlah_dibayar') }}</span>
            </div>
            {!! Form::submit('SIMPAN', ['class' => 'btn btn-primary mt-3']) !!}
            {!! Form::close() !!}
        </div>
    @endif
</div>
