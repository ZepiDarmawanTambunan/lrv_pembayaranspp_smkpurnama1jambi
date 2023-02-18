{!! Form::open(['route' => 'laporanrekappembayaran.index', 'method' => 'GET', 'target' => '_blank']) !!}
<div class="row">
    <div class="col-md-2 col-sm-12 mb-1 mb-md-0">
        <label for="kelas" class="form-label">Kelas</label>
        {!! Form::select('kelas', getNamaKelas(), request('status'), [
            'class' => 'form-select',
            'placeholder' => 'Pilih Kelas',
        ]) !!}
    </div>
    <div class="col-md-2 col-sm-12 mb-1 mb-md-0">
        <label for="jurusan" class="form-label">Jurusan</label>
        {!! Form::select('jurusan', getNamaJurusan(), request('status'), [
            'class' => 'form-select',
            'placeholder' => 'Pilih Jurusan',
        ]) !!}
    </div>
    <div class="col-md-2 col-sm-12 mb-1 mb-md-0">
        <label for="tahun" class="form-label">Tahun Ajaran</label>
        {!! Form::select('tahun', getRangeTahun(), request('tahun') ?? date('Y') - 1, [
            'class' => 'form-select',
        ]) !!}
    </div>
    <div class="col align-self-end mt-1 mt-md-0">
        <button class="btn btn-primary" type="submit">Tampil</button>
    </div>
</div>
{!! Form::close() !!}
