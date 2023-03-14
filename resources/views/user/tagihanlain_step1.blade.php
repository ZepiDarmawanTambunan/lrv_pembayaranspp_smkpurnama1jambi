@extends('layouts.app_niceadmin', ['title' => 'Form Data Tagihan'])

@section('content')
    <div class="card">
        <div class="bs-stepper wizard-numbered mt-2">
            @include('user.tagihanlain_stepheader')
            <div class="bs-stepper-content">
                <!-- Account Details -->
                <div id="account-details" class="content active dstepper-block">
                    <div class="content-header mb-3">
                        <h6 class="mb-0">Tagihan Untuk</h6>
                        <small>Tagihan ini dibuat untuk siapa.</small>
                    </div>
                    {!! Form::open([
                        'route' => auth()->user()->akses . '.tagihanlainstep.create',
                        'method' => 'GET',
                    ]) !!}
                    {!! Form::hidden('step', 2, []) !!}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="form-check">
                                {!! Form::radio('tagihan_untuk', 'semua', true, [
                                    'class' => 'form-check-input',
                                    'id' => 'gridRadios1',
                                ]) !!}
                                <label class="form-check-label" for="gridRadios1">Semua Siswa</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    {!! Form::radio('tagihan_untuk', 'pilihan', false, [
                                        'class' => 'form-check-input',
                                        'id' => 'gridRadios2',
                                    ]) !!}
                                    <label class="form-check-label" for="gridRadios2">Pilih siswa tertentu</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-between">
                        <div></div>
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
