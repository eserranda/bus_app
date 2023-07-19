  <!-- Navbar  dan Header-->
  <header class="navbar navbar-expand-md navbar-light d-print-none sticky-top">
      <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
              aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
              <a href="#">
                  <img src="{{ asset('assets') }}/static/logo.svg" width="110" height="32" alt="Tabler"
                      class="navbar-brand-image">
              </a>
          </h1>
          {{-- <h1>Halo {{ session('role') }}</h1> --}}
          <div class="navbar-nav flex-row order-md-last">
              <div class="d-none d-md-flex">
                  <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode"
                      data-bs-toggle="tooltip" data-bs-placement="bottom">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                          viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                          stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                      </svg>
                  </a>
                  <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode"
                      data-bs-toggle="tooltip" data-bs-placement="bottom">
                      <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                          viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                          stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                          <path
                              d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                      </svg>
                  </a>
                  <div class="nav-item dropdown d-none d-md-flex me-3">
                      <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1"
                          aria-label="Show notifications">
                          <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                              viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                              stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <path
                                  d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                              <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                          </svg>
                          <span class="badge bg-red"></span>
                      </a>
                      {{-- <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                          <div class="card">
                              <div class="card-header">
                                  <h3 class="card-title">Last updates</h3>
                              </div>
                              <div class="list-group list-group-flush list-group-hoverable">
                                  <div class="list-group-item">
                                      <div class="row align-items-center">
                                          <div class="col-auto"><span
                                                  class="status-dot status-dot-animated bg-red d-block"></span></div>
                                          <div class="col text-truncate">
                                              <a href="#" class="text-body d-block">Example 1</a>
                                              <div class="d-block text-muted text-truncate mt-n1">
                                                  Change deprecated html tags to text decoration classes (#29604)
                                              </div>
                                          </div>
                                          <div class="col-auto">
                                              <a href="#" class="list-group-item-actions">
                                                  <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted"
                                                      width="24" height="24" viewBox="0 0 24 24"
                                                      stroke-width="2" stroke="currentColor" fill="none"
                                                      stroke-linecap="round" stroke-linejoin="round">
                                                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                      <path
                                                          d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                  </svg>
                                              </a>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="list-group-item">
                                      <div class="row align-items-center">
                                          <div class="col-auto"><span class="status-dot d-block"></span></div>
                                          <div class="col text-truncate">
                                              <a href="#" class="text-body d-block">Example 2</a>
                                              <div class="d-block text-muted text-truncate mt-n1">
                                                  justify-content:between ⇒ justify-content:space-between (#29734)
                                              </div>
                                          </div>
                                          <div class="col-auto">
                                              <a href="#" class="list-group-item-actions show">
                                                  <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon text-yellow"
                                                      width="24" height="24" viewBox="0 0 24 24"
                                                      stroke-width="2" stroke="currentColor" fill="none"
                                                      stroke-linecap="round" stroke-linejoin="round">
                                                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                      <path
                                                          d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                  </svg>
                                              </a>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="list-group-item">
                                      <div class="row align-items-center">
                                          <div class="col-auto"><span class="status-dot d-block"></span></div>
                                          <div class="col text-truncate">
                                              <a href="#" class="text-body d-block">Example 3</a>
                                              <div class="d-block text-muted text-truncate mt-n1">
                                                  Update change-version.js (#29736)
                                              </div>
                                          </div>
                                          <div class="col-auto">
                                              <a href="#" class="list-group-item-actions">
                                                  <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted"
                                                      width="24" height="24" viewBox="0 0 24 24"
                                                      stroke-width="2" stroke="currentColor" fill="none"
                                                      stroke-linecap="round" stroke-linejoin="round">
                                                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                      <path
                                                          d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                  </svg>
                                              </a>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="list-group-item">
                                      <div class="row align-items-center">
                                          <div class="col-auto"><span
                                                  class="status-dot status-dot-animated bg-green d-block"></span></div>
                                          <div class="col text-truncate">
                                              <a href="#" class="text-body d-block">Example 4</a>
                                              <div class="d-block text-muted text-truncate mt-n1">
                                                  Regenerate package-lock.json (#29730)
                                              </div>
                                          </div>
                                          <div class="col-auto">
                                              <a href="#" class="list-group-item-actions">
                                                  <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted"
                                                      width="24" height="24" viewBox="0 0 24 24"
                                                      stroke-width="2" stroke="currentColor" fill="none"
                                                      stroke-linecap="round" stroke-linejoin="round">
                                                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                      <path
                                                          d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                  </svg>
                                              </a>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div> --}}
                  </div>
              </div>

              <div class="nav-item dropdown">
                  <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                      aria-label="Open user menu">
                      <span class="avatar avatar-sm"
                          style="background-image: url({{ asset('assets') }}/static/avatars/000m.jpg)"></span>
                      <div class="d-none d-xl-block ps-2">
                          <div>{{ session('nama') }}</div>
                          <div class="mt-1 small text-muted">{{ session('role') }}</div>
                      </div>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <a href="#" class="dropdown-item">Status</a>
                      <a href="./profile.html" class="dropdown-item">Profile</a>
                      <a href="#" class="dropdown-item">Feedback</a>
                      <div class="dropdown-divider"></div>
                      <a href="./settings.html" class="dropdown-item">Settings</a>
                      <a href="/logout" class="dropdown-item">Logout</a>
                  </div>
              </div>
          </div>
          <div class="collapse navbar-collapse" id="navbar-menu">
              <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                  <ul class="navbar-nav">
                      {{-- <li class="nav-item">
                          <a class="nav-link" href="/">
                              <span class="nav-link-icon d-md-none d-lg-inline-block">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                      height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                      fill="none" stroke-linecap="round" stroke-linejoin="round">
                                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                      <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                      <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                      <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                  </svg>
                              </span>
                              <span class="nav-link-title">
                                  Home
                              </span>
                          </a>
                      </li> --}}
                      @if (session('role') === 'pegawai')
                          <li class="nav-item">
                              <a class="nav-link" href="/admin/pemesanan-tiket">
                                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                                      <svg xmlns="http://www.w3.org/2000/svg"
                                          class="icon icon-tabler icon-tabler-ticket" width="24" height="24"
                                          viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                          stroke-linecap="round" stroke-linejoin="round">
                                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                          <path d="M15 5l0 2"></path>
                                          <path d="M15 11l0 2"></path>
                                          <path d="M15 17l0 2"></path>
                                          <path
                                              d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2">
                                          </path>
                                      </svg>
                                  </span>
                                  <span class="nav-link-title">
                                      Tiket
                                  </span>
                              </a>
                          </li>
                      @endif
                      @if (session('role') === 'pimpinan')
                          <li class="nav-item">
                              <a class="nav-link" href="/pimpinan/chart">
                                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                                      <svg xmlns="http://www.w3.org/2000/svg"
                                          class="icon icon-tabler icon-tabler-chart-histogram" width="24"
                                          height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                          fill="none" stroke-linecap="round" stroke-linejoin="round">
                                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                          <path d="M3 3v18h18"></path>
                                          <path d="M20 18v3"></path>
                                          <path d="M16 16v5"></path>
                                          <path d="M12 13v8"></path>
                                          <path d="M8 16v5"></path>
                                          <path d="M3 11c6 0 5 -5 9 -5s3 5 9 5"></path>
                                      </svg>
                                  </span>
                                  <span class="nav-link-title">
                                      Grafik
                                  </span>
                              </a>
                          </li>
                      @endif
                      @if (session('role') === 'pimpinan')
                          <li class="nav-item">
                              <a class="nav-link" href="/pimpinan/laporan-keuangan">
                                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                                      <svg xmlns="http://www.w3.org/2000/svg"
                                          class="icon icon-tabler icon-tabler-report-money" width="24"
                                          height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                          fill="none" stroke-linecap="round" stroke-linejoin="round">
                                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                          <path
                                              d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2">
                                          </path>
                                          <path
                                              d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z">
                                          </path>
                                          <path d="M14 11h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5"></path>
                                          <path d="M12 17v1m0 -8v1"></path>
                                      </svg>
                                  </span>
                                  <span class="nav-link-title">
                                      Laporan Keuangan
                                  </span>
                              </a>
                          </li>
                      @endif
                      @if (session('role') === 'pegawai')
                          <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                                  data-bs-auto-close="outside" role="button" aria-expanded="false">
                                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                                      <svg xmlns="http://www.w3.org/2000/svg"
                                          class="icon icon-tabler icon-tabler-clipboard-list" width="24"
                                          height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                          fill="none" stroke-linecap="round" stroke-linejoin="round">
                                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                          <path
                                              d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2">
                                          </path>
                                          <path
                                              d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z">
                                          </path>
                                          <path d="M9 12l.01 0"></path>
                                          <path d="M13 12l2 0"></path>
                                          <path d="M9 16l.01 0"></path>
                                          <path d="M13 16l2 0"></path>
                                      </svg>
                                  </span>
                                  <span class="nav-link-title">
                                      Pesanan Tiket
                                  </span>
                              </a>
                              <div class="dropdown-menu">
                                  <div class="dropdown-menu-columns">
                                      <div class="dropdown-menu-column">
                                          <a class="dropdown-item" href="/admin/data-pemesanan-tiket">
                                              Data Pembelian Tiket
                                          </a>
                                      </div>
                                      <div class="dropdown-menu-column">
                                          <a class="dropdown-item" href="/admin/verifikasi">
                                              Verifikasi Tiket
                                          </a>
                                          {{-- <a class="dropdown-item" href="./placeholder.html">
                                          Placeholder
                                      </a> --}}

                                      </div>
                                  </div>
                              </div>
                          </li>

                          <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                                  data-bs-auto-close="outside" role="button" aria-expanded="false">
                                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                                      <svg xmlns="http://www.w3.org/2000/svg"
                                          class="icon icon-tabler icon-tabler-history" width="24" height="24"
                                          viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                          stroke-linecap="round" stroke-linejoin="round">
                                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                          <path d="M12 8l0 4l2 2"></path>
                                          <path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5"></path>
                                      </svg>
                                  </span>
                                  <span class="nav-link-title">
                                      KBR / KDT
                                  </span>
                              </a>
                              <div class="dropdown-menu">
                                  <div class="dropdown-menu-columns">
                                      <div class="dropdown-menu-column">
                                          <a class="dropdown-item" href="/admin/keberangkatan">
                                              <svg xmlns="http://www.w3.org/2000/svg"
                                                  class="icon icon-tabler icon-tabler-square-rounded-arrow-right-filled"
                                                  width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                  stroke="currentColor" fill="none" stroke-linecap="round"
                                                  stroke-linejoin="round">
                                                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                  <path
                                                      d="M12 2c-.218 0 -.432 .002 -.642 .005l-.616 .017l-.299 .013l-.579 .034l-.553 .046c-4.785 .464 -6.732 2.411 -7.196 7.196l-.046 .553l-.034 .579c-.005 .098 -.01 .198 -.013 .299l-.017 .616l-.004 .318l-.001 .324c0 .218 .002 .432 .005 .642l.017 .616l.013 .299l.034 .579l.046 .553c.464 4.785 2.411 6.732 7.196 7.196l.553 .046l.579 .034c.098 .005 .198 .01 .299 .013l.616 .017l.642 .005l.642 -.005l.616 -.017l.299 -.013l.579 -.034l.553 -.046c4.785 -.464 6.732 -2.411 7.196 -7.196l.046 -.553l.034 -.579c.005 -.098 .01 -.198 .013 -.299l.017 -.616l.005 -.642l-.005 -.642l-.017 -.616l-.013 -.299l-.034 -.579l-.046 -.553c-.464 -4.785 -2.411 -6.732 -7.196 -7.196l-.553 -.046l-.579 -.034a28.058 28.058 0 0 0 -.299 -.013l-.616 -.017l-.318 -.004l-.324 -.001zm.613 5.21l.094 .083l4 4a.927 .927 0 0 1 .097 .112l.071 .11l.054 .114l.035 .105l.03 .148l.006 .118l-.003 .075l-.017 .126l-.03 .111l-.044 .111l-.052 .098l-.074 .104l-.073 .082l-4 4a1 1 0 0 1 -1.497 -1.32l.083 -.094l2.292 -2.293h-5.585a1 1 0 0 1 -.117 -1.993l.117 -.007h5.585l-2.292 -2.293a1 1 0 0 1 -.083 -1.32l.083 -.094a1 1 0 0 1 1.32 -.083z"
                                                      fill="currentColor" stroke-width="0"></path>
                                              </svg>
                                              Keberangkatan Bus
                                          </a>

                                          <a class="dropdown-item" href="/admin/kedatangan">
                                              <svg xmlns="http://www.w3.org/2000/svg"
                                                  class="icon icon-tabler icon-tabler-square-rounded-arrow-left-filled"
                                                  width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                  stroke="currentColor" fill="none" stroke-linecap="round"
                                                  stroke-linejoin="round">
                                                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                  <path
                                                      d="M12 2l.324 .001l.318 .004l.616 .017l.299 .013l.579 .034l.553 .046c4.785 .464 6.732 2.411 7.196 7.196l.046 .553l.034 .579c.005 .098 .01 .198 .013 .299l.017 .616l.005 .642l-.005 .642l-.017 .616l-.013 .299l-.034 .579l-.046 .553c-.464 4.785 -2.411 6.732 -7.196 7.196l-.553 .046l-.579 .034c-.098 .005 -.198 .01 -.299 .013l-.616 .017l-.642 .005l-.642 -.005l-.616 -.017l-.299 -.013l-.579 -.034l-.553 -.046c-4.785 -.464 -6.732 -2.411 -7.196 -7.196l-.046 -.553l-.034 -.579a28.058 28.058 0 0 1 -.013 -.299l-.017 -.616c-.003 -.21 -.005 -.424 -.005 -.642l.001 -.324l.004 -.318l.017 -.616l.013 -.299l.034 -.579l.046 -.553c.464 -4.785 2.411 -6.732 7.196 -7.196l.553 -.046l.579 -.034c.098 -.005 .198 -.01 .299 -.013l.616 -.017c.21 -.003 .424 -.005 .642 -.005zm.707 5.293a1 1 0 0 0 -1.414 0l-4 4a1.037 1.037 0 0 0 -.2 .284l-.022 .052a.95 .95 0 0 0 -.06 .222l-.008 .067l-.002 .063v-.035v.073a1.034 1.034 0 0 0 .07 .352l.023 .052l.03 .061l.022 .037a1.2 1.2 0 0 0 .05 .074l.024 .03l.073 .082l4 4l.094 .083a1 1 0 0 0 1.32 -.083l.083 -.094a1 1 0 0 0 -.083 -1.32l-2.292 -2.293h5.585l.117 -.007a1 1 0 0 0 -.117 -1.993h-5.585l2.292 -2.293l.083 -.094a1 1 0 0 0 -.083 -1.32z"
                                                      fill="currentColor" stroke-width="0"></path>
                                              </svg>
                                              Kedatangan Bus
                                          </a>
                                      </div>

                                  </div>
                              </div>
                          </li>
                      @endif
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                              data-bs-auto-close="outside" role="button" aria-expanded="false">
                              <span class="nav-link-icon d-md-none d-lg-inline-block">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-coin"
                                      width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                      stroke="currentColor" fill="none" stroke-linecap="round"
                                      stroke-linejoin="round">
                                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                      <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                      <path
                                          d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 1 0 0 4h2a2 2 0 1 1 0 4h-2a2 2 0 0 1 -1.8 -1">
                                      </path>
                                      <path d="M12 7v10"></path>
                                  </svg>
                              </span>
                              <span class="nav-link-title">
                                  B.O.P
                              </span>
                          </a>

                          <div class="dropdown-menu">
                              <div class="dropdown-menu-columns">
                                  <div class="dropdown-menu-column">
                                      <a class="dropdown-item" href="/pimpinan/gaji-driver">
                                          Gaji Driver
                                      </a>
                                      <a class="dropdown-item" href="/pimpinan/panjar-driver">
                                          Panjar Driver
                                      </a>
                                      <a class="dropdown-item" href="/pimpinan/persenan-gaji">
                                          Persenan Gaji
                                      </a>
                                  </div>
                                  <div class="dropdown-menu-column">
                                      <a class="dropdown-item" href="/pimpinan/bbm">
                                          Biaya BBM
                                      </a>
                                      <a class="dropdown-item" href="/pimpinan/perawatan-armada">
                                          Perawatan Armada
                                      </a>
                                      <a class="dropdown-item" href="/pimpinan/gaji-karyawan">
                                          Gaji Karyawan
                                      </a>

                                  </div>
                              </div>
                          </div>

                      </li>
                      @if (session('role') === 'pegawai')
                          <li class="nav-item">
                              <a class="nav-link" href="/admin/jadwal-tiket">
                                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                                      <svg xmlns="http://www.w3.org/2000/svg"
                                          class="icon icon-tabler icon-tabler-calendar-stats" width="24"
                                          height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                          fill="none" stroke-linecap="round" stroke-linejoin="round">
                                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                          <path
                                              d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4">
                                          </path>
                                          <path d="M18 14v4h4"></path>
                                          <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                          <path d="M15 3v4"></path>
                                          <path d="M7 3v4"></path>
                                          <path d="M3 11h16"></path>
                                      </svg>
                                  </span>
                                  <span class="nav-link-title">
                                      Jadwal
                                  </span>
                              </a>
                          </li>
                      @endif
                      @if (session('role') === 'pimpinan')
                          <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                                  data-bs-auto-close="outside" role="button" aria-expanded="false">
                                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                                      <svg xmlns="http://www.w3.org/2000/svg"
                                          class="icon icon-tabler icon-tabler-database" width="24" height="24"
                                          viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                          stroke-linecap="round" stroke-linejoin="round">
                                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                          <path d="M12 6m-8 0a8 3 0 1 0 16 0a8 3 0 1 0 -16 0"></path>
                                          <path d="M4 6v6a8 3 0 0 0 16 0v-6"></path>
                                          <path d="M4 12v6a8 3 0 0 0 16 0v-6"></path>
                                      </svg>
                                  </span>
                                  <span class="nav-link-title">
                                      Data
                                  </span>
                              </a>
                              <div class="dropdown-menu">
                                  <div class="dropdown-menu-columns">
                                      <div class="dropdown-menu-column">
                                          <a class="dropdown-item" href="/pimpinan/data-user">
                                              Data Karyawan
                                          </a>
                                          {{-- <a class="dropdown-item" href="/pimpinan/data-karyawan">
                                              Data Karyawan
                                          </a> --}}
                                          <a class="dropdown-item" href="/pimpinan/data-driver">
                                              Data Driver
                                          </a>
                                          <a class="dropdown-item" href="/admin/data-armada">
                                              Data Armada Bus
                                          </a>
                                          <a class="dropdown-item" href="/admin/data-rute">
                                              Data Rute
                                          </a>
                                      </div>

                                  </div>
                              </div>
                          </li>
                      @endif


                      {{-- <li class="nav-item">
                          <a class="nav-link" href="/admin/pemesanan-tiket">
                              <span class="nav-link-icon d-md-none d-lg-inline-block">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ticket"
                                      width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                      stroke="currentColor" fill="none" stroke-linecap="round"
                                      stroke-linejoin="round">
                                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                      <path d="M15 5l0 2"></path>
                                      <path d="M15 11l0 2"></path>
                                      <path d="M15 17l0 2"></path>
                                      <path
                                          d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2">
                                      </path>
                                  </svg>
                              </span>
                              <span class="nav-link-title">
                                  Tiket
                              </span>
                          </a>
                      </li> --}}


                  </ul>
              </div>
          </div>
      </div>
  </header>
