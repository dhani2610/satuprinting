<!DOCTYPE html>
<html lang="en">

<head>
  {{-- head  --}}
  @include('landing.layouts.partials.head')

</head>

<body class="index-page">

  {{-- header  --}}
  @include('landing.layouts.partials.header')

  @yield('content-landing')


  {{-- footer  --}}
  @include('landing.layouts.partials.footer')

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader">
    <div></div>
    <div></div>
    <div></div>
    <div></div>
  </div>

  {{-- foot  --}}
  @include('landing.layouts.partials.foot')


</body>

</html>