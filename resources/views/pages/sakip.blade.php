<x-layout>
    <x-header>
        <h1 class="display-5 fw-bolder pt-3 mb-2">SAKIP</h1>
        <p class="lead fw-normal mb-0">Sistem Akuntabilitas Kinerja Instansi Pemerintah</p>
    </x-header>
    <!-- Menu -->
    <section class="py-5" id="features">
        <div class="container px-5 my-5">
            <div class="row gx-5 row-cols-2 row-cols-md-3 g-4 justify-content-center">
                <div class=" col-md-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-sakip" role="tabpanel" aria-labelledby="v-pills-sakip-tab">
                        {{-- <h2 class="fw-bolder mb-3">Daftar Dokumen Sakip</h2> --}}
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <span><i class="ri-file-3-fill text-primary me-2"></i>Laporan Kinerja Instansi Pemerintah (LKjIP)</span>
                            <a href="https://ptun-bandung.go.id/laporan-kinerja-instansi-pemerintah-lkjip" target="_blank" class="btn btn-sm btn-primary">Lihat</a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <span><i class="ri-file-3-fill text-primary me-2"></i>Indikator Kinerja Utama (IKU)</span>
                            <a href="https://ptun-bandung.go.id/indikator-kinerja-utama-iku/" target="_blank" class="btn btn-sm btn-primary">Lihat</a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <span><i class="ri-file-3-fill text-primary me-2"></i>Rencana Strategis (RENSTRA)</span>
                            <a href="https://ptun-bandung.go.id/rencana-strategis-renstra/" target="_blank" class="btn btn-sm btn-primary">Lihat</a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <span><i class="ri-file-3-fill text-primary me-2"></i>Rencana Aksi Kinerja (RAK)</span>
                            <a href="https://ptun-bandung.go.id/rencana-aksi-kinerja-rak/" target="_blank" class="btn btn-sm btn-primary">Lihat</a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <span><i class="ri-file-3-fill text-primary me-2"></i>Rencana Kinerja Tahunan (RKT)</span>
                            <a href="https://ptun-bandung.go.id/rencana-kinerja-tahunan-rkt/" target="_blank" class="btn btn-sm btn-primary">Lihat</a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <span><i class="ri-file-3-fill text-primary me-2"></i>Perjanjian Kinerja Tahunan (PKT)</span>
                            <a href="https://ptun-bandung.go.id/perjanjian-kinerja-tahunan-pkt/" target="_blank" class="btn btn-sm btn-primary">Lihat</a>
                            </li>
                        </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>