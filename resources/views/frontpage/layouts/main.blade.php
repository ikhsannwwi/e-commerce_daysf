<!DOCTYPE html>
<html lang="en-US" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>{{ array_key_exists('nama_app_frontpage', $settings) ? $settings['nama_app_frontpage'] : 'Startweb' }}</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="shortcut icon"
        href="{{ array_key_exists('favicon_frontpage', $settings) ? img_src($settings['favicon_frontpage'], 'settings') : 'http://placehold.it/500x500?text=Not Found' }}"
        type="image/png">
    {{-- <link rel="apple-touch-icon" sizes="180x180" href="{{template_frontpage('assets/img/favicons/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{template_frontpage('assets/img/favicons/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{template_frontpage('assets/img/favicons/favicon-16x16.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{template_frontpage('assets/img/favicons/favicon.ico')}}"> --}}
    <link rel="manifest" href="{{template_frontpage('assets/img/favicons/manifest.json')}}">
    <meta name="msapplication-TileImage" content="{{template_frontpage('assets/img/favicons/mstile-150x150.png')}}">
    <meta name="theme-color" content="#ffffff">


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="{{template_frontpage('assets/css/theme.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0-9/css/all.min.css" integrity="sha512-X8jR8oYnEmXhGB43u+qxt0mQezR37NUxHhtukvD4bzeWDthOz0mvNOYOzPCMZ7VB0mG607nrkd+kakmSmbffyQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">

    @stack('css')

  </head>


  <body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">

      @include('frontpage.layouts.navbar')

      @yield('content')


      <!-- ============================================-->
      <!-- <section> begin ============================-->
      @include('frontpage.layouts.footer')
      <!-- <section> close ============================-->
      <!-- ============================================-->


    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->




    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="{{ asset('jquery/dist/jquery.js') }}"></script>
    <script src="{{template_frontpage('vendors/@popperjs/popper.min.js')}}"></script>
    <script src="{{template_frontpage('vendors/bootstrap/bootstrap.min.js')}}"></script>
    <script src="{{template_frontpage('vendors/is/is.min.js')}}"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="{{template_frontpage('vendors/feather-icons/feather.min.js')}}"></script>
    <script>
      feather.replace();
    </script>
    <script src="{{template_frontpage('assets/js/theme.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">

    @stack('js')
  </body>

</html>