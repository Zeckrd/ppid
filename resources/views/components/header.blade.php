<!-- Header-->
   <header class="bg-dark position-relative" style="min-height: 350px; overflow: hidden;">
        <!-- Background -->
        <div class="position-absolute top-0 start-0 w-100 h-100 z-0">
            <img class="img-fluid w-100 h-100 object-fit-cover" src="{{ asset('img/home-kantor.jpg') }}" alt="Kantor PTUN Bandung" style="object-fit: cover;" />
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(39, 76, 119, 0.8); mix-blend-mode: multiply;"></div>
        </div>
        <!-- End of Background -->

        <!-- Foreground text -->
        <div class="container position-relative z-1 py-5">
            <div class="row gx-5 align-items-center justify-content-center pt-5">
                <div class="col-12 text-center">
                    <div class="my-5 text-white">
                        {{ $slot }} <!-- Insert Text Header Here -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Foreground text -->
    </header>
    <!-- End of Header-->