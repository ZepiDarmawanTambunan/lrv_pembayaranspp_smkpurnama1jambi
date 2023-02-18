@extends('auth.app_auth_niceadmin')

@section('content')
    <div class="container">
        <div class="row justify-content-center" style="height: 100vh; padding-top: 40px;">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                <img src="{{ \Storage::url(settings()->get('app_logo')) }}" style="height: 100px;">
                <div class="d-flex justify-content-center py-4">
                    <a href="#" class="logo d-flex align-items-center w-auto">
                        <span class="text-primary h5 m-0 fw-bold">{{ settings()->get('app_name') }}</span>
                    </a>
                </div><!-- End Logo -->
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">Lupa Password</h5>
                        </div>
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="col-12">
                                <label for="yourEmail" class="form-label">Email</label>
                                <div class="input-group has-validation">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-12 my-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                            <div class="col-12" style="font-size: 14px; font-weight: bold;">
                                Jika sudah mengirim tautan pengaturan ulang kata sandi, Silahkan untuk melihat pesan yang
                                terdapat di email anda. apabila anda masih mengalami kesulitan silahkan
                                <a href="https://wa.me/+{{ settings()->get('no_wa_operator') }}" target="_blank">Klik Link
                                    Whatsapp ini</a>
                            </div>
                            <div class="col-12 text-center mt-3">
                                <a href="{{ route('login') }}">
                                    <i class="bi bi-arrow-left"></i>
                                    Kembali login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
