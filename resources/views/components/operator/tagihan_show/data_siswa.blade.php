<div class="card">
    <h5 class="card-header fw-bold fs-5" style="color: #012970;">DATA TAGIHAN SPP SISWA {{ strtoupper($periode) }}
    </h5>
    <div class="card-body">
        <table class="table">
            <tr>
                <td rowspan="8" width="100">
                    <img src="{{ \Storage::url($siswa->foto ?? 'images/no-image.png') }}" alt="{{ $siswa->nama }}"
                        width="120" class="my-3">
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
        </table>
    </div>
</div>
