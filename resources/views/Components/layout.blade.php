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
    </head>
    <body class="d-flex flex-column h-100">
        <main class="flex-shrink-0">
            <!-- Navigation-->
            <nav class="navbar fixed-top navbar-expand-lg navbar-white bg-white">
                <div class="container px-5">
                    <a class="navbar-brand" href="/"><img src = {{ asset('img/logoppid.png') }} class = 'navbar-brand' height ='80px' alt = 'PTUN Bandung logo'></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a class="nav-link" href="index.html">Beranda</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownBlog" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Profil</a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownBlog">
                                    <li><a class="dropdown-item" href="blog-home.html">Profil PPID</a></li>
                                    <li><a class="dropdown-item" href="blog-post.html">Visi & Misi</a></li>
                                    <li><a class="dropdown-item" href="blog-post.html">Tugas & Fungsi PPID</a></li>
                                    <li><a class="dropdown-item" href="blog-post.html">Struktur PPID</a></li>
                                    <li><a class="dropdown-item" href="blog-post.html">Tim PPID</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownBlog" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Regulasi</a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownBlog">
                                    <li><a class="dropdown-item" href="blog-home.html">Surat Keterangan PPID</a></li>
                                    <li><a class="dropdown-item" href="blog-home.html">SK PPID dan SK lainnya terkait Informasi</a></li>
                                </ul>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="pricing.html">Laporan</a></li>
                            <li class="nav-item"><a class="nav-link" href="faq.html">Standar Layanan</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownBlog" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Laporan</a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownBlog">
                                    <li><a class="dropdown-item" href="https://ptun-bandung.go.id/laporan-bulanan/">Laporan Bulanan</a></li>
                                    <li><a class="dropdown-item" href="https://ptun-bandung.go.id/laporan-tahunan/">Laporan Tahunan</a></li>
                                    <li><a class="dropdown-item" href="https://ptun-bandung.go.id/laporan-ikm-ipak/">laporan Indeks Kepuasan Masyarakat dan Indeks Persepsi Korupsi</a></li>
                                    <li><a class="dropdown-item" href="">SAKIP</a></li>
                                    <li><a class="dropdown-item" href="https://ptun-bandung.go.id/laporan-perkara/">Laporan Perkara</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownPortfolio" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Standar Layanan</a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownPortfolio">
                                    <li><a class="dropdown-item" href="portfolio-overview.html">SOP PPID</a></li>
                                    <li><a class="dropdown-item" href="portfolio-item.html">Jam Kerja dan Layanan</a></li>
                                    <li><a class="dropdown-item" href="portfolio-item.html">Maklumat PPID</a></li>
                                </ul>
                            </li>
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
                    <div class="col-auto"><div class="small m-0 text-white">Copyright &copy; Your Website 2023</div></div>
                    <div class="col-auto">
                        <a class="link-light small" href="#!">Privacy</a>
                        <span class="text-white mx-1">&middot;</span>
                        <a class="link-light small" href="#!">Terms</a>
                        <span class="text-white mx-1">&middot;</span>
                        <a class="link-light small" href="#!">Contact</a>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src={{ asset('js/script.js') }}></script>
    </body>
</html>
