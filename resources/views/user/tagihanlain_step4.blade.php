@extends('layouts.app_niceadmin', ['title' => 'Form Data Tagihan'])

@section('content')
    <div class="card">
        <div class="bs-stepper wizard-numbered mt-2">
            @include('user.tagihanlain_stepheader')
            <div class="bs-stepper-content">
                <!-- Account Details -->
                <div id="account-details" class="content active dstepper-block">
                    {!! Form::open([
                        'route' => auth()->user()->akses . '.tagihanlainstep4.store',
                        'method' => 'POST',
                    ]) !!}
                    {!! Form::hidden('biaya_id', $biaya->id, []) !!}
                    <div class="row g-3 mb-3">
                        Tagihan ini dibuat untuk:
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nama</th>
                                    <th>Nisn</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswa as $item)
                                    <tr>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->nisn }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <hr>
                        Biaya yang ditagihkan adalah: {{ $biaya->nama }}, Total: {{ formatRupiah($biaya->total_tagihan) }}
                        <div>
                            <ul>
                                @foreach ($biaya->children as $item)
                                    <li>
                                        {{ $item->nama . ' ' . formatRupiah($item->jumlah) }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <hr>
                        <div class="form-group mt-3">
                            <label for="tanggal_tagihan" class="form-label">Tanggal Tagihan</label>
                            {!! Form::date('tanggal_tagihan', $model->tanggal_tagihan ?? date('Y-m-') . '01', [
                                'class' => 'form-control',
                                'required' => 'required',
                            ]) !!}
                            <small class="text-danger">{{ $errors->first('tanggal_tagihan') }}</small>
                        </div>

                        <div class="form-group mt-3">
                            <label for="tanggal_jatuh_tempo" class="form-label">Tanggal Jatuh Tempo</label>
                            {!! Form::date('tanggal_jatuh_tempo', $model->tanggal_jatuh_tempo ?? date('Y-m-15', strtotime('+1 month')), [
                                'class' => 'form-control',
                                'required' => 'required',
                            ]) !!}
                            <small class="text-danger">{{ $errors->first('tanggal_jatuh_tempo') }}</small>
                        </div>

                        <div class="form-group mt-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            {!! Form::textarea('keterangan', null, [
                                'class' => 'form-control',
                                'rows' => 3,
                            ]) !!}
                            <small class="text-danger">{{ $errors->first('keterangan') }}</small>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-between">
                        <a href="{{ route(auth()->user()->akses . '.tagihanlainstep.create', ['step' => 3]) }}"
                            class="btn btn-label-secondary btn-prev border" disabled>
                            <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </a>
                        <button class="btn btn-primary btn-next" type="submit">
                            <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Simpan</span>
                            <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
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
