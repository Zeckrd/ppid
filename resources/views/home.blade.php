<x-layout>
    <x-header>
        <h1 class="display-5 fw-bolder pt-3 mb-2">Pejabat Pengelola Informasi dan Dokumentasi (PPID) PTUN Bandung</h1>
    </x-header>

    <!-- Section Cards to Permohonan dan Keberatan-->
    <section class="py-3">
                <div class="container px-5 my-5">
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-8 col-xl-6">
                            <div class="text-center">
                                <h2 class="fw-bolder">Form Pengajuan</h2>
                                <p class="lead fw-normal text-muted mb-5">Pilih jenis pengajuan yang sesuai dengan kebutuhan Anda.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-4 mb-5">
                            <div class="card h-100 shadow border-0">
                                <img class="card-img-top" src="{{ asset('img/thumbnail-informasi.png') }}" alt="..." />
                                <div class="card-body p-4">
                                    <a class="text-decoration-none link-dark stretched-link" href="#!"><h5 class="card-title mb-3">Permohonan Informasi</h5></a>
                                    <p class="card-text mb-0">Ajukan permintaan informasi publik untuk mengakses informasi yang dimiliki PTUN Bandung.</p>
                                </div>
                                <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                    <button type="button" class="btn btn-primary">Ajukan Permohonan</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-5">
                            <div class="card h-100 shadow border-0">
                                <img class="card-img-top" src="{{ asset('img/thumbnail-keberatan.png') }}" alt="..." />
                                <div class="card-body p-4">
                                    <a class="text-decoration-none link-dark stretched-link" href="#!"><h5 class="card-title mb-3">Pengajuan Keberatan Atas Pelayanan Informasi</h5></a>
                                    <p class="card-text mb-0">Sampaikan keberatan Anda jika permohonan informasi tidak ditanggapi sebagaimana mestinya oleh PPID PTUN Bandung.</p>
                                </div>
                                <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                    <button type="button" class="btn btn-primary">Ajukan Keberatan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    <!-- End of Section Cards -->
    <!-- Features section-->
    <!-- TODO: FIX 
                    <div class="col">
                    <a>...</a>
                    </div>

                    DONOT
                    
                    <a>
                    <div class="col">...</div>
                    </a>-->
    <section class="py-5" id="features">
        <div class="container px-5 my-5">
            <div class="row gx-5">
                <div class="col-lg-4 mb-5 mb-lg-0"><h2 class="fw-bolder mb-0">Prosedur Pelayanan</h2></div>
                <div class="col-lg-8">
                    <div class="row gx-5 row-cols-1 row-cols-md-2">
                    <a href="#" class="text-decoration-none text-reset">
                        <div class="col mb-5 h-100 feature-box">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="ri-file-3-fill"></i></div>
                            <h2 class="h5">Prosedur Pelayanan</h2>
                            <p class="mb-0">Langkah-langkah dalam mengajukan permintaan informasi publik di PTUN Bandung</p>
                        </div>
                    </a>
                    <a href="#" class="text-decoration-none text-reset">
                        <div class="col mb-5 h-100 feature-box">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-collection"></i></div>
                            <h2 class="h5">Informasi Berkala</h2>
                            <p class="mb-0">Informasi yang secara rutin diterbitkan dan tersedia tanpa perlu permintaan khusus.</p>
                        </div>
                    </a>
                    <a href="#" class="text-decoration-none text-reset">
                        <div class="col mb-5 h-100 feature-box">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="ri-book-read-fill"></i></div>
                            <h2 class="h5">Informasi Tersedia Setiap Saat</h2>
                            <p class="mb-0">Informasi publik yang dapat diakses kapan saja tanpa syarat khusus.</p>
                        </div>
                    </a>
                    <a href="#" class="text-decoration-none text-reset">
                        <div class="col mb-5 h-100 feature-box">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="ri-chat-delete-line"></i></div>
                            <h2 class="h5">Informasi yang di Kecualikan</h2>
                            <p class="mb-0">Jenis informasi yang tidak dapat diakses publik</p>
                        </div>
                    </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End of Features section-->

</x-layout>
