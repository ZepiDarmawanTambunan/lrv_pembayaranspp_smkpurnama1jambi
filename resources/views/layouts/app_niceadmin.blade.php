<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>
        {{ @$title != '' ? "$title |" : '' }} {{ settings()->get('app_name', 'My APP') }}
    </title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{ \Storage::url(settings('app_logo')) }}" rel="icon">
    {{-- <link href="{{ asset('niceadmin') }}/assets/img/apple-touch-icon.png" rel="apple-touch-icon"> --}}

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('niceadmin') }}/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('niceadmin') }}/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('niceadmin') }}/assets/css/style.css" rel="stylesheet">

    {{-- YOUR CSS & SCRIPT --}}
    <link rel="stylesheet" href="{{ asset('font/css/all.min.css') }}">
    <style>
        .layout-navbar .navbar-dropdown .dropdown-menu {
            min-width: 22rem;
            overflow: hidden;
        }

        /* CSS */
        .loading-overlay {
            position: fixed;
            /* Atur posisi fixed agar loading overlay tidak bergerak saat halaman di-scroll */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.5);
            /* Atur transparansi dengan rgba */
            z-index: 9999;
            /* Atur z-index agar loading overlay muncul di atas konten lain */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-group label {
            font-size: 14px;
            line-height: 22px;
        }

        /* TABEL */

        table tr:first-child th:first-child {
            border-top-left-radius: 0.5rem !important;
        }

        table tr:first-child th:last-child {
            border-top-right-radius: 0.5rem !important;
        }

        table tr:last-child td:first-child {
            border-bottom-left-radius: 0.5rem !important;
        }

        table tr:last-child td:last-child {
            border-bottom-right-radius: 0.5rem !important;
        }

        table tbody td {
            font-size: 14px;
        }

        table thead th {
            font-size: 15px;
        }

        .table-dark {
            --bs-table-bg: #4b5563;
            /* background-color: #4a5073 !important; */
        }

        /* atur padding */
        .table>:not(caption)>*>* {
            padding: 0.8rem 1rem !important;
        }

        /* border setiap tr dihapus */
        .table>:not(caption)>*>* {
            border-bottom-width: 0px;
        }

        /* BTN */

        .btn-sm {
            padding: 0.20rem 0.3rem !important;
            font-size: .8rem !important;
        }

        .card-hover:hover {
            -webkit-transform: translateY(-4px) scale(1.01);
            -moz-transform: translateY(-4px) scale(1.01);
            -ms-transform: translateY(-4px) scale(1.01);
            -o-transform: translateY(-4px) scale(1.01);
            transform: translateY(-4px) scale(1.01);
            -webkit-box-shadow: 0 14px 24px rgb(62 57 107 / 10%);
            box-shadow: 0 14px 24px rgb(62 57 107 / 10%);
        }

        .card-hover {
            -webkit-transition: all .25s ease;
            -o-transition: all .25s ease;
            -moz-transition: all .25s ease;
            transition: all .25s ease;
        }
    </style>
    <script>
        const popupCenter = ({
            url,
            title,
            w,
            h
        }) => {
            // Fixes dual-screen position                             Most browsers      Firefox
            const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screenX;
            const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screenY;

            const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document
                .documentElement.clientWidth : screen.width;
            const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document
                .documentElement.clientHeight : screen.height;

            const systemZoom = width / window.screen.availWidth;
            const left = (width - w) / 2 / systemZoom + dualScreenLeft
            const top = (height - h) / 2 / systemZoom + dualScreenTop
            const newWindow = window.open(url, title,
                `
          scrollbars=yes,
          width=${w / systemZoom},
          height=${h / systemZoom},
          top=${top},
          left=${left}
          `
            )

            if (window.focus) newWindow.focus();
        }
    </script>
</head>

