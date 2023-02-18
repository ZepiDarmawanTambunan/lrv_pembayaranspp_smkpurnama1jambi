<ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-heading">APP</li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('operator.beranda') ? '' : 'collapsed' }}"
            href="{{ route('operator.beranda') }}">
            <i class="bi bi-grid"></i>
            <span>Beranda</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('setting*') ? '' : 'collapsed' }}" href="{{ route('setting.create') }}">
            <i class="bi bi-gear"></i>
            <span>Pengaturan</span>
        </a>
    </li>

    <li class="nav-heading">DATA MASTER</li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('user.*') ? '' : 'collapsed' }}" href="{{ route('user.index') }}">
            <i class="bi bi-people"></i>
            <span>Data User</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('siswa.*') ? '' : 'collapsed' }}" href="{{ route('siswa.index') }}">
            <i class="bi bi-people"></i>
            <span>Data Siswa</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('wali.*') ? '' : 'collapsed' }}" href="{{ route('wali.index') }}">
            <i class="bi bi-people"></i>
            <span>Data Wali Murid</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('banksekolah.*') ? '' : 'collapsed' }}"
            href="{{ route('banksekolah.index') }}">
            <i class="bi bi-credit-card"></i>
            <span>Data Rekening Sekolah</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('biaya.*') ? '' : 'collapsed' }}" href="{{ route('biaya.index') }}">
            <i class="bi bi-credit-card"></i>
            <span>Data Biaya</span>
        </a>
    </li>

    <li class="nav-heading">DATA TRANSAKSI</li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('tagihan.*') ? '' : 'collapsed' }}" href="{{ route('tagihan.index') }}">
            <i class="bi bi-calendar2-check"></i>
            <span>Data Tagihan SPP</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('pembayaran.*') ? '' : 'collapsed' }}"
            href="{{ route('pembayaran.index') }}">
            <i class="bi bi-upload"></i>
            <span>Data Pembayaran</span>
            <span class="mx-1"></span>
            <span class="badge bg-danger rounded-pill">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('laporan*') ? '' : 'collapsed' }}" href="{{ route('laporanform.create') }}">
            <i class="bi bi-file-check"></i>
            <span>Data Laporan</span>
        </a>
    </li>

    <li class="nav-heading">FITUR</li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('migrasiform*') ? '' : 'collapsed' }}"
            href="{{ route('migrasiform.index') }}">
            <i class="bi bi-box-arrow-right"></i>
            <span>Form Migrasi</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('logout') }}">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </a>
    </li>

</ul>
