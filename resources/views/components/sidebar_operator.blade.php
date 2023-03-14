<ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-heading">APP</li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('operator.beranda') ? '' : 'collapsed' }}"
            href="{{ route('operator.beranda') }}">
            <i class="bi bi-grid"></i>
            <span>Beranda</span>
        </a>
    </li>

    <li class="nav-heading">DATA MASTER</li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('operator.siswa.*') ? '' : 'collapsed' }}"
            href="{{ route('operator.siswa.index') }}">
            <i class="bi bi-people"></i>
            <span>Data Siswa/i</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('operator.wali.*') ? '' : 'collapsed' }}"
            href="{{ route('operator.wali.index') }}">
            <i class="bi bi-people"></i>
            <span>Data Wali Murid</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('operator.banksekolah.*') ? '' : 'collapsed' }}"
            href="{{ route('operator.banksekolah.index') }}">
            <i class="bi bi-credit-card"></i>
            <span>Data Rekening Sekolah</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('operator.biaya.*') ? '' : 'collapsed' }}"
            href="{{ route('operator.biaya.index') }}">
            <i class="bi bi-credit-card"></i>
            <span>Data Biaya</span>
        </a>
    </li>

    <li class="nav-heading">DATA TRANSAKSI</li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('operator.jobstatus*') ? '' : 'collapsed' }}"
            href="{{ route('operator.jobstatus.index') }}">
            <i class="bi bi-gear"></i>
            <span>Buat Tagihan</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('operator.tagihan.*') ? '' : 'collapsed' }}"
            href="{{ route('operator.tagihan.index') }}">
            <i class="bi bi-calendar2-check"></i>
            <span>Data Tagihan</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('operator.pembayaran.*') ? '' : 'collapsed' }}"
            href="{{ route('operator.pembayaran.index') }}">
            <i class="bi bi-upload"></i>
            <span>Data Pembayaran</span>
            <span class="mx-1"></span>
            <span class="badge bg-danger rounded-pill">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        </a>
    </li>

    <li class="nav-heading">FITUR</li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('operator.migrasiform*') ? '' : 'collapsed' }}"
            href="{{ route('operator.migrasiform.index') }}">
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
