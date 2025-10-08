<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>PPID | PTUN Bandung</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="https://cdn.jsdelivr.net/npm/remixicon@3.6.0/fonts/remixicon.css" rel="stylesheet">
        
        @stack('styles') {{-- allows page CSS to load --}}
    </head>
    <body class="d-flex flex-column h-100">
        <main class="flex-shrink-0 pt-5">
            <!-- Navigation-->
            <nav class="navbar fixed-top navbar-expand-lg navbar-white bg-white shadow">
                <div class="container px-5">
                    <a class="navbar-brand" href="/"><img src = {{ asset('img/logoppid.png') }} class = 'navbar-brand' height ='60px' alt = 'PTUN Bandung logo'></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a class="nav-link" href="/">Beranda</a></li>
                            <li class="nav-item"><a class="nav-link" href="/profil">Profil</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownBlog" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Regulasi</a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownBlog">
                                    <li><a class="dropdown-item" href="https://jdih.mahkamahagung.go.id/index.php/legal-product/sk-kma-nomor-2-144kmaskviii2022/detail">Peraturan mengenai Keterbukaan Informasi Publik</a></li>
                                    <li><a class="dropdown-item" href="/surat-keterangan">SK PPID dan SK lainnya terkait Informasi</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownBlog" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Laporan</a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownBlog">
                                    <li><a class="dropdown-item" href="https://ptun-bandung.go.id/laporan-bulanan/">Laporan Bulanan</a></li>
                                    <li><a class="dropdown-item" href="https://ptun-bandung.go.id/laporan-tahunan/">Laporan Tahunan</a></li>
                                    <li><a class="dropdown-item" href="https://ptun-bandung.go.id/laporan-ikm-ipak/">laporan Indeks Kepuasan Masyarakat dan Indeks Persepsi Korupsi</a></li>
                                    <li><a class="dropdown-item" href="sakip">SAKIP</a></li>
                                    <li><a class="dropdown-item" href="https://ptun-bandung.go.id/laporan-perkara/">Laporan Perkara</a></li>
                                </ul>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="/standar-layanan">Standar Layanan</a></li>
                            <li class="nav-item d-none d-lg-block"><span class="nav-link text-muted">|</span></li>
                            @guest
                                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Log In</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Daftar</a></li>
                            @endguest

                            @auth
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                        Halo, {{ Str::limit(Auth::user()->name, 12, '...') }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                        <li><a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <i class="ri-home-2-fill"></i><span> Beranda</span>
                                        </a></li>

                                        <li><a class="dropdown-item" href="#">
                                        <i class="ri-booklet-fill"></i><span> Panduan Pengguna</span>
                                        </a></li>

                                        <li><a class="dropdown-item" href="{{ route('password.request') }}">
                                        <i class="ri-key-fill"></i><span> Ubah Kata Sandi</span>
                                        </a></li>

                                        <li><hr class="dropdown-divider"></li>
                                        <a class="dropdown-item text-danger" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="ri-logout-box-r-fill"></i> <span> Keluar</span>
                                        </a><form id="logout-form" action="/logout" method="POST" style="display: none;"> @csrf </form>
                                        </li>
                                    </ul>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </nav>
        </main>
        <!-- Slot: where content of the page is stored-->
        {{ $slot }}
        <!-- Footer-->
        <footer class="bg-dark py-4 mt-auto">
            <div class="container px-5">
                <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                    <div class="col-auto">
                        <div class="small m-0 text-white">
                            &copy; Pengadilan Tata Usaha Negara Bandung
                        </div>
                    </div>
                    <div class="col-auto">
                        <a class="link-light small" href="tel:+62227213999">📞 (022) 7213999</a>
                        <span class="text-white mx-1">&middot;</span>
                        <a class="link-light small" href="mailto:informasi@ptun-bandung.go.id">✉️ informasi@ptun-bandung.go.id</a>
                        <span class="text-white mx-1">&middot;</span>
                        <a class="link-light small" href="https://g.co/kgs/ECfzF8b" target="_blank">📍 Lokasi</a>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        @stack('scripts')
    </body>
</html>
