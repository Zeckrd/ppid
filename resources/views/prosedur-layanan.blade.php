<x-layout>
    <x-header>
      <h1 class="display-5 fw-bolder pt-3 mb-2">Prosedur Pelayanan</h1>
      <p class="lead fw-normal mb-0">Langkah-langkah dalam mengajukan permintaan informasi publik di PTUN Bandung</p>
    </x-header>
  
    <section class="my-4 mx-5">
      <div class="container">
        <div class="row justify-content-center">
          <!-- Sidebar nav -->
          <div class="col-md-3 mb-3">
            <div class="nav flex-column nav-pills px-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <button class="nav-link active" id="v-pills-profil-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profil" type="button" role="tab" aria-controls="v-pills-profil" aria-selected="true">
                Prosedur Permohonan Informasi
              </button>
              <button class="nav-link" id="v-pills-struktur-tab" data-bs-toggle="pill" data-bs-target="#v-pills-struktur" type="button" role="tab" aria-controls="v-pills-struktur" aria-selected="false">
                Prosedur Pengajuan Keberatan
              </button>
              <button class="nav-link" id="v-pills-visi-misi-tab" data-bs-toggle="pill" data-bs-target="#v-pills-visi-misi" type="button" role="tab" aria-controls="v-pills-visi-misi" aria-selected="false">
                Sengketa Informasi
              </button>
            </div>
          </div>

    <!-- Tab content -->
    <div class="col-md-9">
      <div class="tab-content" id="v-pills-tabContent">

        <!-- Prosedur Permohonan Informasi -->
        <div class="tab-pane fade show active" id="v-pills-profil" role="tabpanel" aria-labelledby="v-pills-profil-tab">

          <!-- Inner tabs for Biasa / Khusus -->
          <ul class="nav nav-tabs mb-3" id="innerTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="biasa-tab" data-bs-toggle="tab" data-bs-target="#biasa" type="button" role="tab" aria-controls="biasa" aria-selected="true">Prosedur Biasa</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="khusus-tab" data-bs-toggle="tab" data-bs-target="#khusus" type="button" role="tab" aria-controls="khusus" aria-selected="false">Prosedur Khusus</button>
            </li>
          </ul>

          <!-- Inner tab content -->
          <div class="tab-content" id="innerTabContent">
            <div class="tab-pane fade show active" id="biasa" role="tabpanel" aria-labelledby="biasa-tab">
              <!-- Prosedur Biasa Content -->
              <div class="fw-normal text-muted">
               <p>Prosedur Biasa digunakan dalam hal:</p>
                <ul class="mb-3">
                  <li>Permohonan disampaikan secara tidak langsung, baik melalui surat atau media elektronik;</li>
                  <li>Informasi yang diminta bervolume besar.</li>
                  <li>Informasi yang diminta belum tersedia, atau</li>
                  <li>Informasi yang diminta adalah informasi yang tidak secara tegas termasuk dalam katergori informasi yang harus diumumkan atau informasi yang secara tegas dinyatakan sebagai informasi yang rahasia sehingga harus mendapat ijin dan diputuskan oleh PPID.</li>
                </ul>

                <p>Pelayanan informasi dengan menggunakan prosedur biasa dilakukan sesuai dengan skema alur dalam gambar berikut :</p>
                  <div class="text-center py-3">
                    <img src="{{ asset('img/prosedur-biasa.png') }}" alt="Prosedur biasa permintaan informasi" class="img-fluid" />
                  </div>

                <ol>
                  <li>Pemohon mengisi formulir permohonan informasi yang disediakan pengadilan dan memberikan salinannya kepada pemohon <a href="https://drive.google.com/file/d/1w2YJRxdMBdEyeeiB06He_R9oSqakNyxj">(Formulir dapat didownload disini)</a></li>
                  <li>Petugas informasi mengisi Register Permohonan.</li>
                  <li>Petugas informasi langsung meneruskan formulir permohonan kepada penanggung jawab informasi di unit/satuan kerja terkait, apabila informasi yang diminta tidak termasuk informasi yang aksesnya membutuhkan ijin dari PPID.</li>
                  <li>Petugas informasi langsung menerukan formulir permohonan kepada PPID apabila informasi yang diminta termasuk informasi yang aksesnya membutuhkan ijin dari PPID guna dilakukan uji konsekuensi.</li>
                  <li>PPID melakukan uji konsekuensi berdasarkan pasal 17 Undang-Uundang keterbukaan informasi Publik terhadap permohonan yang disampaikan.</li>
                  <li>Dalam jangka waktu 5 (lima) hari kerja sejak menerima permohonan, PPID menyampaikan pembertahuan tertulis kepada petugas informasi, dalam hal permohonan ditolak.</li>
                  <li>Dalam jangka waktu 5 (lima) hari kerja sejak menerima permohonan, PPID meminta penanggung jawab informasi di unit/satuan kerja terkait untuk mencari dan memperkirakan biaya penggandaan dan waktu yang diperlukan untuk menggandakan informasi yang diminta dan menuliskannya dalam Pemberitahuan tertulis PPID Model B dalam waktu selama-lamanya 3 (tiga) hari kerja serta menyerahkannya kembali kepada PPID untuk ditandatangani, dalam hal permohonan diterima.</li>
                  <li>Petugas informasi menyampaikan pemberitahuan tertulis sebagaimana dimaksud butir 6 atau butir 7 kepada pemohon informasi selambat-lambatnya dalam waktu 1 (satu) hari kerja sejak pemberitahuan diterima.</li>
                  <li>Petugas infomasi memberikan kesempatan bagi pemohon apabila ingin melihat terlebih dahulu informasi yang diminta, sebelum memutuskan untuk menggandakan atau tudak informasi tersebut.</li>
                  <li>Dalam hal pemohon memutuskan untuk memperoleh fotokopi informasi tersebut, pemohon membayar biaya perolehan informasi kepada petugas infomrasi dan petugas informasi memberikan tanda terima.</li>
                  <li>Dalam hal informasi yang diminta tersedia dalam dokumen elektronik (softcopy), petugas informasi pada hari yang sama mengirimkan informasi tersebut ke email pemohon atau menyimpan informasi</li>
                  <li>Pengadilan dapat memperpanjang waktu sebagaimana dimaksud butir 12 selama 1 (satu) hari kerja jika informasi yang diminta bervolume besar.</li>
                  <li>Petugas informasi menggandakan (fotokopi) informasi yang diminta dan memberikan informasi tersebut kepada pemohon sesuai dengan waktu yang termuat dalam pemberitahuan tertulis atau selambat-lambatnya dalam jangka waktu 2 (dua) hari kerja sejak pemohon membayar biaya perolehan informasi.</li>
                  <li>Pengadilan dapat memperpanjang waktu sebagaimana dimaksud butir 12 selama 1 (satu) hari kerja jika informasi yang diminta bervolume besar.</li>
                  <li>Untuk pengadilan di wilayah tertentu yang memiliki keterbatasan untuk mengakses sarana fotokopi, jangka waktu sebagaiman dimaksud dalam butir 12, dapat diperpanjang selama paling lama 3 (tiga) hari kerja.</li>
                  <li>Setelah memberikan fotokopi informasi, petugas informasi meminta pemohon menandatangani kolom penerimaan informasi dalam register permohonan.</li>
                </ol>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="khusus" role="tabpanel" aria-labelledby="khusus-tab">
            <!-- Prosedur Khusus Content -->
            <div class="fw-normal text-muted">
              <p>Prosedur Khusus digunakan dalam hal:</p>
              <ul>
                <li>Termasuk dalam kategori yang wajib diumumkan;</li>
                <li>Termasuk dalam kategori informasi yang dapat diakses publik dan sudah tercatat dalam Daftar informasi Publik dan sudah tersedia (sudah diketik atau sudah diterima dari pihak atau pengadilan lain);</li>
                <li>Tidak bervolume besar (jumlahnya tidak banyak); dan/atau</li>
                <li>Perkiraan jumlah biaya penggandaan dan waktu yang dibutuhkan untuk penggandaan dapat dilakukan dengan mudah.</li>
              </ul>

              <p>Prosedur pelayanan informasi dengan menggunakan prosedur khusus, mengikuti skema alur dalam gambar berikut :</p>
                <div class="text-center py-3">
                  <img src="{{ asset('img/prosedur-khusus.png') }}" alt="Prosedur khusus permintaan informasi" class="img-fluid" />
                </div>
              <ol>
                <li>Pemohon mengisi formulir permohonan yang disediakan Pengadilan <a href="https://drive.google.com/file/d/1w2YJRxdMBdEyeeiB06He_R9oSqakNyxj">(Formulir dapat didownload disini)</a></li>
                <li>Petugas Informasi mengisi Register Permohonan.</li>
                <li>Petugas Informasi dibantu Penanggungjawab informasi di unir/satuan kerja terkait mencari informasi yang diminta oleh Pemohon dan memperkirakan biaya perolehan informasi dan waktu yang dibutuhkan untuk penggandaannya.</li>
                <li>Petugas informasi Apabila informasi yang diminta telah tersedi dan tidak memerlikan ijin PPID, Petugas Informasi menuliskan keterangan mengenai perkiraan biaya perolehan informasi dan waktu yang dibutuhkan untuk penggandaannya dalam formulir permohonan yang telah diisi pemohon.</li>
                <li>Proses untuk pembayaran, penyalinan dan penyerahan salinan informasi kepada pemohon dalam prosedur Khusus, sama dengan yang diatur untuk prosedur Biasa dalam butir 10 sampai dengan butir 15.</li>
                <li>Petugas Informasi memberikan kesempatan bagi Pemohon apabila ingin melihat terlebih dahulu informasi yang diminta, sebelum memutuskan untuk menggandakan atau tidak informasi tersebut.</li>
              </ol>
            </div>
          </div>
        </div>


        <!-- Prosedur Pengajuan Keberatan -->
        <div class="tab-pane fade" id="v-pills-struktur" role="tabpanel" aria-labelledby="v-pills-struktur-tab">
          <h2 class="fw-bolder mb-3">Prosedur Pengajuan Keberatan</h2>
          <div class="fw-normal text-muted">
            <h5>Syarat dan Prosedur Pengajuan:</h5>
            <ol>
              <li>
                Pemohon berhak mengajukan keberatan dalam hal ditemukannya alasan sebagai berikut:
                <ul>
                  <li>Adanya penolakan atas permohonan informasi;</li>
                  <li>Tidak disediakannya informasi yang wajib diumumkan secara berkala;</li>
                  <li>Tidak ditanggapinya permohonan informasi;</li>
                  <li>Permohonan ditanggapi tidak sebagaimana yang diminta;</li>
                  <li>Tidak dipenuhinya permohonan informasi;</li>
                  <li>Pengenaan biaya yang tidak wajar; dan/atau</li>
                  <li>Penyampaian informasi melebihi waktu yang diatur dalam pedoman ini.</li>
                </ul>
              </li>
              <li>
                Keberatan ditujukan kepada Atasan Pejabat Pengelola Informasi dan Dokumentasi (PPID) melalui Petugas Informasi oleh Pemohon atau kuasanya.
              </li>
            </ol>
          </div>
        </div>

        <!-- Sengketa Informasi -->
        <div class="tab-pane fade" id="v-pills-visi-misi" role="tabpanel" aria-labelledby="v-pills-visi-misi-tab">
          <div class="text-center py-3">
            <img src="{{ asset('img/prosedur-sengketa.png') }}" alt="Prosedur sengketa" class="img-fluid" />
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>
</section>

</x-layout>
  