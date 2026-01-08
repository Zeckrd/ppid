<x-layout>
  <x-header>
    <h1 class="display-5 fw-bolder pt-3 mb-2">Informasi Tersedia Setiap Saat</h1>
    <p class="lead fw-normal mb-0">Informasi publik yang dapat diakses kapan saja tanpa syarat khusus.</p>
  </x-header>

  <section class="py-5" id="list">
    <div class="container px-4 px-md-5">
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-9">

          {{-- Content  --}}
          <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-lg-5">

              <h2 class="fw-bolder mb-4">Daftar Informasi Publik (DIP)</h2>

              {{-- Informasi tentang Perkara dan Persidangan --}}
              <div class="mb-4">
                <h5 class="fw-bolder mb-3">Informasi tentang Perkara dan Persidangan</h5>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Putusan dan Penetapan Pengadilan</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Buku Register Perkara</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Tahapan Penanganan Perkara</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Laporan Keuangan Perkara</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                </ul>
              </div>

              {{-- Informasi tentang Pengawasan dan Pendisiplinan --}}
              <div class="mb-4">
                <h5 class="fw-bolder mb-3">Informasi tentang Pengawasan dan Pendisiplinan</h5>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Statistik pelanggaran Hakim/Pegawai</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Statistik penjatuhan hukuman disiplin</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Inisial nama Hakim/Pegawai yang dijatuhi hukuman</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Putusan Majelis Kehormatan Hakim</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                </ul>
              </div>

              {{-- Informasi tentang Peraturan, Kebijakan, dan Hasil Penelitian --}}
              <div class="mb-4">
                <h5 class="fw-bolder mb-3">Informasi tentang Peraturan, Kebijakan, dan Hasil Penelitian</h5>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Peraturan MA, Surat Edaran MA, Kebijakan Ketua dan Wakil Ketua</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Pertimbangan atau nasehat hukum yang diberikan MA</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Hasil penelitian yang dilakukan</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                </ul>
              </div>

              {{-- Informasi Organisasi, Administrasi, Kepegawaian dan Keuangan --}}
              <div class="mb-0">
                <h5 class="fw-bolder mb-3">Informasi Organisasi, Administrasi, Kepegawaian dan Keuangan</h5>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Pedoman pengelolaan Organisasi, administrasi, personel, dan keuangan Pengadilan</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Standar dan Maklumat Pelayanan Pengadilan</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Profil Hakim dan Pegawai</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Data statistik Kepegawaian</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                </ul>
              </div>

            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
</x-layout>
