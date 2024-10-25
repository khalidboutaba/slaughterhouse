<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Nadigit SMS')</title>
    <link rel="icon" href="{{ asset('img/logo/Nadigit_logo.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/iconly.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.rtl.css') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/icons/ios/196.png') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Nadigit SMS">
    @yield('styles')
    
  </head>
  <body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="app">
      <!-- Start Sidebar Menu -->
      @include('layouts.sidebar')
      <!-- End Sidebar Menu -->
    </div>
    </div>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        @yield('content')
        @include('layouts.footer')
    </div>
    </div>
    <script src="{{ asset('assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
    @yield('scripts')
  </body>
</html>
