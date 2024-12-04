@extends('backend.layouts-new.app')

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">

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
    </style>
    @include('backend.layouts.partials.messages')

    <div class="main-content-inner">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('setting.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="ecommerce-customer-add-shiping mb-3 pt-3">

                                <div class="form-row">
                                    <div class="form-group col-md-12 col-sm-12 mb-3">
                                        <label for="name" class="mb-3">LOGO WEBSITE</label>
                                        <input type="file" class="form-control dropify" id="logo" name="logo"
                                            placeholder="Enter Name" value="" data-default-file="{{ asset('assets/img/logo/' . $setting->logo) }}">
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 mb-3">
                                        <label for="name" class="mb-3">BANNER POPUP</label>
                                        <input type="file" class="form-control dropify" id="banner_popup" name="banner_popup"
                                            placeholder="Enter Name" value="" data-default-file="{{ asset('assets/img/banner_popup/' . $setting->banner_popup) }}">
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 mb-3">
                                        <label for="name" class="mb-3">JUDUL WEBSITE</label>
                                        <input type="text" class="form-control" id="nama_website" value="{{ $setting->nama_website }}" name="nama_website"
                                            placeholder="Enter Name Website" required value="">
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 mb-3">
                                        <label for="name" class="mb-3">LINK WHATSAPP</label>
                                        <input type="text" class="form-control" id="price" value="{{ $setting->link_wa }}" name="link_wa"
                                            placeholder="Enter Link WhatsApp" value="">
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 mb-3">
                                        <label for="email" class="mb-3">META DESCRIPTION</label>
                                        <textarea name="meta_description" required class="form-control" id="" cols="30" rows="10">{{ $setting->meta_description }}</textarea>
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 mb-3">
                                        <label for="email" class="mb-3">META KEYWORD</label>
                                        <textarea name="meta_keyword" required class="form-control" id="" cols="30" rows="10">{{ $setting->meta_keyword }}</textarea>
                                    </div>

                                </div>


                            </div>

                            <div class="pt-3">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- data table end -->

        </div>
    </div>
@endsection


@section('script')
    <!-- jQuery (Wajib sebelum Bootstrap JS) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Bootstrap 4 JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

    <!-- Summernote JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>

    <script>
        $('.dropify').dropify();

        $(function() {
            $('[data-toggle="tooltip"]').tooltip(); // Inisialisasi tooltip secara manual
        });
        $('.summernote').summernote({
            placeholder: 'Content Here',
            tabsize: 2,
            height: 100,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                // ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                //['fontname', ['fontname']],
                // ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'hr']],
                //['view', ['fullscreen', 'codeview']],
                ['help', ['help']]
            ],
        });
    </script>
    <script>
        function showCreateButton() {
            console.log('click');
            $('.buttonCreate').trigger('click');
        }
    </script>
@endsection