<body>
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route(auth()->user()->akses . '.beranda') }}" class="logo d-flex align-items-center">
                <img src="{{ \Storage::url(settings()->get('app_logo')) }}" alt="">
                <span class="d-none d-lg-block">SMK PURNAMA 1</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        @if (auth()->user()->akses == 'operator')
            <div class="search-bar">
                {!! Form::open([
                    'route' => 'tagihan.index',
                    'method' => 'GET',
                    'class' => 'search-form d-flex align-items-center',
                ]) !!}
                <input type="text" name="q" placeholder="Search" title="Enter search keyword"
                    value="{{ request('q') }}">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                {!! Form::close() !!}
            </div><!-- End Search Bar -->
        @else
            <div class="search-bar">
                {!! Form::open([
                    'route' => 'wali.tagihan.index',
                    'method' => 'GET',
                    'class' => 'search-form d-flex align-items-center',
                ]) !!}
                <input type="text" name="q" placeholder="Search" title="Enter search keyword"
                    value="{{ request('q') }}">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                {!! Form::close() !!}
            </div><!-- End Search Bar -->
        @endif

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->

                <li class="nav-item dropdown">

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-danger badge-number">
                            {{ Auth::user()->unreadNotifications->count() }}
                        </span>
                    </a><!-- End Notification Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                        <li class="dropdown-header">
                            You have {{ Auth::user()->unreadNotifications->count() }} new notifications
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2"></span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        @forelse (auth()->user()->unreadNotifications->sortBy('created_at')->take(3) as $number => $notification)
                            <li class="message-item">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <a href="{{ url($notification->data['url'] . '?id=' . $notification->id) }}">
                                            <div>
                                                <h4>{{ $notification->data['title'] }}</h4>
                                                <p>{{ ucwords($notification->data['messages']) }}</p>
                                                <p>{{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                        {!! Form::open([
                                            'route' => ['wali.notifikasi.update', $notification->id],
                                            'method' => 'PUT',
                                        ]) !!}
                                        <button type="submit" class="btn dropdown-notifications-archive">
                                            <i class="bi bi-x-lg text-danger"></i>
                                        </button>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        @empty
                            <li class="message-item">
                                <div class="text-center text-sm">Tidak ada notifikasi</div>
                            </li>
                        @endforelse

                        <li class="dropdown-footer">
                            <a href="#">Show all notifications</a>
                        </li>

                    </ul><!-- End Messages Dropdown Items -->

                </li><!-- End Messages Nav -->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        <img src="{{ \Storage::url('images/user.png') }}" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name }}</span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ auth()->user()->name }}</h6>
                            <span>{{ auth()->user()->email }}</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        @if (auth()->user()->akses == 'operator')
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('user.edit', auth()->user()->id) }}">
                                    <i class="bi bi-person"></i>
                                    <span>Ubah Profil</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('setting.create') }}">
                                    <i class="bi bi-gear"></i>
                                    <span>Pengaturan</span>
                                </a>
                            </li>
                        @else
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('wali.profil.create', auth()->user()->id) }}">
                                    <i class="bi bi-person"></i>
                                    <span>Ubah Profil</span>
                                </a>
                            </li>
                        @endif
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Log Out</span>
                            </a>
                        </li>

                    </ul>
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        @if (auth()->user()->akses == 'operator')
            @include('components.sidebar')
        @else
            @include('components.sidebar_wali')
        @endif

    </aside>
    <!-- End Sidebar-->

    <main id="main" class="main">
        <section class="section dashboard">
            <div class="row">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {!! implode('', $errors->all('<div>:message</div>')) !!}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif
                @yield('content')
            </div>
        </section>
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; 2022, Made By Zepi Darmawan T
        </div>
        <div class="credits">
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> & <a href="#">NiceAdmin</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('niceadmin') }}/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('niceadmin') }}/assets/vendor/tinymce/tinymce.min.js"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('niceadmin') }}/assets/js/main.js"></script>

    {{-- YOUR SCRIPT --}}
    <script src="{{ asset('niceadmin') }}/assets/js/jquery-3.6.3.min.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.rupiah').mask("#.##0", {
                reverse: true
            });
            $('.select2').select2();
        });
    </script>
    @yield('js');

</body>

</html>
