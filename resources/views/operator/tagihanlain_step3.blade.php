@extends('layouts.app_niceadmin', ['title' => 'Form Data Tagihan'])

@section('content')
    <div class="card">
        <div class="bs-stepper wizard-numbered mt-2">
            @include('operator.tagihanlain_stepheader')
            <div class="bs-stepper-content">
                <!-- Account Details -->
                <div id="account-details" class="content active dstepper-block">
                    <div class="content-header mb-3">
                        @if (session('tagihan_untuk') == 'semua')
                            <h6 class="mb-0">Tagihan Untuk Semua Siswa</h6>
                        @else
                            <h6 class="mb-0">Tagihan Untuk {{ Session::get('data_siswa')->count() }} Siswa</h6>
                        @endif
                        <small>Pilih biaya yang akan ditagihkan.</small>
                    </div>
                    {!! Form::open([
                        'route' => ['tagihanlainstep.create'],
                        'method' => 'GET',
                    ]) !!}
                    {!! Form::hidden('step', 4, []) !!}
                    <div class="row g-3 mb-3">
                        <div class="form-group">
                            <label for="biaya_id">Pilih biaya atau
                                <a href="{{ route('biaya.create') }}" target="_blank">buat
                                    baru
                                </a>
                            </label>
                            {!! Form::select('biaya_id', $biayaList, null, ['class' => 'form-control select2']) !!}
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-between">
                        <a href="{{ route('tagihanlainstep.create', ['step' => 2]) }}"
                            class="btn btn-label-secondary btn-prev border" disabled>
                            <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </a>
                        <button class="btn btn-primary btn-next" type="submit">
                            <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Next</span>
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
