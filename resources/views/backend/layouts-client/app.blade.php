<!doctype html>

<html
  lang="en"
  class="light-style layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/"
  data-template="horizontal-menu-template">
  <head>
    @include('backend.layouts-client.partials.head')
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
      <div class="layout-container">
        <!-- Navbar -->
        @include('backend.layouts-client.partials.navbar')
      

        <!-- / Navbar -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Content wrapper -->
          <div class="content-wrapper">

            <div class="container-xxl flex-grow-1 container-p-y">
              @yield('content')
            </div>
            <!--/ Content -->

            <!-- Footer -->
           
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!--/ Content wrapper -->
        </div>

        <!--/ Layout container -->
      </div>
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>

    <!--/ Layout wrapper -->
    @include('backend.layouts-client.partials.footer')

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    @include('backend.layouts-client.partials.foot')

   
  </body>
</html>
