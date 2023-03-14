<ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-heading">APP</li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('kepala_sekolah.beranda') ? '' : 'collapsed' }}"
            href="{{ route('kepala_sekolah.beranda') }}">
            <i class="bi bi-grid"></i>
            <span>Beranda</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('kepala_sekolah.setting*') ? '' : 'collapsed' }}"
            href="{{ route('kepala_sekolah.setting.create') }}">
            <i class="bi bi-gear"></i>
            <span>Pengaturan</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('kepala_sekolah.logactivity*') ? '' : 'collapsed' }}"
            href="{{ route('kepala_sekolah.logactivity.index') }}">
            <i class="bi bi-gear"></i>
            <span>Aktivitas User</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('kepala_sekolah.logvisitor*') ? '' : 'collapsed' }}"
            href="{{ route('kepala_sekolah.logvisitor.index') }}">
            <i class="bi bi-gear"></i>
            <span>Monitoring Traffic URL</span>
        </a>
    </li>

    <li class="nav-heading">DATA MASTER</li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('kepala_sekolah.user.*') ? '' : 'collapsed' }}"
            href="{{ route('kepala_sekolah.user.index') }}">
            <i class="bi bi-people"></i>
            <span>Data User</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('kepala_sekolah.siswa.*') ? '' : 'collapsed' }}"
            href="{{ route('kepala_sekolah.siswa.index') }}">
            <i class="bi bi-people"></i>
            <span>Data Siswa/i</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('kepala_sekolah.wali.*') ? '' : 'collapsed' }}"
            href="{{ route('kepala_sekolah.wali.index') }}">
            <i class="bi bi-people"></i>
            <span>Data Wali Murid</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('kepala_sekolah.banksekolah.*') ? '' : 'collapsed' }}"
            href="{{ route('kepala_sekolah.banksekolah.index') }}">
            <i class="bi bi-credit-card"></i>
            <span>Data Rekening Sekolah</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('kepala_sekolah.biaya.*') ? '' : 'collapsed' }}"
            href="{{ route('kepala_sekolah.biaya.index') }}">
            <i class="bi bi-credit-card"></i>
            <span>Data Biaya</span>
        </a>
    </li>

    <li class="nav-heading">DATA TRANSAKSI</li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('kepala_sekolah.jobstatus*') ? '' : 'collapsed' }}"
            href="{{ route('kepala_sekolah.jobstatus.index') }}">
            <i class="bi bi-gear"></i>
            <span>Buat Tagihan</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('kepala_sekolah.tagihan.*') ? '' : 'collapsed' }}"
            href="{{ route('kepala_sekolah.tagihan.index') }}">
            <i class="bi bi-calendar2-check"></i>
            <span>Data Tagihan</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('kepala_sekolah.pembayaran.*') ? '' : 'collapsed' }}"
            href="{{ route('kepala_sekolah.pembayaran.index') }}">
            <i class="bi bi-upload"></i>
            <span>Data Pembayaran</span>
            <span class="mx-1"></span>
            <span class="badge bg-danger rounded-pill">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('kepala_sekolah.laporan*') ? '' : 'collapsed' }}"
            href="{{ route('kepala_sekolah.laporanform.create') }}">
            <i class="bi bi-file-check"></i>
            <span>Data Laporan</span>
        </a>
    </li>

    <li class="nav-heading">FITUR</li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('kepala_sekolah.migrasiform*') ? '' : 'collapsed' }}"
            href="{{ route('kepala_sekolah.migrasiform.index') }}">
            <i class="bi bi-box-arrow-right"></i>
            <span>Mutasi Siswa/i</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('logout') }}">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </a>
    </li>

</ul>
