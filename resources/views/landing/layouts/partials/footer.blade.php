@php
    $setting = \App\Models\Setting::first();
@endphp
<footer id="footer" class="footer dark-background">

    <div class="container footer-top">
        <div class="row gy-4">
            <div class="col-lg-3 col-md-6 footer-about">
                <a href="/" class="logo d-flex align-items-center">
                    <img src="{{ asset('assets-landing/img/home/LOGO.png') }}" alt="">
                  </a>
                <div class="footer-contact pt-3">
                    <p> <b>Hubungi kami</b>
                        <br>
                        <br>
                        Ruko Pesona Jl. Panti Asuhan No. G3A <br>  Pondok Aren, Tangerang Selatan 15223
                    </p>

                    <div class="social-links mt-4">
                        <a target="_blank" href="https://wa.me/6282210008380"><i class="bi bi-whatsapp"></i>  0822 1000 8380</a> <br>
                        <a target="_blank" href="https://www.instagram.com/satuprinting.id?igsh=dmxlczlyamlyMWg1"><i class="bi bi-instagram"></i>  @satuprinting.id</a> <br>
                        <a target="_blank" href="https://www.tiktok.com/@satu.printing?_t=8sEIq5opyTg&_r=1"><i class="bi bi-tiktok"></i> satu.printing</a> <br>
                        <a target="_blank" href="#"><i class="bi bi-facebook"></i> Satu Printing Indonesia</a> <br>
                        <a target="_blank" href="#"><i class="bi bi-youtube"></i> Satu Printing Indonesia</a> <br>
                      </div>
                </div>
            </div>

            <div class="col-lg-5 col-md-12 footer-about">
                <h4>LOKASI</h4>

                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.093884487455!2d106.7284752!3d-6.251359199999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f13a37155223%3A0xf31e4c1ee0aaf964!2ssatuprinting.com%20(%20Digital%20Printing%20)!5e0!3m2!1sid!2sid!4v1734177611626!5m2!1sid!2sid"
                    width="100%" height="280" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="col-lg-4 col-md-12 footer-about">
                <h4>PEMBAYARAN</h4>
                <div class="row">
                    <div class="col-lg-6 col-6">
                        <img src="https://i.pinimg.com/564x/00/cb/4f/00cb4f7ad2d81f39afffe610fc1d07fd.jpg" alt="BCA" style="max-width: 180px;margin-top:10px;margin-right:10px">
                        <img src="https://www.bankmandiri.co.id/documents/20143/44881086/ag-branding-logo-1.png/842d8cf8-b7fb-3014-9620-21f0f88d8377?t=1623309819034" alt="BCA" style="max-width: 180px;margin-top:10px;margin-right:10px">
                        <img src="https://asset-2.tstatic.net/pontianak/foto/bank/images/logo-bank-danamon.jpg" alt="BCA" style="max-width: 180px;margin-top:10px;margin-right:10px">
                    </div>
                    <div class="col-lg-6 col-6">
                        <img src="https://www.pngkey.com/png/detail/223-2237565_bank-permata-logo.png" alt="BCA" style="max-width: 180px;margin-top:10px;margin-right:10px">
                        <img src="https://www.pikpng.com/pngl/m/489-4896877_bni-logo-png.png" alt="BCA" style="max-width: 180px;margin-top:10px;margin-right:10px">

                        {{-- <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ_J4mZpplmtUUyKMJ0Lw-PXDs4_vRFIStUYmPnYKh2Wpg_HhV7WydLn9yKubARL8JvdsI&usqp=CAU" alt="BCA" style="max-width: 180px;margin-top:10px;margin-right:10px"> --}}
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSW8bQmSJ3Z5QrUJNjAQh498SVoH55DInkx-A&s" alt="BCA" style="max-width: 180px;margin-top:10px;margin-right:10px">
                    </div>
                </div>
            </div>
            



        </div>
    </div>

    <div class="container copyright text-center mt-4">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">{{ $setting->nama_website }}</strong> <span>All Rights
                Reserved</span></p>
        <div class="credits">
            Designed by <a href="https://andaka.cloud/">Jdeva Production</a>
        </div>
    </div>

</footer>
