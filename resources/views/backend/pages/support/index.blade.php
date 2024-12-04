@extends('backend.layouts-new.app')

@section('content')
    <style>
        .form-check-label {
            text-transform: capitalize;
        }

        .select2 {
            width: 100% !important
        }

        label {
            float: left;
        }

        .faq-header .input-wrapper {
            position: relative;
            width: 100%;
            max-width: 55%;
        }

        @media (max-width: 575.98px) {
            .faq-header .input-wrapper {
                max-width: 70%;
            }
        }

        .faq-nav-icon {
            font-size: 1.25rem;
        }

        .faq-banner-img {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            object-fit: cover;
            object-position: left;
            border-radius: 0.375rem;
        }

        .light-style .bg-faq-section {
            background-color: rgba(67, 89, 113, 0.05);
        }

        .dark-style .bg-faq-section {
            background-color: rgba(255, 255, 255, 0.03);
        }
    </style>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="faq-header d-flex flex-column justify-content-center align-items-center h-px-300 position-relative">
                <img src="../../assets/img/pages/header.png" class="scaleX-n1-rtl faq-banner-img" alt="background image" />
                <h3 class="text-center">Hello, how can we help?</h3>
                <div class="input-wrapper my-3 input-group input-group-merge">
                    <span class="input-group-text" id="basic-addon1"><i class="bx bx-search-alt bx-xs text-muted"></i></span>
                    <input type="text" class="form-control form-control-lg" placeholder="Search a question..."
                        aria-label="Search" aria-describedby="basic-addon1" />
                </div>
                <p class="text-center mb-0 px-3">or choose a category to quickly find the help you need</p>
            </div>



            <!-- Contact -->
            <div class="row mt-5">
                <div class="col-12 text-center mb-4">
                    <div class="badge bg-label-primary">Question?</div>
                    <h4 class="my-2">You still have a question?</h4>
                    <p>If you can't find question in our FAQ, you can contact us. We'll answer you shortly!</p>
                </div>
            </div>
            <div class="row text-center justify-content-center gap-sm-0 gap-3">
                <div class="col-sm-6">
                    <div class="py-3 rounded bg-faq-section text-center">
                        <span class="badge bg-label-primary rounded-2 my-3">
                            <i class="bx bx-phone bx-sm"></i>
                        </span>
                        <h4 class="mb-2"><a class="h4" href="tel:+(810)25482568">(0267) 6491480</a></h4>
                        <p>We are always happy to help</p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="py-3 rounded bg-faq-section text-center">
                        <span class="badge bg-label-primary rounded-2 my-3">
                            <i class="bx bx-envelope bx-sm"></i>
                        </span>
                        <h4 class="mb-2"><a class="h4"
                                href="mailto:support@tnrsolution.com">jdevaofficial@gmail.com</a></h4>
                        <p>Best way to get a quick answer</p>
                    </div>
                </div>
            </div>
            <!-- /Contact -->
        </div>
        <!-- / Content -->
    @endsection


    @section('script')
    @endsection
