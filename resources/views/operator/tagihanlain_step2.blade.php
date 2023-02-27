@extends('layouts.app_niceadmin', ['title' => 'Form Data Tagihan'])

@section('js')
    <script>
        $('#gridCheck0').on('change', function() {
            $('.checkboxes').prop('checked', $(this).prop("checked"));
        });
        //deselect "checked all", if one of the listed checkboxes category is unchecked amd select "checked all" if all of the listed checkboxes category is checked
        $('.checkboxes').change(function() { //".checkboxes" change
            if ($('.checkboxes:checked').length == $('.checkboxes').length) {
                $('#gridCheck0').prop('checked', true);
            } else {
                $('#gridCheck0').prop('checked', false);
            }
        });
    </script>
@endsection
@section('content')
    <div class="card">
        <div class="bs-stepper wizard-numbered mt-2">
            @include('operator.tagihanlain_stepheader')
            <div class="bs-stepper-content">
                <!-- Account Details -->
                <div id="account-details" class="content active dstepper-block">
                    <div class="content-header mb-3">
                        <h6 class="mb-0">Cari Data Siswa</h6>
                        <small>Cari data siswa berdasarkan.</small>
                    </div>
                    {!! Form::open([
                        'url' => request()->fullUrl(),
                        'method' => 'GET',
                    ]) !!}
                    {!! Form::hidden('step', 2, []) !!}
                    {!! Form::hidden('tagihan_untuk', session('tagihan_untuk'), []) !!}
                    <div class="row g-3 mb-3">
                        <div class="form-group mt-3">
                            <label for="nama" class="form-label">Nama</label>
                            {!! Form::text('nama', request('nama') ?? '', [
                                'class' => 'form-control',
                                'autofocus',
                                'placeholder' => 'cari berdasarkan nama',
                            ]) !!}
                            <small class="text-danger">{{ $errors->first('nama') }}</small>
                        </div>
                        <div class="form-group mt-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            {!! Form::select('kelas', getNamaKelas(), request('kelas') ?? '', [
                                'class' => 'form-control',
                                'placeholder' => 'pilih kelas atau tampilkan semua',
                            ]) !!}
                            <small class="text-danger">{{ $errors->first('kelas') }}</small>
                        </div>
                        <div class="form-group mt-3">
                            <label for="angkatan" class="form-label">Angkatan</label>
                            {!! Form::selectRange('angkatan', date('Y') - 3, date('Y') + 1, request('angkatan') ?? '', [
                                'class' => 'form-control',
                                'placeholder' => 'pilih angkatan atau tampilkan semua',
                            ]) !!}
                            <small class="text-danger">{{ $errors->first('angkatan') }}</small>
                        </div>
                    </div>
                    <input type="submit" name="cari" value="cari data" class="btn btn-success">
                    {!! Form::close() !!}
                    <hr>
                    @if (Session::has('data_siswa'))
                        <h5 class="mt-3">Data siswa yang akan ditagih: </h5>
                        <ul>
                            @forelse (Session::get('data_siswa') as $item)
                                <li>
                                    <a
                                        href="{{ route('tagihanlainstep2.delete', ['id' => $item->id, 'action' => 'delete']) }}">X</a>
                                    <span class="badge rounded-pill bg-primary">
                                        {{ $item->nama }}
                                    </span>
                                </li>
                            @empty
                                <span class="badge rounded-pill bg-secondary">
                                    Tidak ada data
                                </span>
                            @endforelse
                        </ul>
                        <a href="{{ route('tagihanlainstep2.delete', ['action' => 'deleteall']) }}"
                            class="btn btn-danger">Hapus semua</a>
                    @endif
                    @if (request()->filled('cari'))
                        <h5 class="mt-3">Pilih data siswa</h5>
                        {!! Form::open([
                            'route' => 'tagihanlainstep2.store',
                            'method' => 'POST',
                        ]) !!}
                        <div class="table-responsive">
                            <table class="{{ config('app.table_style') }}">
                                <thead class="{{ config('app.thead_style') }}">
                                    <tr>
                                        <th width="1%;">
                                            <input type="checkbox" id="gridCheck0" class="form-check-input">
                                        </th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Angkatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($siswa as $item)
                                        <tr>
                                            <td>{!! Form::checkbox('siswa_id[]', $item->id, $item->checked, [
                                                'class' => 'form-check-input checkboxes',
                                                'id' => 'gridCheck' . $loop->iteration,
                                            ]) !!}</td>
                                            <td width="20%">{{ $item->nama }}</td>
                                            <td>{{ $item->kelas }}</td>
                                            <td>{{ $item->angkatan }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center fw-bold">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <input type="submit" value="simpan" class="btn btn-primary">
                        </div>
                        {!! Form::close() !!}
                    @endif
                    <div class="col-12 d-flex justify-content-between mt-3">
                        <a href="{{ route('tagihanlainstep.create', ['step' => 1]) }}"
                            class="btn btn-label-secondary btn-prev border" disabled>
                            <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </a>

                        <a href="{{ route('tagihanlainstep.create', ['step' => 3]) }}" class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Next</span>
                            <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {

            const wizardNumbered = document.querySelector(".wizard-numbered");

            if (typeof wizardNumbered !== undefined && wizardNumbered !== null) {
                const wizardNumberedBtnNextList = [].slice.call(wizardNumbered.querySelectorAll('.btn-next')),
                    wizardNumberedBtnPrevList = [].slice.call(wizardNumbered.querySelectorAll('.btn-prev')),
                    wizardNumberedBtnSubmit = wizardNumbered.querySelector('.btn-submit');

                const numberedStepper = new Stepper(wizardNumbered, {
                    linear: false
                });
                if (wizardNumberedBtnNextList) {
                    wizardNumberedBtnNextList.forEach(wizardNumberedBtnNext => {
                        wizardNumberedBtnNext.addEventListener('click', event => {
                            numberedStepper.next();
                        });
                    });
                }
                if (wizardNumberedBtnPrevList) {
                    wizardNumberedBtnPrevList.forEach(wizardNumberedBtnPrev => {
                        wizardNumberedBtnPrev.addEventListener('click', event => {
                            numberedStepper.previous();
                        });
                    });
                }
                if (wizardNumberedBtnSubmit) {
                    wizardNumberedBtnSubmit.addEventListener('click', event => {
                        alert('Submitted..!!');
                    });
                }
            }

        });
    </script>
@endsection
