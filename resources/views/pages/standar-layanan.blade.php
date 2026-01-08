<x-layout>
  <x-header>
    <h1 class="display-5 fw-bolder pt-3 mb-2">Standar Layanan</h1>
    <p class="lead fw-normal mb-0">Informasi standar pelayanan publik PPID PTUN Bandung</p>
  </x-header>

  <section class="my-4 mx-3 mx-md-5">
    <div class="container">
      <div class="row justify-content-center g-3">

        {{-- Sidebar nav --}}
        <div class="col-md-3">
          <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-3">
              <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link active"
                        id="v-pills-sop-tab"
                        data-bs-toggle="pill"
                        data-bs-target="#v-pills-sop"
                        type="button"
                        role="tab"
                        aria-controls="v-pills-sop"
                        aria-selected="true">
                  Standar Operasional Prosedur (SOP)
                </button>

                <button class="nav-link"
                        id="v-pills-hours-tab"
                        data-bs-toggle="pill"
                        data-bs-target="#v-pills-hours"
                        type="button"
                        role="tab"
                        aria-controls="v-pills-hours"
                        aria-selected="false">
                  Jam Layanan
                </button>

                <button class="nav-link"
                        id="v-pills-maklumat-tab"
                        data-bs-toggle="pill"
                        data-bs-target="#v-pills-maklumat"
                        type="button"
                        role="tab"
                        aria-controls="v-pills-maklumat"
                        aria-selected="false">
                  Maklumat Pelayanan
                </button>
              </div>
            </div>
          </div>
        </div>

        {{-- Content --}}
        <div class="col-md-9">
          <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-lg-5">
              <div class="tab-content" id="v-pills-tabContent">

                {{-- SOP --}}
                <div class="tab-pane fade show active"
                     id="v-pills-sop"
                     role="tabpanel"
                     aria-labelledby="v-pills-sop-tab">
                  <h2 class="fw-bolder mb-3">Daftar SOP</h2>

                  <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2">
                      <span class="fw-semibold text-muted">SOP Meja Informasi</span>
                      <a href="https://drive.google.com/file/d/1sj136UYUerQU1dTusHmd0bYurccnRhl5"
                         target="_blank"
                         class="btn btn-sm btn-primary ms-lg-auto">
                        Lihat
                      </a>
                    </li>

                    <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2">
                      <span class="fw-semibold text-muted">SOP Pelayanan PPID</span>
                      <a href="https://drive.google.com/file/d/1sHURss32Tt-dSNQ1cvf7fvpjpcvYQ3BW"
                         target="_blank"
                         class="btn btn-sm btn-primary ms-lg-auto">
                        Lihat
                      </a>
                    </li>

                    <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2">
                      <span class="fw-semibold text-muted">SOP Pengumuman Informasi Publik</span>
                      <a href="https://drive.google.com/file/d/1rlnaLL8HBqaoPKkD24eab6dwGWTg38tw"
                         target="_blank"
                         class="btn btn-sm btn-primary ms-lg-auto">
                        Lihat
                      </a>
                    </li>

                    <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2">
                      <span class="fw-semibold text-muted">SOP Penanganan Sengketa Informasi Publik oleh Atasan PPID</span>
                      <a href="https://drive.google.com/file/d/1D9echGzeVn93rVpojfoZJne57JfBXZ5e"
                         target="_blank"
                         class="btn btn-sm btn-primary ms-lg-auto">
                        Lihat
                      </a>
                    </li>

                    <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2">
                      <span class="fw-semibold text-muted">SOP Pengelolaan Permohonan Informasi</span>
                      <a href="https://drive.google.com/file/d/147YgVDGvtbiHvIPe4yFa6jXTHP8Mbb4r"
                         target="_blank"
                         class="btn btn-sm btn-primary ms-lg-auto">
                        Lihat
                      </a>
                    </li>

                    <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2">
                      <span class="fw-semibold text-muted">SOP Pengujian Tentang Konsekuensi</span>
                      <a href="https://drive.google.com/file/d/1pJp1GSymerwNQ-wwyNlNOTeFZbWLx9q-"
                         target="_blank"
                         class="btn btn-sm btn-primary ms-lg-auto">
                        Lihat
                      </a>
                    </li>

                    <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2">
                      <span class="fw-semibold text-muted">SOP Pendokumentasian Informasi yang Dikecualikan</span>
                      <a href="https://drive.google.com/file/d/18lFkowqwMT1GH7ti1Wev1g2XC25JP-BB"
                         target="_blank"
                         class="btn btn-sm btn-primary ms-lg-auto">
                        Lihat
                      </a>
                    </li>

                    <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2">
                      <span class="fw-semibold text-muted">SOP Penatapan dan Pemuktahiran DIP</span>
                      <a href="https://drive.google.com/file/d/1Ru_NGAoda1LOkRcvCap8MaBc5LSPuVd9"
                         target="_blank"
                         class="btn btn-sm btn-primary ms-lg-auto">
                        Lihat
                      </a>
                    </li>

                    <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2">
                      <span class="fw-semibold text-muted">SOP Pengelola Keberatan atas Informasi</span>
                      <a href="https://drive.google.com/file/d/17PEyxCopdVqMKa9NlUf_9bHifxFlKO7J"
                         target="_blank"
                         class="btn btn-sm btn-primary ms-lg-auto">
                        Lihat
                      </a>
                    </li>

                    <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2">
                      <span class="fw-semibold text-muted">SOP Pendokumentasian Informasi Publik</span>
                      <a href="https://drive.google.com/file/d/1CRF9-JKUQK-YM6sTEsjFXswmz8NgzJ5p"
                         target="_blank"
                         class="btn btn-sm btn-primary ms-lg-auto">
                        Lihat
                      </a>
                    </li>
                  </ul>
                </div>

                {{-- Jam Layanan --}}
                <div class="tab-pane fade"
                     id="v-pills-hours"
                     role="tabpanel"
                     aria-labelledby="v-pills-hours-tab">
                  <div class="text-center py-2">
                    <img src="{{ asset('img/jam-layanan.png') }}"
                         alt="Jam Layanan"
                         class="img-fluid rounded-3 border" />
                  </div>
                </div>

                {{-- Maklumat Pelayanan --}}
                <div class="tab-pane fade"
                     id="v-pills-maklumat"
                     role="tabpanel"
                     aria-labelledby="v-pills-maklumat-tab">
                  <div class="text-center py-2">
                    <img src="{{ asset('img/maklumat.png') }}"
                         alt="Maklumat Pelayanan"
                         class="img-fluid rounded-3 border" />
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</x-layout>
