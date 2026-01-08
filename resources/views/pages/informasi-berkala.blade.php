<x-layout>
  <x-header>
    <h1 class="display-5 fw-bolder pt-3 mb-2">Informasi Berkala</h1>
    <p class="lead fw-normal mb-0">
      Informasi yang secara rutin diterbitkan dan tersedia tanpa perlu permintaan khusus.
    </p>
  </x-header>

  <section class="py-5" id="list">
    <div class="container px-4 px-md-5">
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-9">

          {{-- Content --}}
          <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-lg-5">

              {{-- A --}}
              <div class="mb-4">
                <h4 class="fw-bolder mb-3">A. Informasi Tentang Profil Pengadilan</h4>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Sejarah Pengadilan</span>
                    <a href="https://ptun-bandung.go.id/sejarah-pengadilan/" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Struktur Organisasi</span>
                    <a href="https://ptun-bandung.go.id/struktur-organisasi/" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Statistik Pegawai</span>
                    <a href="https://ptun-bandung.go.id/statistik-pegawai/" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Wilayah Yuridiksi</span>
                    <a href="https://ptun-bandung.go.id/wilayah-yurisdiksi/" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Visi dan Misi</span>
                    <a href="https://ptun-bandung.go.id/visi-dan-misi-pengadilan/" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Survey Pelayanan Publik</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                </ul>
              </div>

              {{-- B --}}
              <div class="mb-4">
                <h4 class="fw-bolder mb-3">B. Pelayanan Dasar Pengadilan</h4>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Standar Pelayanan Pengadilan</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Prosedur Penerimaan Gugatan</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Alur Perkara Gugatan</span>
                    <a href="https://ptun-bandung.go.id/alur-perkara-gugatan/" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Prosedur Pengembalian Sisa Panjar Biaya Perkara</span>
                    <a href="https://ptun-bandung.go.id/prosedur-pengembalian-sisa-panjar-perkara/" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Prosedur Layanan Permohonan Eksekusi</span>
                    <a href="https://ptun-bandung.go.id/permohonan-eksekusi/" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Jadwal Persidangan</span>
                    <a href="https://sipp.ptun-bandung.go.id/list_jadwal_sidang" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                </ul>
              </div>

              {{-- C --}}
              <div class="mb-4">
                <h4 class="fw-bolder mb-3">C. Informasi Terkait Hak Masyarakat</h4>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Prosedur Pemberian Layanan Hukum</span>
                    <a href="https://ptun-bandung.go.id/prosedur-pemberian-layanan-hukum/" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Posbakum</span>
                    <a href="https://ptun-bandung.go.id/posbakum/" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Hak dan Kewajiban Penerima Bantuan Hukum</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Pengaduan</span>
                    <a href="https://siwas.mahkamahagung.go.id/" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                </ul>
              </div>

              {{-- D --}}
              <div class="mb-4">
                <h4 class="fw-bolder mb-3">D. Sistem Informasi Perkara</h4>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Penelusuran Perkara</span>
                    <a href="https://sipp.ptun-bandung.go.id/" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Direktori Putusan</span>
                    <a href="https://putusan3.mahkamahagung.go.id/pengadilan/profil/pengadilan/ptun-bandung" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Statistik Perkara</span>
                    <a href="https://sipp.ptun-bandung.go.id/statistik_perkara" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                </ul>
              </div>

              {{-- E --}}
              <div class="mb-4">
                <h4 class="fw-bolder mb-3">E. Pengumuman</h4>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Pengumuman PJB</span>
                    <a href="https://lpse.mahkamahagung.go.id/eproc4/nontender#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                </ul>
              </div>

              {{-- F --}}
              <div class="mb-4">
                <h4 class="fw-bolder mb-3">F. Laporan Kinerja Pengadilan</h4>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">LAKIP</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Laporan Tahunan</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Laporan PPID</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                </ul>
              </div>

              {{-- G --}}
              <div class="mb-0">
                <h4 class="fw-bolder mb-3">G. Laporan Bulanan</h4>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Laporan PTIP</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Laporan Perkara</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Laporan Keuangan Perkara</span>
                    <a href="#" class="btn btn-sm btn-primary ms-lg-auto">Lihat</a>
                  </li>
                  <li class="list-group-item d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 py-3">
                    <span class="fw-semibold text-muted">Laporan Anggaran dan DIPA</span>
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
