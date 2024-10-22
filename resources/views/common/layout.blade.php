<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="{{ Cookie::get('theme') }}" data-layout="horizontal">
  <head>
      @yield('common.head')
  </head>
  <body class="link-sidebar" data-sidebartype="full">
    <div id="main-wrapper">
      @yield('common.header')
      @yield('common.aside')

      @yield('contents')

      @yield('common.footer')
    </div>
    <div class="dark-transparent sidebartoggler" onclick="sidebar()"></div>
  </body>
</html>