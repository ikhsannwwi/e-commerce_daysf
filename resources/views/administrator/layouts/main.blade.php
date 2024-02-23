<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>{{ array_key_exists('nama_app_admin', $settings) ? $settings['nama_app_admin'] : 'Startweb' }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="shortcut icon"
        href="{{ array_key_exists('favicon', $settings) ? img_src($settings['favicon'], 'settings') : '' }}"
        type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{template_administrator('assets/vendor/fonts/boxicons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{template_administrator('assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{template_administrator('assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{template_administrator('assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{template_administrator('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

    <link rel="stylesheet" href="{{template_administrator('assets/vendor/libs/apex-charts/apex-charts.css')}}" />

    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset_administrator('assets/plugins/sweetalert2/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset_administrator('assets/plugins/calendarify/dist/calendarify.min.css')}}">
    <link rel="stylesheet" href="{{asset_administrator('assets/plugins//toasty/toasty.min.css')}}">
    <link rel="stylesheet" href="{{ asset_administrator('assets/plugins/parsleyjs/parsley.min.css') }}">

    @stack('css')

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{template_administrator('assets/vendor/js/helpers.js')}}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{template_administrator('assets/js/config.js')}}"></script>
  </head>

  <body>
    <div id="audioContainer" class="audioContainer">
        <!-- Other content in the container -->
     </div>
     
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        @include('administrator.layouts.sidebar')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          @include('administrator.layouts.nav')

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            @yield('content')
            <!-- / Content -->

            @include('administrator.layouts.footer')

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    {{-- <div class="buy-now">
      <a
        href="https://themeselection.com/products/sneat-bootstrap-html-admin-template/"
        target="_blank"
        class="btn btn-danger btn-buy-now"
        >Upgrade to Pro</a
      >
    </div> --}}

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('jquery/dist/jquery.js') }}"></script>
    <script src="{{template_administrator('assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{template_administrator('assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{template_administrator('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

    {{-- plugin --}}
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.js"></script>
    <script src="{{ asset_administrator('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{asset_administrator('assets/plugins/calendarify/dist/calendarify.iife.js')}}"></script>

    {{-- <script src="{{ asset_administrator('assets/plugins/toasty/toasty.min.js') }}"></script> --}}
    {{-- <script src="{{ asset_administrator('assets/plugins/toasty/page.js') }}"></script> --}}
    
    <script src="{{template_administrator('assets/vendor/js/menu.js')}}"></script>
    <!-- endbuild -->
    
    <!-- Vendors JS -->
    <script src="{{template_administrator('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
    
    <!-- Main JS -->
    <script src="{{template_administrator('assets/js/main.js')}}"></script>
    
    <script src="{{ asset_administrator('assets/plugins/sweetalert2/toast.js') }}"></script>
    <script src="{{ asset_administrator('assets/plugins/sweetalert2/page/toast.js') }}"></script>
    <script>
        var toastMessages = {
            path: "{{ asset_administrator('assets/plugins/toasty/') }}",
            errors: [],
            error: @json(session('error')),
            success: @json(session('success')),
            warning: @json(session('warning')),
            info: @json(session('info'))
        };
    </script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    @stack('js')
  </body>
</html>
