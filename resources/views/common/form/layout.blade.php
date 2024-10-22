<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
      @yield('common.form.head')
  </head>
  @yield('common.form.header')
  <body data-sidebartype="full">
    <div id="main-wrapper">
      <div class="position-relative overflow-hidden radial-gradient min-vh-100 w-100">
        <div class="position-relative z-index-5">
          <div class="row">
            <div class="col-xl-7 col-xxl-8">
              <a href="/" class="text-nowrap logo-img d-block px-4 py-9 w-100">
                <div class="position-relative" style="width: 174px;"><img src="@asset('/image/logo-light.svg')" class="dark-logo w-100" alt="Logo-Dark">
                  <p class="position-absolute bottom-0 end-0 small fw-bolder mb-0 text-danger lh-1">@if(App::environment('testing'))TEST @elseif(App::environment('local'))LOCAL @endif</p>
                </div>
              </a>
              <div class="d-none d-xl-flex align-items-center justify-content-center" style="height: calc(100vh - 80px);">
                <img src="@asset('/image/login.svg')" alt="" class="img-fluid" width="500">
              </div>
            </div>

            @yield('contents')

          </div>
        </div>
      </div>
    </div>
  </body>
  @yield('common.form.footer')
</html>