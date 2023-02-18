<ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-heading">APP</li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('wali.beranda') ? '' : 'collapsed' }}" href="{{ route('wali.beranda') }}">
            <i class="bi bi-grid"></i>
            <span>Beranda</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('wali.profil.*') ? '' : 'collapsed' }}" href="{{ route('wali.profil.create') }}">
            <i class="bi bi-person"></i>
            <span>Ubah Profil</span>
        </a>
    </li>

    <li class="nav-heading">Pages</li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('wali.siswa.*') ? '' : 'collapsed' }}" href="{{ route('wali.siswa.index') }}">
            <i class="bi bi-people"></i>
            <span>Data Siswa</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ \Route::is('wali.tagihan.*') || \Route::is('wali.pembayaran.*') ? '' : 'collapsed' }}"
            href="{{ route('wali.tagihan.index') }}">
            <i class="bi bi-calendar2-check"></i>
            <span>Data Tagihan</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('logout') }}">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </a>
    </li>

</ul>
