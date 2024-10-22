@section('common.header')
<script>
  function theme(el) {
    part_val = $('html').attr('data-bs-theme');
    $.ajax({
      url: '{{ route('cookie') }}',
      type: 'get',
      data: {
        val  : part_val,
        type : 'theme',
    },
      datatype: 'json',
    })
    .done((data) => {
      $(el).find('i').toggleClass('ph-moon').toggleClass('ph-sun');
      $('html').attr('data-bs-theme',data);
      $('.logo img').attr('src','/image/logo-'+data+'.svg');
    })
    .fail((data) => {
      console.log('失敗');
    });
  };

  function setTabCookie(el) {
    get_val = $(el).attr('role');
    $.ajax({
      url: '{{ route('cookie') }}',
      type: 'get',
      data: {
        val  : get_val,
        type : 'tab',
    },
      datatype: 'json',
    })
    .done((data) => {
      console.log(data);
    })
    .fail((data) => {
      console.log('失敗');
    });
  };
</script>

<header class="topbar">
    <div class="with-vertical">
        <nav class="navbar navbar-expand-lg p-0">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link sidebartoggler nav-icon-hover ms-n3" id="headerCollapse" href="javascript:void(0)" onclick="sidebar()">
                        <i class="ph ph-list"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-lg-block">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#searchFaqModal">
                        <i class="ph ph-magnifying-glass"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav quick-links d-none d-lg-flex">
                <li class="nav-item dropdown hover-dd d-none d-lg-block">
                    <a class="nav-link" href="javascript:void(0)" data-bs-toggle="dropdown">
                        はじめましょう<span class="mt-1"><i class="fa-solid fa-chevron-down fs-3 ps-2"></i></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-nav dropdown-menu-animate-up py-0">
                        <div class="row">
                            <div class="col-8">
                                <div class="ps-7 pt-7">
                                    <div class="border-bottom">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="position-relative">
                                                    <a href="/manual" class="d-flex align-items-center pb-9 position-relative">
                                                        <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                            <img src="@asset('/image/icon-dd-chat.svg')" alt="" class="img-fluid" width="24" height="24">
                                                        </div>
                                                        <div class="d-inline-block">
                                                            <h6 class="mb-1 fw-semibold fs-3">マニュアル</h6>
                                                            <span class="fs-2 d-block text-body-secondary">マニュアルの作成と表示</span>
                                                        </div>
                                                    </a>
                                                    <a href="/order" class="d-flex align-items-center pb-9 position-relative">
                                                        <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                            <img src="@asset('/icon/icon-dd-cart.svg')" alt="" class="img-fluid" width="24" height="24">
                                                        </div>
                                                        <div class="d-inline-block">
                                                            <h6 class="mb-1 fw-semibold fs-3">購入リスト</h6>
                                                            <span class="fs-2 d-block text-body-secondary">備品などの購入依頼</span>
                                                        </div>
                                                    </a>
                                                    <a href="/shift/edit" class="d-flex align-items-center pb-9 position-relative">
                                                        <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                            <img src="@asset('/image/icon-dd-application.svg')" alt="" class="img-fluid" width="24" height="24">
                                                        </div>
                                                        <div class="d-inline-block">
                                                            <h6 class="mb-1 fw-semibold fs-3">シフト提出</h6>
                                                            <span class="fs-2 d-block text-body-secondary">シフトの提出</span>
                                                        </div>
                                                    </a>
                                                    <a href="/shift/edit" class="d-flex align-items-center pb-9 position-relative">
                                                        <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                            <img src="@asset('/image/icon-dd-application.svg')" alt="" class="img-fluid" width="24" height="24">
                                                        </div>
                                                        <div class="d-inline-block">
                                                            <h6 class="mb-1 fw-semibold fs-3">シフト提出</h6>
                                                            <span class="fs-2 d-block text-body-secondary">シフトの提出</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="position-relative">

                                                    <a href="/faq" class="d-flex align-items-center pb-9 position-relative">
                                                        <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                            <img src="@asset('/image/icon-dd-message-box.svg')" alt="" class="img-fluid" width="24" height="24">
                                                        </div>
                                                        <div class="d-inline-block">
                                                            <h6 class="mb-1 fw-semibold fs-3">
                                                                FAQ
                                                            </h6>
                                                            <span class="fs-2 d-block text-body-secondary">FAQの作成と表示</span>
                                                        </div>
                                                    </a>

                                                    <a href="/shift/calendar?depart={{ Cookie::get('default_shift_depart') }}" class="d-flex align-items-center pb-9 position-relative">
                                                        <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                            <img src="@asset('/image/icon-dd-date.svg')" alt="" class="img-fluid" width="24" height="24">
                                                        </div>
                                                        <div class="d-inline-block">
                                                            <h6 class="mb-1 fw-semibold fs-3">シフトカレンダー</h6>
                                                            <span class="fs-2 d-block text-body-secondary">シフトの確認</span>
                                                        </div>
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center py-3">
                                        <div class="col-7 d-flex align-items-center">
                                            <i class="ph ph-question me-2 fs-4"></i>まだ、プロフィールを設定していませんか？
                                        </div>
                                        <div class="col-5">
                                            <div class="d-flex justify-content-end pe-4">
                                                <a class="btn btn-primary" href="/profile/edit">いますぐ設定</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 ms-n4">
                                <div class="position-relative p-7 border-start h-100">
                                    <h5 class="fs-5 mb-9 fw-semibold">クイックリンク</h5>
                                    <ul class="">
                                        <li class="mb-3">
                                            <a class="fw-semibold bg-hover-primary" href="/profile/edit">プロフィール設定</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="d-block d-lg-none">
                <a href="/" class="text-nowrap logo-img position-relative">
                    <div class="logo position-relative d-flex" style="width:180px">
                        <img src="@if(Cookie::get('theme') == 'dark') @asset('/image/logo-dark.svg') @else @asset('/image/logo-light.svg') @endif" class="w-100">
                        <p class="position-absolute bottom-0 end-0 small fw-bolder mb-0 text-danger lh-1">@if(App::environment('testing'))TEST @elseif(App::environment('local'))LOCAL @endif</p>
                    </div>
                </a>
            </div>
            <a class="navbar-toggler nav-icon-hover p-0 border-0" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="p-2">
                    <i class="ph ph-dots-three-vertical fs-7"></i>
                </span>
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="javascript:void(0)" class="nav-link d-flex d-lg-none align-items-center justify-content-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar" aria-controls="offcanvasWithBothOptions">
                        <i class="ti ti-align-justified fs-7"></i>
                    </a>
                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                        <li class="nav-item">
                            <a type="button" class="nav-link moon dark-layout" onclick="theme(this);" style="display: flex;">
                                <i class="ph @if(Cookie::get('theme') == 'dark') ph-sun @else ph-moon @endif" style="display: flex;"></i>
                            </a>
                            <a class="nav-link sun light-layout" href="javascript:void(0)" style="display: none;">
                                <i class="fa-regular fa-sun" style="display: none;"></i>
                            </a>
                        </li>
                        <!-- ------------------------------- -->
                        <!-- end language Dropdown -->
                        <!-- ------------------------------- -->
                        <!-- ------------------------------- -->
                        <!-- start shopping cart Dropdown -->
                        <!-- ------------------------------- -->
                        <li class="nav-item">
                            <a class="nav-link position-relative nav-icon-hover" href="javascript:void(0)" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                <i class="ph ph-basket"></i>
                                <span class="popup-badge rounded-pill bg-danger text-white fs-2">{{ getUserOrders(5)->count() }}</span>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ph ph-bell-ringing"></i>
                                <div class="notification bg-primary rounded-circle"></div>
                            </a>
                            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                                <div class="d-flex align-items-center justify-content-between py-3 px-7">
                                    <h5 class="mb-0 fs-5 fw-semibold">最新のお知らせ</h5>
                                    <span class="badge text-bg-primary rounded-4 px-3 py-1 lh-sm">{{ getRecentNotices(5)->count() }} new</span>
                                </div>
                                <div class="message-body" data-simplebar="init">
                                    <div class="simplebar-wrapper" style="margin: 0px;">
                                        <div class="simplebar-height-auto-observer-wrapper">
                                            <div class="simplebar-height-auto-observer"></div>
                                        </div>
                                        <div class="simplebar-mask position-relative">
                                            <div class="simplebar-offset position-relative" style="right: 0px; bottom: 0px;">
                                                <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden;">
                                                    <div class="simplebar-content" style="padding: 0px;">
                                                        @foreach(getRecentNotices(5) as $notice)
                                                        <a href="/notification/detail/{{ $notice->id }}" class="py-6 px-7 d-flex align-items-center dropdown-item">
                                                            <span class="me-3">
                                                                @if(getFirstImage($notice->note))
                                                                <img src="@asset({{getFirstImage($notice->note)}})" alt="user" class="rounded-circle object-fit-cover" width="48" height="48">
                                                                @else
                                                                <img src="@asset('/thumb/no-bg.svg')" alt="user" class="rounded-circle object-fit-cover" width="48" height="48">
                                                                @endif
                                                            </span>
                                                            <div class="w-75 d-inline-block v-middle">
                                                                <h6 class="mb-1 fw-semibold lh-base">{{ $notice->title }}</h6>
                                                                <span class="fs-2 d-block text-body-secondary">{{ $notice->created_at->format('Y年n月j日') }}</span>
                                                            </div>
                                                        </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                        <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                                    </div>
                                    <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                                        <div class="simplebar-scrollbar" style="height: 0px; display: none;"></div>
                                    </div>
                                </div>
                                <div class="py-6 px-7 mb-1">
                                    <a class="btn btn-outline-primary w-100" href="/notification/list">お知らせ一覧</a>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <div class="user-profile-img">
                                        <img src="{{ getUserImage(Auth::user()->id) }}" class="rounded-circle object-fit-cover" width="35" height="35" alt="aaa">
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
                                <div class="profile-dropdown position-relative" data-simplebar="init">
                                    <div class="simplebar-wrapper" style="margin: 0px;">
                                        <div class="simplebar-height-auto-observer-wrapper">
                                            <div class="simplebar-height-auto-observer"></div>
                                        </div>
                                        <div class="simplebar-mask position-relative">
                                            <div class="simplebar-offset position-relative" style="right: 0px; bottom: 0px;">
                                                <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden;">
                                                    <div class="simplebar-content" style="padding: 0px;">
                                                        <div class="py-3 px-7 pb-0">
                                                            <h5 class="mb-0 fs-5 fw-semibold">あなたのプロフィール</h5>
                                                        </div>
                                                        <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                                            <img src="{{ getUserImage(Auth::user()->id) }}" class="rounded-circle object-fit-cover" width="80" height="80" alt="">
                                                            <div class="ms-3">
                                                                <h5 class="mb-1 fs-3">{{ Auth::user()->name }}</h5>
                                                                <p class="mb-0 d-flex align-items-center gap-2"><i class="ph ph-identification-card fs-5"></i>{!! App\Models\Admin::getAdmin(Auth::user()->id) ? App\Models\Admin::getAdmin(Auth::user()->id)->title : $yet !!}</p>
                                                                <p class="mb-0 d-flex align-items-center gap-2 lh-1">
                                                                    <i class="ph ph-envelope-simple-open fs-5"></i>{{ Auth::user()->email }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="message-body">
                                                            <a href="/profile" class="py-8 px-7 mt-8 d-flex align-items-center">
                                                                <span class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                                    <img src="@asset('/image/icon-account.svg')" alt="" width="24" height="24">
                                                                </span>
                                                                <div class="w-75 d-inline-block v-middle ps-3">
                                                                    <h6 class="mb-1 fs-3 fw-semibold lh-base">あなたのプロフィール</h6>
                                                                    <span class="fs-2 d-block text-body-secondary">プロフィール設定</span>
                                                                </div>
                                                            </a>
                                                            <a href="/order?register_id={{ Auth::user()->id }}" class="py-8 px-7 d-flex align-items-center">
                                                                <span class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                                    <img src="@asset('/image/icon-tasks.svg')" alt="" width="24" height="24">
                                                                </span>
                                                                <div class="w-75 d-inline-block v-middle ps-3">
                                                                    <h6 class="mb-1 fs-3 fw-semibold lh-base">購入のリクエスト</h6>
                                                                    <span class="fs-2 d-block text-body-secondary">リクエスト中の商品</span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="d-grid py-4 px-7 pt-8">
                                                            <form action="{{ route('signout') }}" method="post">@csrf<button class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center"><i class="ph ph-hand-waving me-2 fs-5"></i>サインアウト</button></form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                        <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                                    </div>
                                    <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                                        <div class="simplebar-scrollbar" style="height: 0px; display: none;"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- ------------------------------- -->
                        <!-- end profile Dropdown -->
                        <!-- ------------------------------- -->
                    </ul>
                </div>
            </div>
        </nav>

    </div>

    <div class="app-header with-horizontal">
        <nav class="navbar navbar-expand-xl container-fluid p-0">
            <ul class="navbar-nav">
                <li class="nav-item d-block d-xl-none">
                    <a class="nav-link sidebartoggler ms-n3" id="sidebarCollapse" href="javascript:void(0)">
                        <i class="ph ph-list"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-xl-block">
                    <a href="/" class="text-nowrap nav-link">
                        <div class="logo position-relative d-flex" style="width:180px">
                            <img src="@if(Cookie::get('theme') == 'dark') @asset('/image/logo-dark.svg') @else @asset('/image/logo-light.svg') @endif" class="w-100">
                            <p class="position-absolute bottom-0 end-0 small fw-bolder mb-0 text-danger lh-1">@if(App::environment('testing'))TEST @elseif(App::environment('local'))LOCAL @endif</p>
                        </div>
                    </a>
                </li>
                <li class="nav-item d-none d-xl-block">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#searchFaqModal">
                        <i class="ph ph-magnifying-glass"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav quick-links d-none d-xl-flex">
                <!-- ------------------------------- -->
                <!-- start apps Dropdown -->
                <!-- ------------------------------- -->
                <li class="nav-item dropdown hover-dd d-none d-lg-block">
                    <a class="nav-link" href="javascript:void(0)" data-bs-toggle="dropdown">
                        はじめましょう<span><i class="fa-solid fa-chevron-down fs-2 ps-2"></i></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-nav dropdown-menu-animate-up py-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="p-7 pb-0">
                                    <div class="border-bottom">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="position-relative">
                                                    <a href="/manual" class="d-flex align-items-center pb-9 position-relative">
                                                        <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                            <img src="@asset('/image/icon-dd-chat.svg')" alt="" class="img-fluid" width="24" height="24">
                                                        </div>
                                                        <div class="d-inline-block">
                                                            <h6 class="mb-1 fw-semibold fs-3">マニュアル</h6>
                                                            <span class="fs-2 d-block text-body-secondary">マニュアルの作成と表示</span>
                                                        </div>
                                                    </a>
                                                    <a href="/order" class="d-flex align-items-center pb-9 position-relative">
                                                        <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                            <img src="@asset('/icon/icon-dd-cart.svg')" alt="" class="img-fluid" width="24" height="24">
                                                        </div>
                                                        <div class="d-inline-block">
                                                            <h6 class="mb-1 fw-semibold fs-3">購入リスト</h6>
                                                            <span class="fs-2 d-block text-body-secondary">備品などの購入依頼</span>
                                                        </div>
                                                    </a>

                                                    <a href="/shift/edit" class="d-flex align-items-center pb-9 position-relative">
                                                        <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                            <img src="@asset('/image/icon-dd-application.svg')" alt="" class="img-fluid" width="24" height="24">
                                                        </div>
                                                        <div class="d-inline-block">
                                                            <h6 class="mb-1 fw-semibold fs-3">シフト提出</h6>
                                                            <span class="fs-2 d-block text-body-secondary">シフトの提出</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="position-relative">

                                                    <a href="/faq" class="d-flex align-items-center pb-9 position-relative">
                                                        <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                            <img src="@asset('/image/icon-dd-message-box.svg')" alt="" class="img-fluid" width="24" height="24">
                                                        </div>
                                                        <div class="d-inline-block">
                                                            <h6 class="mb-1 fw-semibold fs-3">
                                                                FAQ
                                                            </h6>
                                                            <span class="fs-2 d-block text-body-secondary">FAQの作成と表示</span>
                                                        </div>
                                                    </a>

                                                    <a href="/shift/calendar?depart={{ Cookie::get('default_shift_depart') }}" class="d-flex align-items-center pb-9 position-relative">
                                                        <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                            <img src="@asset('/image/icon-dd-date.svg')" alt="" class="img-fluid" width="24" height="24">
                                                        </div>
                                                        <div class="d-inline-block">
                                                            <h6 class="mb-1 fw-semibold fs-3">シフトカレンダー</h6>
                                                            <span class="fs-2 d-block text-body-secondary">シフトの確認</span>
                                                        </div>
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center py-3">
                                        <div class="col-7 d-flex align-items-center">
                                            <i class="ph ph-question me-2 fs-4"></i>まだ、プロフィールを設定していませんか？
                                        </div>
                                        <div class="col-5">
                                            <div class="d-flex justify-content-end pe-4">
                                                <a class="btn btn-primary" href="/profile/edit">いますぐ設定</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="d-block d-xl-none">
                <a href="/" class="text-nowrap nav-link position-relative">
                    <div class="logo position-relative d-flex" style="width:180px">
                        <img src="@if(Cookie::get('theme') == 'dark') @asset('/image/logo-dark.svg') @else @asset('/image/logo-light.svg') @endif" class="w-100">
                        <p class="position-absolute bottom-0 end-0 small fw-bolder mb-0 text-danger lh-1">@if(App::environment('testing'))TEST @elseif(App::environment('local'))LOCAL @endif</p>
                    </div>
                </a>
            </div>
            <a class="navbar-toggler nav-icon-hover p-0 border-0" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="p-2">
                    <i class="ph ph-dots-three-vertical fs-7"></i>
                </span>
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center justify-content-between px-0 px-xl-8">
                    <a href="javascript:void(0)" class="nav-link round-40 p-1 ps-0 d-flex d-xl-none align-items-center justify-content-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar" aria-controls="offcanvasWithBothOptions">
                        <i class="ti ti-align-justified fs-7"></i>
                    </a>
                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                        <li class="nav-item">
                            <a type="button" class="nav-link moon dark-layout" onclick="theme(this);" style="display: flex;">
                                <i class="ph @if(Cookie::get('theme') == 'dark') ph-sun @else ph-moon @endif" style="display: flex;"></i>
                            </a>
                            <a class="nav-link sun light-layout" href="javascript:void(0)" style="display: none;">
                                <i class="fa-regular fa-sun" style="display: none;"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link position-relative nav-icon-hover" href="javascript:void(0)" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                <i class="ph ph-basket"></i>
                                <span class="popup-badge rounded-pill bg-danger text-white fs-2">{{ getUserOrders(5)->count() }}</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ph ph-bell-ringing"></i>
                                <div class="notification bg-primary rounded-circle"></div>
                            </a>
                            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                                <div class="d-flex align-items-center justify-content-between py-3 px-7">
                                    <h5 class="mb-0 fs-5 fw-semibold">最新のお知らせ</h5>
                                    <span class="badge text-bg-primary rounded-4 px-3 py-1 lh-sm">{{ getRecentNotices(5)->count() }} new</span>
                                </div>
                                <div class="message-body" data-simplebar="init">
                                    <div class="simplebar-wrapper" style="margin: 0px;">
                                        <div class="simplebar-height-auto-observer-wrapper">
                                            <div class="simplebar-height-auto-observer"></div>
                                        </div>
                                        <div class="simplebar-mask position-relative">
                                            <div class="simplebar-offset position-relative" style="right: 0px; bottom: 0px;">
                                                <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden;">
                                                    <div class="simplebar-content" style="padding: 0px;">
                                                        @foreach(getRecentNotices(5) as $notice)
                                                        <a href="/notification/detail/{{ $notice->id }}" class="py-6 px-7 d-flex align-items-center dropdown-item">
                                                            <span class="me-3">
                                                                @if(getFirstImage($notice->note))
                                                                <img src="@asset({{getFirstImage($notice->note)}})" alt="user" class="rounded-circle object-fit-cover" width="48" height="48">
                                                                @else
                                                                <img src="@asset('/thumb/no-bg.svg')" alt="user" class="rounded-circle object-fit-cover" width="48" height="48">
                                                                @endif
                                                            </span>
                                                            <div class="w-75 d-inline-block v-middle overflow-hidden">
                                                                <h6 class="mb-1 fw-semibold lh-base">{{ $notice->title }}</h6>
                                                                <span class="fs-2 d-block text-body-secondary">{{ $notice->created_at->format('Y年n月j日') }}</span>
                                                            </div>
                                                        </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                        <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                                    </div>
                                    <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                                        <div class="simplebar-scrollbar" style="height: 0px; display: none;"></div>
                                    </div>
                                </div>
                                <div class="py-6 px-7 mb-1">
                                    <a class="btn btn-outline-primary w-100" href="/notification/list">お知らせ一覧</a>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <div class="user-profile-img">
                                        <img src="{{ getUserImage(Auth::user()->id) }}" class="rounded-circle object-fit-cover" width="35" height="35" alt="">
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
                                <div class="profile-dropdown position-relative" data-simplebar="init">
                                    <div class="simplebar-wrapper" style="margin: 0px;">
                                        <div class="simplebar-height-auto-observer-wrapper">
                                            <div class="simplebar-height-auto-observer"></div>
                                        </div>
                                        <div class="simplebar-mask position-relative">
                                            <div class="simplebar-offset position-relative" style="right: 0px; bottom: 0px;">
                                                <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden;">
                                                    <div class="simplebar-content text-break" style="padding: 0px;">
                                                        <div class="py-3 px-7 pb-0">
                                                            <h5 class="mb-0 fs-5 fw-semibold">あなたのプロフィール</h5>
                                                        </div>
                                                        <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                                            <img src="{{ getUserImage(Auth::user()->id) }}" class="rounded-circle object-fit-cover" width="80" height="80" alt="">
                                                            <div class="ms-3">
                                                                <h5 class="mb-1 fs-3">{{ Auth::user()->name }}</h5>
                                                                <p class="mb-0 d-flex align-items-center gap-2"><i class="ph ph-identification-card fs-5"></i>{!! App\Models\Admin::getAdmin(Auth::user()->id) ? App\Models\Admin::getAdmin(Auth::user()->id)->title : $yet !!}</p>
                                                                <p class="mb-0 d-flex align-items-center gap-2 lh-1">
                                                                    <i class="ph ph-envelope-simple-open fs-5"></i>{{ Auth::user()->email }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="message-body">
                                                            <a href="/profile" class="py-8 px-7 mt-8 d-flex align-items-center">
                                                                <span class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                                    <img src="@asset('/image/icon-account.svg')" alt="" width="24" height="24">
                                                                </span>
                                                                <div class="w-75 d-inline-block v-middle ps-3">
                                                                    <h6 class="mb-1 fs-3 fw-semibold lh-base">あなたのマイページ</h6>
                                                                    <span class="fs-2 d-block text-body-secondary">マイページトップ</span>
                                                                </div>
                                                            </a>
                                                            <a href="/profile/edit" class="py-8 px-7 d-flex align-items-center">
                                                                <span class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                                    <img src="@asset('/image/icon-dd-application.svg')" alt="" width="24" height="24">
                                                                </span>
                                                                <div class="w-75 d-inline-block v-middle ps-3">
                                                                    <h6 class="mb-1 fs-3 fw-semibold lh-base">プロフィール設定</h6>
                                                                    <span class="fs-2 d-block text-body-secondary">プロフィールの変更</span>
                                                                </div>
                                                            </a>
                                                            <a href="/order?register_id={{ Auth::user()->id }}" class="py-8 px-7 d-flex align-items-center">
                                                                <span class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                                    <img src="@asset('/image/icon-inbox.svg')" alt="" width="24" height="24">
                                                                </span>
                                                                <div class="w-75 d-inline-block v-middle ps-3">
                                                                    <h6 class="mb-1 fs-3 fw-semibold lh-base">購入のリクエスト</h6>
                                                                    <span class="fs-2 d-block text-body-secondary">リクエスト中の商品</span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="d-grid py-4 px-7 pt-8">
                                                            <form action="{{route('signout')}}" method="post">@csrf<button class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center"><i class="ph ph-hand-waving me-2 fs-5"></i>サインアウト</button></form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                        <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                                    </div>
                                    <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                                        <div class="simplebar-scrollbar" style="height: 0px; display: none;"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
@endsection