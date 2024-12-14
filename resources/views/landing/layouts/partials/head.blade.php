<meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  @php
    $setting = \App\Models\Setting::first()
    @endphp
    <title>{{ $setting->nama_website }} | {{ $page_title ?? 'Home' }}</title>
    <link rel="icon" href="{{ asset('assets/img/logo/' . $setting->logo) }}">

    <!-- Meta Description -->
    <meta name="description" content="{{ isset($prod) && $prod->description ? $prod->meta_description : $setting->meta_description }}">

    <!-- Meta Keywords -->
    <meta name="keywords" content="{{ isset($prod) && $prod->description ? $prod->description : $setting->keyword }}">

    <!-- Open Graph Tags (for Facebook, LinkedIn, etc.) -->
    <meta property="og:title" content="{{ isset($prod) && $prod->service ? $prod->service : $setting->name_website }}">
    <meta property="og:description" content="{{ isset($prod) && $prod->description ? $prod->description : $setting->meta_description }}">
    <meta property="og:image" content="{{ isset($prod) && $prod->image ? asset('assets/img/product/' . $prod->image) : asset('assets/img/logo/' . $setting->logo) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets-landing/vendor/bootstrap/css/bootstrap.min.css' )}}" rel="stylesheet">
  <link href="{{ asset('assets-landing/vendor/bootstrap-icons/bootstrap-icons.css' )}}" rel="stylesheet">
  <link href="{{ asset('assets-landing/vendor/aos/aos.css' )}}" rel="stylesheet">
  <link href="{{ asset('assets-landing/vendor/swiper/swiper-bundle.min.css' )}}" rel="stylesheet">
  <link href="{{ asset('assets-landing/vendor/glightbox/css/glightbox.min.css' )}}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('assets-landing/css/main.css' )}}" rel="stylesheet">

