<x-layout>
  <x-header>
    <h1 class="display-5 fw-bolder">Pejabat Pengelola Informasi dan Dokumentasi (PPID) PTUN Bandung</h1>
  </x-header>

  {{-- GOTO DAshboard --}}
  <section class="py-4">
    <div class="container px-5">
      <div class="row justify-content-center">
        <div class="col-lg-8">

          <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
              <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3">

                <div class="d-flex align-items-center gap-3 flex-grow-1">
                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-0 flex-shrink-0">
                    <i class="ri-dashboard-line"></i>
                </div>

                <div>
                    <h5 class="fw-bolder mb-1">Layanan PPID Online</h5>
                    <p class="mb-0 text-muted small">
                    Ajukan permohonan informasi melalui dashboard.
                    </p>
                </div>
                </div>


                <div class="ms-md-auto">
                  <a href="/dashboard" class="btn btn-primary px-4">
                    Ke Dashboard
                  </a>
                </div>

              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- Features section-->
  <section class="py-2" id="features">
    <div class="container px-5 my-5">
      <div class="row gx-5">
        <div class="col-lg-4 mb-5 mb-lg-0">
          <h2 class="fw-bolder mb-0">Prosedur Pelayanan</h2>
        </div>
        <div class="col-lg-8">
          <div class="row gx-5 row-cols-1 row-cols-md-2">

            <div class="col mb-5">
              <a href="prosedur-layanan" class="text-decoration-none text-reset d-block h-100 feature-box">
                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="ri-file-3-fill"></i></div>
                <h2 class="h5">Prosedur Pelayanan</h2>
                <p class="mb-0">Langkah-langkah dalam mengajukan permintaan informasi publik di PTUN Bandung</p>
              </a>
            </div>

            <div class="col mb-5">
              <a href="informasi-berkala" class="text-decoration-none text-reset d-block h-100 feature-box">
                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-collection"></i></div>
                <h2 class="h5">Informasi Berkala</h2>
                <p class="mb-0">Informasi yang secara rutin diterbitkan dan tersedia tanpa perlu permintaan khusus.</p>
              </a>
            </div>

            <div class="col mb-5">
              <a href="informasi-tersedia-setiap-saat" class="text-decoration-none text-reset d-block h-100 feature-box">
                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="ri-book-read-fill"></i></div>
                <h2 class="h5">Informasi Tersedia Setiap Saat</h2>
                <p class="mb-0">Informasi publik yang dapat diakses kapan saja tanpa syarat khusus.</p>
              </a>
            </div>

            <div class="col mb-5">
              <a href="informasi-dikecualikan" class="text-decoration-none text-reset d-block h-100 feature-box">
                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="ri-chat-delete-line"></i></div>
                <h2 class="h5">Informasi yang di Kecualikan</h2>
                <p class="mb-0">Jenis informasi yang tidak dapat diakses publik</p>
              </a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

</x-layout>
