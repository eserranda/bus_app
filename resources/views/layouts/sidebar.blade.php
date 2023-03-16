<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Pimpinan</div>
                    <a class="nav-link" href="/">
                        <div class="sb-nav-link-icon"><i class="fas fa-house"></i></div>
                        Dashboard
                    </a>
                    <a class="nav-link {{ request()->is('pimpinan/chart') ? 'active' : '' }}" href="/pimpinan/chart">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-chart-line"></i></div>
                        Grafik Data
                    </a>

                    <a class="nav-link  {{ request()->is('pimpinan/data-karyawan') ? 'active' : '' }}"
                        href="/pimpinan/data-karyawan">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                        Data Karyawan
                    </a>

                    <a class="nav-link {{ request()->is('pimpinan/data-driver') ? 'active' : '' }}"
                        href="/pimpinan/data-driver">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-user-gear"></i></div>Data Driver
                    </a>

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseGajiDriver" aria-expanded="false" aria-controls="collapseGajiDriver">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                        Gaji Driver
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>

                    <div class="collapse" id="collapseGajiDriver" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="/pimpinan/gaji-driver">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                                Gaji Driver
                            </a>
                            <a class="nav-link {{ request()->is('pimpinan/panjar-driver') ? 'active' : '' }}"
                                href="/pimpinan/panjar-driver">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-arrow-trend-down"></i></div>
                                Panjar Driver
                            </a>
                            <a class="nav-link {{ request()->is('pimpinan/persenan-gaji') ? 'active' : '' }}"
                                href="/pimpinan/persenan-gaji">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-percent"></i></div>
                                Persenan Gaji
                            </a>
                        </nav>
                    </div>

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseBOP"
                        aria-expanded="false" aria-controls="collapseBOP">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-users-gear"></i></div>
                        Biaya Operasional
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseBOP" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="/pimpinan/bbm">Biaya BBM </a>
                            <a class="nav-link" href="/pimpinan/perawatan-armada">Perawatan Armada</a>
                            <a class="nav-link" href="/pimpinan/gaji-karyawan">Gaji Karyawan</a>
                        </nav>
                    </div>


                    <div class="sb-sidenav-menu-heading">Laporan Penjualan Tiket</div>
                    <a class="nav-link {{ request()->is('pimpinan/laporan-keuangan') ? 'active' : '' }}"
                        href="/pimpinan/laporan-keuangan">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-list-ul"></i></div>
                        Laporan Keuangan
                    </a>

                    <a class="nav-link {{ request()->is('pimpinan/transaksi-tiket') ? 'active' : '' }}"
                        href="/pimpinan/transaksi-tiket">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-cash-register"></i></div>
                        Transaksi Tiket
                    </a>

                    {{-- <a class="nav-link" href="/pimpinan/gaji-driver">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                        Gaji Driver
                    </a>
                    <a class="nav-link {{ request()->is('pimpinan/persenan-gaji') ? 'active' : '' }}"
                        href="/pimpinan/persenan-gaji">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-percent"></i></div>
                        Persenan Gaji
                    </a> --}}

                    <div class="sb-sidenav-menu-heading">Pegawai</div>
                    {{-- <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">
                        <div class="sb-nav-link-icon"><i class="fas fa-house"></i></div>
                        Dashboard
                    </a> --}}


                    <a class="nav-link {{ request()->is('admin/data-pemesanan-tiket') ? 'active' : '' }}"
                        href="/admin/data-pemesanan-tiket">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-list-check"></i></div>
                        List Tiket
                    </a>

                    <a class="nav-link" href="/admin/pemesanan-tiket">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-ticket"></i></div>
                        Tiket
                    </a>

                    <a class="nav-link {{ request()->is('admin/keberangkatan') ? 'active' : '' }}"
                        href="/admin/keberangkatan">
                        <div class="sb-nav-link-icon"> <i class="fa-solid fa-share"></i></i>
                        </div>Keberangkatan
                    </a>

                    <a class="nav-link {{ request()->is('admin/kedatangan') ? 'active' : '' }}"
                        href="/admin/kedatangan">
                        <div class="sb-nav-link-icon">
                            <i class="fa-solid fa-reply"></i>
                        </div>Kedatangan
                    </a>

                    {{-- <a class="nav-link {{ request()->is('admin/data-pemesanan-tiket') ? 'active' : '' }}"
                        href="/admin/data-pemesanan-tiket">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-money-check-dollar"></i></div>
                        Data Pemesanan Tiket
                    </a> --}}

                    <a class="nav-link {{ request()->is('admin/verifikasi') ? 'active' : '' }}"
                        href="/admin/verifikasi">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-money-check-dollar"></i></div>
                        Verifikasi Tiket
                    </a>
                    <a class="nav-link" href="/admin/jadwal-tiket">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-ticket-simple"></i></i></div>
                        Jadwal Tiket
                    </a>

                    <a class="nav-link {{ request()->is('data-users') ? 'active' : '' }}" href="/data-users">
                        <div class="sb-nav-link-icon"> <i class="fa-solid fa-users"></i></div>
                        Data Users
                    </a>

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-bus"></i></div>
                        Bus
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse @yield('submenu')" id="collapseLayouts" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            {{-- <a class="nav-link {{ request()->is('input-jadwal') ? 'active' : '' }}"
                                href="/input-jadwal">Input
                                Jadwal</a> --}}
                            {{-- <a class="nav-link" href="/input-rute">Input Rute</a> --}}
                            <a class="nav-link {{ request()->is('admin/data-armada') ? 'active' : '' }}"
                                href="/admin/data-armada">Data Armada Bus</a>
                            {{-- <a class="nav-link {{ request()->is('admin/data-driver') ? 'active' : '' }}"
                                href="/admin/data-driver">Data Driver</a> --}}
                            <a class="nav-link {{ request()->is('admin/data-rute') ? 'active' : '' }}"
                                href="/admin/data-rute">Data Rute</a>
                            <a class="nav-link {{ request()->is('admin/data-keberangkatan') ? 'active' : '' }}"
                                href="/admin/data-keberangkatan">Data Keberangkatan</a>
                        </nav>
                    </div>

                    <div class="sb-sidenav-menu-heading">Users</div>
                    <a class="nav-link" href="/user/dashboard">
                        <div class="sb-nav-link-icon"><i class="fas fa-house"></i></div>
                        Dashboard
                    </a>
                    <a class="nav-link" href="/user/profile">
                        <div class="sb-nav-link-icon"> <i class="fa-solid fa-id-card"></i></div>
                        Profile
                    </a>
                    <a class="nav-link" href="/user/pembayaran">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                        Pembayaran
                    </a>

                    <div class="sb-sidenav-menu-heading">Interface</div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Layouts
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="layout-static.html">Static Navigation</a>
                            <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                        </nav>

                    </div>


                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                Start Bootstrap
            </div>
        </nav>
    </div>
