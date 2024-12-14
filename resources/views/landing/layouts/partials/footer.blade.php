@php
    $setting = \App\Models\Setting::first();
@endphp
<footer id="footer" class="footer dark-background">

    <div class="container footer-top">
        <div class="row gy-4">
            <div class="col-lg-12 col-md-12 footer-about">
                <h4>Lokasi Kami</h4>

                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.093884487455!2d106.7284752!3d-6.251359199999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f13a37155223%3A0xf31e4c1ee0aaf964!2ssatuprinting.com%20(%20Digital%20Printing%20)!5e0!3m2!1sid!2sid!4v1734177611626!5m2!1sid!2sid"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

     

        </div>
    </div>

    <div class="container copyright text-center mt-4">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">{{ $setting->nama_website }}</strong> <span>All Rights Reserved</span></p>
        <div class="credits">
            Designed by <a href="https://andaka.cloud/">Jdeva Production</a>
        </div>
    </div>

</footer>
