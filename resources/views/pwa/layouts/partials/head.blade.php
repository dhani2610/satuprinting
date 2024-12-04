<meta charset="utf-8">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
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


<!-- Other Meta Tags -->


<link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets-pwa/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets-pwa/css/slick.css') }}">
<link rel="stylesheet" href="{{ asset('assets-pwa/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets-pwa/css/style.css') }}">
<link rel="stylesheet" href="https://buatplakat.id/lib/fontawesome/css/font-awesome.min.css"/>