<!DOCTYPE html>
<html lang="en">

<head>
    {{-- HEAD  --}}
    @include('pwa.layouts.partials.head')
    <style>
        :root {
            --wa-chat-dark-green: #2B6056;
            --wa-chat-green: #128C7E;
            --wa-chat-light-green: #25D366;
            --wa-chat-light: #DCF8C7;
            --wa-chat-white: #F9F9F9;
            --wa-chat-red: #DC1C2A;
            --wa-chat-font-family: sans-serif;
            --wa-chat-width: 24rem;
            --wa-chat-box-shadow: 0 0.5rem 1.5rem -0.25rem rgba(0, 0, 0, 0.15);
            --wa-chat-border-radius: .5rem;
            --wa-chat-z-index: 1055;
            --wa-chat-backdrop-color: rgba(0, 0, 0, .75);
            --wa-chat-distance-y: 1rem;
            --wa-chat-distance-x: 1rem;
            --wa-chat-right: var(--wa-chat-distance-x);
            --wa-chat-button-size: 3.5rem;
            --wa-chat-button-border-radius: 50%;
            --wa-chat-button-color: var(--wa-chat-light-green);
            --wa-chat-button-icon-size: 1.5rem;
            --wa-chat-window-margin-bottom: calc(var(--wa-chat-button-size) + var(--wa-chat-distance-y) + 1rem);
            --wa-chat-header-padding: 0.625rem 1.25rem;
            --wa-chat-contact-img-size: 2.5rem;
            --wa-chat-close-size: 1.75rem;
            --wa-chat-body-color: #000;
            --wa-chat-body-padding: 1rem 1rem 1.5rem 1rem;
            --wa-chat-placeholder-color: #757575;
            --wa-chat-placeholder-color-hover: #414141;
            --wa-chat-form-btn-border-radius: .25rem;
            --wa-chat-error-text-right: auto;
            --wa-chat-error-text-left: 0;
            --wa-chat-error-text-bottom: 100%;
            --wa-chat-error-text-margin: 0 0 0.25rem 0;
            --wa-chat-error-text-transform-origin: left;
            /* To make the component stay on the left, set the variables commented below */
            --wa-chat-left: auto;
            /* var(--wa-chat-distance-x) */
            --wa-chat-error-text-alt-right: 100%;
            /* var(--wa-chat-error-text-right) */
            --wa-chat-error-text-alt-left: auto;
            /* var(--wa-chat-error-text-left) */
            --wa-chat-error-text-alt-bottom: auto;
            /* var(--wa-chat-error-text-bottom) */
            --wa-chat-error-text-alt-margin: 0 0.5rem 0 0;
            /* var(--wa-chat-error-text-margin) */
            --wa-chat-error-text-alt-transform-origin: right;
            /* var(--wa-chat-error-text-transform-origin) */
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        .whatsapp-chat {
            z-index: var(--wa-chat-z-index);
            position: fixed;
            right: 0;
            bottom: 0;
            line-height: 1.25;
            font-family: var(--wa-chat-font-family);
        }

        .whatsapp-chat-toggler {
            display: none;
        }

        .whatsapp-chat-toggler:not(:checked)~.whatsapp-chat-window {
            transform: scale(0.75) translateY(calc(100% + var(--wa-chat-window-margin-bottom) / .75));
            pointer-events: none;
        }

        .whatsapp-chat-toggler:not(:checked)~.whatsapp-chat-backdrop {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .whatsapp-chat-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            background: var(--wa-chat-backdrop-color);
            transition: 0.25s;
        }

        .whatsapp-chat-button {
            z-index: 1;
            position: fixed;
            left: var(--wa-chat-left);
            right: var(--wa-chat-right);
            bottom: var(--wa-chat-distance-y);
            width: var(--wa-chat-button-size);
            height: var(--wa-chat-button-size);
            border-radius: var(--wa-chat-button-border-radius);
            background: var(--wa-chat-button-color);
            color: var(--wa-chat-white);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .whatsapp-chat-window {
            position: fixed;
            left: var(--wa-chat-left);
            right: var(--wa-chat-right);
            bottom: var(--wa-chat-window-margin-bottom);
            box-shadow: var(--wa-chat-box-shadow);
            transform-origin: bottom;
            border-radius: var(--wa-chat-border-radius);
            width: var(--wa-chat-width);
            max-width: calc(100% - var(--wa-chat-distance-x) * 2);
            transition: 0.4s;
        }

        .whatsapp-chat-header {
            background: var(--wa-chat-dark-green);
            color: var(--wa-chat-white);
            display: flex;
            align-items: center;
            padding: var(--wa-chat-header-padding);
            border-radius: var(--wa-chat-border-radius) var(--wa-chat-border-radius) 0 0;
        }

        .whatsapp-chat-header>* {
            display: flex;
        }

        .whatsapp-chat-contact-img {
            width: var(--wa-chat-contact-img-size);
            height: var(--wa-chat-contact-img-size);
            border-radius: var(--wa-chat-contact-img-size);
            object-fit: cover;
        }

        .whatsapp-chat-contact-info {
            -webkit-flex: 1 0 0;
            flex: 1 0 0;
            flex-direction: column;
            padding: 0 1rem;
        }

        .whatsapp-chat-close {
            padding: 0.25rem;
            margin-right: -0.25rem;
            cursor: pointer;
            transition: 0.2s;
        }

        .whatsapp-chat-close svg {
            width: var(--wa-chat-close-size);
            height: var(--wa-chat-close-size);
        }

        .whatsapp-chat-close:hover {
            transform: scale(1.1);
            color: var(--wa-chat-light);
        }

        .whatsapp-chat-body {
            padding: var(--wa-chat-body-padding);
            font-size: 0.875rem;
            background: url(https://i.imgur.com/qzkmhio.png) no-repeat;
            background-size: cover;
            text-align: center;
            border-radius: 0 0 var(--wa-chat-border-radius) var(--wa-chat-border-radius);
        }

        .whatsapp-chat-bubble {
            position: relative;
            z-index: 0;
            margin: 0 auto 0.5rem 0;
            padding: 0.125rem 0 0.25rem;
            border-width: 0.3rem 0.75rem 0.3rem 1.5rem;
            border-style: solid;
            -o-border-image: url(https://i.imgur.com/UD8BZ7J.png) 8 20 8 30 stretch;
            border-image: url(https://i.imgur.com/UD8BZ7J.png) 8 20 8 30 stretch;
            color: var(--wa-chat-body-color);
            text-align: left;
        }

        @media (min-width: 425px) {
            .whatsapp-chat-bubble {
                width: 85%;
            }
        }

        .whatsapp-chat-bubble:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #f9f9f9;
            z-index: -1;
        }

        .whatsapp-chat-green-bubble {
            position: relative;
            display: block;
            border-width: 0.3rem 1rem 0.3rem 0.3rem;
            border-style: solid;
            width: 90%;
            -o-border-image: url(https://i.imgur.com/jXoq4es.png) 0 17 3 10 stretch;
            border-image: url(https://i.imgur.com/jXoq4es.png) 0 17 3 10 stretch;
            text-align: left;
            cursor: text;
            margin: 0 0 0 auto;
            color: var(--wa-chat-body-color);
        }

        .whatsapp-chat-green-bubble:hover .whatsapp-chat-input::placeholder {
            color: var(--wa-chat-placeholder-color-hover);
        }

        @media (min-width: 40rem) {
            .whatsapp-chat-green-bubble {
                width: 85% !important;
            }
        }

        .whatsapp-chat-input {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-clip: padding-box;
            display: block;
            font-weight: 400;
            line-height: 1.5;
            padding: 0.5rem 1rem;
            width: 100%;
            border: 0;
            background: var(--wa-chat-light);
            box-shadow: none;
            outline: none;
            border-radius: 0;
            font-size: inherit;
            color: inherit;
        }

        .whatsapp-chat-input::placeholder {
            color: var(--wa-chat-placeholder-color);
            transition: 0.2s;
        }

        .whatsapp-chat-input:invalid:hover~.error .error-icon {
            transform: scale(1);
        }

        .whatsapp-chat-input:invalid:hover:focus~.error .error-text {
            color: var(--wa-chat-white);
            transform: scaleX(1);
            transition: transform 0.2s, color 0.2s 0.1s;
        }

        .whatsapp-chat-checkbox .whatsapp-chat-green-bubble {
            width: calc(90% - 1.75rem);
            cursor: pointer;
        }

        .whatsapp-chat-checkbox .whatsapp-chat-green-bubble:before {
            content: "";
            position: absolute;
            top: 50%;
            right: 100%;
            width: 1.125rem;
            height: 1.125rem;
            margin-right: 1rem;
            border: 2px solid rgba(0, 0, 0, 0.5);
            border-radius: 0.25rem;
            transform: translateY(-50%);
            transition: 0.2s;
        }

        .whatsapp-chat-checkbox .whatsapp-chat-green-bubble:after {
            content: "";
            position: absolute;
            top: 50%;
            right: 100%;
            width: 0.6rem;
            height: 0.35rem;
            margin-right: 1.125rem;
            margin-top: -0.125rem;
            border-left: 2px solid var(--wa-chat-white);
            border-bottom: 2px solid var(--wa-chat-white);
            transform: rotate(-90deg) translateY(-50%) scale(0);
            transition: 0.2s;
        }

        .whatsapp-chat-checkbox .whatsapp-chat-green-bubble:hover:before {
            border-color: rgba(0, 0, 0, 0.75);
        }

        .whatsapp-chat-checkbox .whatsapp-chat-green-bubble:hover .whatsapp-chat-input {
            color: var(--wa-chat-placeholder-color-hover);
        }

        .whatsapp-chat-checkbox .whatsapp-chat-input {
            pointer-events: none;
            color: var(--wa-chat-placeholder-color);
            line-height: 1.2;
            transition: 0.2s;
        }

        .whatsapp-chat-checkbox .error {
            margin-right: 1.75rem;
        }

        .whatsapp-chat-checkbox input[type=checkbox],
        .whatsapp-chat-checkbox input[type=radio] {
            display: none;
        }

        .whatsapp-chat-checkbox input[type=radio]~.whatsapp-chat-green-bubble:before {
            border-radius: 50%;
        }

        .whatsapp-chat-checkbox input:checked~.whatsapp-chat-green-bubble:before {
            border-color: var(--wa-chat-green);
            background-color: var(--wa-chat-green);
        }

        .whatsapp-chat-checkbox input:checked~.whatsapp-chat-green-bubble:after {
            transform: rotate(-45deg) translateY(-50%) scale(1);
            transition: 0.2s 0.15s;
        }

        .whatsapp-chat-checkbox input:checked~.whatsapp-chat-green-bubble .whatsapp-chat-input {
            color: var(--wa-chat-dark-green);
        }

        .whatsapp-chat-checkbox input[required]:not(:checked)~.whatsapp-chat-green-bubble:hover .error-icon {
            transform: scale(1);
        }

        .whatsapp-chat-checkbox input[required]:not(:checked)~.whatsapp-chat-green-bubble:hover .error-text {
            color: var(--wa-chat-white);
            transform: scaleX(1);
            transition: transform 0.2s, color 0.2s 0.1s;
        }

        .whatsapp-chat .error {
            position: absolute;
            top: 50%;
            right: 100%;
            transform: translateY(-50%);
            padding-right: 1rem;
            white-space: nowrap;
            pointer-events: none;
        }

        .whatsapp-chat .error-icon {
            display: inline-block;
            width: 1.25rem;
            height: 1.25rem;
            color: var(--wa-chat-red);
            vertical-align: middle;
            transform: scale(0);
            transition: 0.25s;
        }

        .whatsapp-chat .error-text {
            position: absolute;
            right: var(--wa-chat-error-text-right);
            left: var(--wa-chat-error-text-left);
            bottom: var(--wa-chat-error-text-bottom);
            display: inline-block;
            font-size: 0.625rem;
            margin: var(--wa-chat-error-text-margin);
            color: var(--wa-chat-red);
            background: var(--wa-chat-red);
            border-radius: 0.25rem;
            padding: 0.25rem 0.5rem;
            vertical-align: middle;
            transform: scaleX(0);
            transform-origin: var(--wa-chat-error-text-transform-origin);
            transition: transform 0.2s 0.1s, color 0.2s;
        }

        @media (min-width: 640px) {
            .whatsapp-chat .error-text {
                right: var(--wa-chat-error-text-alt-right, var(--wa-chat-error-text-right));
                left: var(--wa-chat-error-text-alt-left, var(--wa-chat-error-text-left));
                bottom: var(--wa-chat-error-text-alt-bottom, var(--wa-chat-error-text-bottom));
                margin: var(--wa-chat-error-text-alt-margin, var(--wa-chat-error-text-margin));
                transform-origin: var(--wa-chat-error-text-alt-transform-origin, var(--wa-chat-error-text-transform-origin));
            }
        }

        .whatsapp-chat-btn {
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            line-height: 1.5;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 0;
            padding: 0.5rem 1.5rem;
            margin-top: 1rem;
            border-radius: var(--wa-chat-form-btn-border-radius);
            background: var(--wa-chat-green);
            color: var(--wa-chat-white);
            transition: 0.2s;
        }

        .whatsapp-chat-btn:hover {
            background: var(--wa-chat-dark-green);
            color: var(--wa-chat-white);
        }

        .whatsapp-chat .text-wa-green {
            color: var(--wa-chat-green);
        }

        .whatsapp-chat .text-wa-light-green {
            color: var(--wa-chat-light-green);
        }
    </style>
</head>

<body>
    <div class="site-content">
        <!-- Preloader start -->
        <div class="loader-mask">
            <div class="loader">
            </div>
        </div>
        <!-- Preloader end -->
        <!-- Header start -->
        @include('pwa.layouts.partials.header')
        <!-- Header end -->
        <!-- Homescreen content start -->
        @yield('content-pwa')
        <!-- Homescreen content end -->
        <!-- Tabbar start -->
        {{-- bottom nav  --}}
        @include('pwa.layouts.partials.bottom-navigation')

        <!-- Tabbar end -->
        <!--SideBar setting menu start-->
        {{-- SIDEBAR  --}}
        @include('pwa.layouts.partials.sidebar')

        <div class="dark-overlay"></div>
        <!--SideBar setting menu end-->
        <!-- pwa install app popup Start -->
        {{-- <div class="offcanvas offcanvas-bottom addtohome-popup theme-offcanvas" tabindex="-1" id="offcanvas" aria-modal="true" role="dialog">
			<button type="button" class="btn-close text-reset popup-close-home" data-bs-dismiss="offcanvas" aria-label="Close"></button>
			<div class="offcanvas-body small">
    
				<img src="{{ asset('assets/logo-polimer.png') }}" alt="logo" class="logo-popup" style="max-width: 80%!important;">
				<p class="title font-w600">Printing Factory</p>
				<p class="install-txt">Install Printing Factory - Online Learning & Educational Courses PWA to your home screen for easy access, just like any other app</p>
				<a href="javascript:void(0)" class="theme-btn install-app btn-inline addhome-btn" id="installApp">Add to Home Screen</a>
			</div>
		</div> --}}
        <!-- pwa install app popup End -->
    </div>



    {{-- <script>
        let deferredPrompt;

        // Cek jika sudah ada status instalasi di localStorage
        if (!localStorage.getItem('pwaInstalled')) {
            // Jika belum diinstal, tampilkan popup
            document.getElementById('offcanvas').classList.add('show');
        }

        window.addEventListener('beforeinstallprompt', (e) => {
            // Mencegah prompt default
            e.preventDefault();
            deferredPrompt = e;

            // Event listener untuk tombol "Add to Home Screen"
            document.getElementById('installApp').addEventListener('click', () => {
                if (deferredPrompt) {
                    deferredPrompt.prompt(); // Tampilkan prompt instalasi
                    deferredPrompt.userChoice.then((choiceResult) => {
                        if (choiceResult.outcome === 'accepted') {
                            console.log('User accepted the A2HS prompt');
                            localStorage.setItem('pwaInstalled', true); // Simpan status instalasi
                        } else {
                            console.log('User dismissed the A2HS prompt');
                        }
                        deferredPrompt = null;
                    });
                }
            });
        });

        // Cek apakah PWA sudah diinstal
        window.addEventListener('appinstalled', () => {
            console.log('PWA has been installed');
            localStorage.setItem('pwaInstalled', true); // Simpan status di localStorage
            document.getElementById('offcanvas').classList.remove('show'); // Sembunyikan popup
        });
    </script> --}}


    {{-- FOOT  --}}
    @include('pwa.layouts.partials.foot')

    <div class="whatsapp-chat">
        <input type="checkbox" id="whatsapp-chat-toggler" class="whatsapp-chat-toggler">

        <label for="whatsapp-chat-toggler" class="whatsapp-chat-backdrop"></label>

        <div class="whatsapp-chat-window">
            <div class="whatsapp-chat-header">
                <img src="https://i.imgur.com/G43yQHs.png" class="whatsapp-chat-contact-img">
                <div class="whatsapp-chat-contact-info">
                    <strong>Admin</strong>
                    <small>
                        Customer service
                        •
                        <span class="text-wa-light-green">Online</span>
                    </small>
                </div>
                <label for="whatsapp-chat-toggler" title="Fechar o chat do WhatsApp" class="whatsapp-chat-close">
                    <svg width="55" height="55" viewBox="0 0 55 55" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M42.5467 12.4536C43.2627 13.1696 43.2627 14.3304 42.5467 15.0464L15.0467 42.5464C14.3307 43.2623 13.1699 43.2623 12.454 42.5464C11.738 41.8304 11.738 40.6696 12.454 39.9536L39.954 12.4536C40.6699 11.7377 41.8307 11.7377 42.5467 12.4536Z"
                            fill="currentColor" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12.454 12.4536C13.1699 11.7377 14.3307 11.7377 15.0467 12.4536L42.5467 39.9536C43.2627 40.6696 43.2627 41.8304 42.5467 42.5464C41.8307 43.2623 40.6699 43.2623 39.954 42.5464L12.454 15.0464C11.738 14.3304 11.738 13.1696 12.454 12.4536Z"
                            fill="currentColor" />
                    </svg>
                </label>
            </div>
            <div class="whatsapp-chat-body">
                <p class="whatsapp-chat-bubble">
                    Hello, welcome. <br>
                    Welcome, we are ready to help you to make the plaque you want :) Please feel free to use our products
                </p>
                <a href="{{ $setting->link_wa }}" class="whatsapp-chat-btn">
                    Contact
                </a>
            </div>
        </div>

        <label for="whatsapp-chat-toggler" class="whatsapp-chat-button">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M20.4054 3.4875C18.1607 1.2375 15.1714 0 11.9946 0C5.4375 0 0.101786 5.33571 0.101786 11.8929C0.101786 13.9875 0.648214 16.0339 1.6875 17.8393L0 24L6.30536 22.3446C8.04107 23.2929 9.99643 23.7911 11.9893 23.7911H11.9946C18.5464 23.7911 24 18.4554 24 11.8982C24 8.72143 22.65 5.7375 20.4054 3.4875ZM11.9946 21.7875C10.2161 21.7875 8.475 21.3107 6.95893 20.4107L6.6 20.1964L2.86071 21.1768L3.85714 17.5286L3.62143 17.1536C2.63036 15.5786 2.11071 13.7625 2.11071 11.8929C2.11071 6.44464 6.54643 2.00893 12 2.00893C14.6411 2.00893 17.1214 3.0375 18.9857 4.90714C20.85 6.77679 21.9964 9.25714 21.9911 11.8982C21.9911 17.3518 17.4429 21.7875 11.9946 21.7875ZM17.4161 14.3839C17.1214 14.2339 15.6589 13.5161 15.3857 13.4196C15.1125 13.3179 14.9143 13.2696 14.7161 13.5696C14.5179 13.8696 13.95 14.5339 13.7732 14.7375C13.6018 14.9357 13.425 14.9625 13.1304 14.8125C11.3839 13.9393 10.2375 13.2536 9.08571 11.2768C8.78036 10.7518 9.39107 10.7893 9.95893 9.65357C10.0554 9.45536 10.0071 9.28393 9.93214 9.13393C9.85714 8.98393 9.2625 7.52143 9.01607 6.92679C8.775 6.34821 8.52857 6.42857 8.34643 6.41786C8.175 6.40714 7.97679 6.40714 7.77857 6.40714C7.58036 6.40714 7.25893 6.48214 6.98571 6.77679C6.7125 7.07679 5.94643 7.79464 5.94643 9.25714C5.94643 10.7196 7.0125 12.1339 7.15714 12.3321C7.30714 12.5304 9.25179 15.5304 12.2357 16.8214C14.1214 17.6357 14.8607 17.7054 15.8036 17.5661C16.3768 17.4804 17.5607 16.8482 17.8071 16.1518C18.0536 15.4554 18.0536 14.8607 17.9786 14.7375C17.9089 14.6036 17.7107 14.5286 17.4161 14.3839Z"
                    fill="currentColor" />
            </svg>
        </label>
    </div>


</body>

</html>
