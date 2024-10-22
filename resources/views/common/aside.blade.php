@section('common.aside')
<aside class="left-sidebar with-horizontal">
    <div>
        <nav class="sidebar-nav scroll-sidebar container-fluid">
            <ul id="sidebarnav">
                @can('isMasterOrAdmin')
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">社員・パート</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow @if(str_contains(request()->path(),'user') || str_contains(request()->path(),'admin') || str_contains(request()->path(),'employment'))active @endif" href="/admin" aria-expanded="false">
                        <i class="ph ph-user fs-5"></i>
                        <span class="hide-menu">社員・パート</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="/admin" class="sidebar-link">
                                <i class="ph ph-user-list fs-5"></i>
                                <span class="hide-menu">一覧を見る</span>
                            </a>
                        </li>
                        @can('isMaster')
                        <li class="sidebar-item">
                            <a href="/employment" class="sidebar-link">
                                <i class="ph ph-briefcase fs-5"></i>
                                <span class="hide-menu">雇用形態一覧</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>

                <li class="nav-small-cap">
                    <i class="ph ph-building-office nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">企業</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow @if(str_contains(request()->path(),'location')||str_contains(request()->path(),'corp'))active @endif" href="/location" aria-expanded="false">
                        <span>
                            <i class="ph ph-building-office fs-5"></i>
                        </span>
                        <span class="hide-menu">オフィス</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="/location" class="sidebar-link">
                                <i class="ph ph-door-open fs-5"></i>
                                <span class="hide-menu">一覧を見る</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('location.edit') }}" class="sidebar-link">
                                <i class="ph ph-list-plus fs-5"></i>
                                <span class="hide-menu">オフィスを追加する</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/corp" class="sidebar-link">
                                <i class="ph ph-building-office fs-5"></i>
                                <span class="hide-menu">企業一覧</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">機材</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow @if(str_contains(request()->path(),'equipment'))active @endif" href="/equipment" aria-expanded="false">
                        <span>
                            <i class="ph ph-laptop fs-5"></i>
                        </span>
                        <span class="hide-menu">機材</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="/equipment" class="sidebar-link">
                                <i class="ph ph-desktop fs-5"></i>
                                <span class="hide-menu">一覧を見る</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/equipment/edit" class="sidebar-link">
                                <i class="ph ph-desktop-tower fs-5"></i>
                                <span class="hide-menu">機材を追加する</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

                <li class="nav-small-cap">
                    <i class="ph ph-clock-user nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">シフト</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link two-column has-arrow @if(str_contains(request()->path(),'shift'))active @endif" href="/shift/calendar?depart={{ Cookie::get('default_shift_depart') }}" aria-expanded="false">
                        <span>
                            <i class="ph ph-clock-user fs-5"></i>
                        </span>
                        <span class="hide-menu">シフト</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level start-0">
                        <li class="sidebar-item">
                            <a href="/shift/calendar?depart={{ Cookie::get('default_shift_depart') }}" class="sidebar-link">
                                <i class="ph ph-clock-user fs-5"></i>
                                <span class="hide-menu">カレンダーを見る</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/shift/edit" class="sidebar-link">
                                <i class="ph ph-clock-user fs-5"></i>
                                <span class="hide-menu">シフトを申請する</span>
                            </a>
                        </li>
                        @can('isMasterOrAdmin')
                        <li class="sidebar-item">
                            <a href="/shift" class="sidebar-link">
                                <i class="ph ph-clock-user fs-5"></i>
                                <span class="hide-menu">一覧を見る</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/shift/total" class="sidebar-link">
                                <i class="ph ph-chart-line fs-5"></i>
                                <span class="hide-menu">シフト集計</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>

                @can('isEngineer')
                <li class="nav-small-cap">
                    <i class="ph ph-browsers nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">サイト</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link two-column has-arrow @if(str_contains(request()->path(),'site'))active @endif" href="/site" aria-expanded="false">
                        <span>
                            <i class="ph ph-browsers fs-5"></i>
                        </span>
                        <span class="hide-menu">サイト</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="/site" class="sidebar-link">
                                <i class="ph ph-browsers fs-5"></i>
                                <span class="hide-menu">一覧を見る</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/site/edit" class="sidebar-link">
                                <i class="ph ph-browsers fs-5"></i>
                                <span class="hide-menu">サイトを追加する</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

                @can('isMaster')
                <li class="nav-small-cap">
                    <i class="ph ph-hard-drives nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">サーバ</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link two-column has-arrow @if(str_contains(request()->path(),'server') || str_contains(request()->path(),'database'))active @endif" href="/server" aria-expanded="false">
                        <span>
                            <i class="ph ph-hard-drives fs-5"></i>
                        </span>
                        <span class="hide-menu">サーバ</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="/server" class="sidebar-link">
                                <i class="ph ph-hard-drives fs-5"></i>
                                <span class="hide-menu">srv一覧を見る</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/server/edit" class="sidebar-link">
                                <i class="ph ph-hard-drives fs-5"></i>
                                <span class="hide-menu">srvを追加する</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/database" class="sidebar-link">
                                <i class="ph ph-database fs-5"></i>
                                <span class="hide-menu">db一覧を見る</span>
                            </a>
                        </li><li class="sidebar-item">
                            <a href="/database/edit" class="sidebar-link">
                                <i class="ph ph-database fs-5"></i>
                                <span class="hide-menu">dbを追加する</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

                @can('isMasterOrAdmin')
                <li class="nav-small-cap">
                    <i class="ph ph-bell nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">お知らせ</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow @if(str_contains(request()->path(),'notification'))active @endif" href="/notification" aria-expanded="false">
                        <span>
                            <i class="ph ph-bell fs-5"></i>
                        </span>
                        <span class="hide-menu">お知らせ</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="/notification" class="sidebar-link">
                                <i class="ph ph-bell fs-5"></i>
                                <span class="hide-menu">一覧を見る</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/notification/edit" class="sidebar-link">
                                <i class="ph ph-clock-user fs-5"></i>
                                <span class="hide-menu">お知らせを追加する</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

                @can('isMaster')
                <li class="nav-small-cap">
                    <i class="ph ph-bell nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">コンフィグ</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link @if(str_contains(request()->path(),'config'))active @endif" href="/config" aria-expanded="false">
                        <span>
                            <i class="ph ph-gear fs-5"></i>
                        </span>
                        <span class="hide-menu">コンフィグ</span>
                    </a>
                </li>
                @endcan

                @can('isBasic')
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">お知らせ</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link @if(str_contains(request()->path(),'notification'))active @endif" href="/notification/list" aria-expanded="false">
                        <span>
                            <i class="ph ph-bell fs-5"></i>
                        </span>
                        <span class="hide-menu">お知らせ</span>
                    </a>
                </li>

                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">マニュアル</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow @if(str_contains(request()->path(),'manual'))active @endif" href="/manual" aria-expanded="false">
                        <span>
                            <i class="ph ph-chats fs-5"></i>
                        </span>
                        <span class="hide-menu">マニュアル</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="/manual" class="sidebar-link">
                                <i class="ph ph-chats fs-5"></i>
                                <span class="hide-menu">一覧を見る</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/manual/edit" class="sidebar-link">
                                <i class="ph ph-list-plus fs-5"></i>
                                <span class="hide-menu">マニュアルを追加する</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">FAQ</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow @if(str_contains(request()->path(),'faq'))active @endif" href="/faq" aria-expanded="false">
                        <span>
                            <i class="ph ph-question fs-5"></i>
                        </span>
                        <span class="hide-menu">FAQ</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="/faq" class="sidebar-link">
                                <i class="ph ph-question fs-5"></i>
                                <span class="hide-menu">一覧を見る</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/faq/edit" class="sidebar-link">
                                <i class="ph ph-question fs-5"></i>
                                <span class="hide-menu">FAQを追加する</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

            </ul>
        </nav>
    </div>
</aside>

<!-- sp -->
<aside class="left-sidebar with-vertical">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="../horizontal/index.html" class="text-nowrap logo-img">
            <img src="@asset('/image/logo-dark.svg')" class="dark-logo" alt="Logo-Dark" style="width:180px;">
            <img src="@asset('/image/logo-light.svg')" class="light-logo" alt="Logo-light" style="width:180px;display: none;">
          </a>
          <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
            <i class="ti ti-x"></i>
          </a>
        </div>

        <nav class="sidebar-nav scroll-sidebar container-fluid">
            <ul id="sidebarnav">
                @can('isMaster')
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">HOME</span>
                </li>

                <li class="sidebar-item">
                  <a class="sidebar-link @if(str_contains(request()->path(),'user'))active @endif" href="/admin" id="get-url" aria-expanded="false">
                    <span>
                      <i class="ph ph-user fs-7"></i>
                    </span>
                    <span class="hide-menu">社員・パート</span>
                  </a>
                </li>

                <li class="sidebar-item">
                  <a class="sidebar-link @if(str_contains(request()->path(),'employment'))active @endif" href="/employment" id="get-url" aria-expanded="false">
                    <span>
                      <i class="ph ph-briefcase fs-7"></i>
                    </span>
                    <span class="hide-menu">雇用形態</span>
                  </a>
                </li>

                <li class="sidebar-item">
                  <a class="sidebar-link @if(str_contains(request()->path(),'location'))active @endif" href="/location" id="get-url" aria-expanded="false">
                    <span>
                      <i class="ph ph-door-open fs-7"></i>
                    </span>
                    <span class="hide-menu">オフィス</span>
                  </a>
                </li>

                <li class="sidebar-item">
                  <a class="sidebar-link @if(str_contains(request()->path(),'corp'))active @endif" href="/corp" id="get-url" aria-expanded="false">
                    <span>
                      <i class="ph ph-building-office fs-7"></i>
                    </span>
                    <span class="hide-menu">企業</span>
                  </a>
                </li>

                <li class="sidebar-item">
                  <a class="sidebar-link @if(str_contains(request()->path(),'equipment'))active @endif" href="/equipment" id="get-url" aria-expanded="false">
                    <span>
                      <i class="ph ph-laptop fs-7"></i>
                    </span>
                    <span class="hide-menu">機材</span>
                  </a>
                </li>

                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">SYSTEM</span>
                </li>

                <li class="sidebar-item">
                  <a class="sidebar-link @if(str_contains(request()->path(),'site'))active @endif" href="/site" id="get-url" aria-expanded="false">
                    <span>
                      <i class="ph ph-browsers fs-7"></i>
                    </span>
                    <span class="hide-menu">サイト</span>
                  </a>
                </li>

                <li class="sidebar-item">
                  <a class="sidebar-link @if(str_contains(request()->path(),'server'))active @endif" href="/server" id="get-url" aria-expanded="false">
                    <span>
                      <i class="ph ph-hard-drives fs-7"></i>
                    </span>
                    <span class="hide-menu">サーバー</span>
                  </a>
                </li>

                <li class="sidebar-item">
                  <a class="sidebar-link @if(str_contains(request()->path(),'database'))active @endif" href="/database" id="get-url" aria-expanded="false">
                    <span>
                      <i class="ph ph-database fs-7"></i>
                    </span>
                    <span class="hide-menu">データベース</span>
                  </a>
                </li>

                <li class="sidebar-item">
                  <a class="sidebar-link @if(str_contains(request()->path(),'config'))active @endif" href="/config" id="get-url" aria-expanded="false">
                    <span>
                      <i class="ph ph-gear fs-7"></i>
                    </span>
                    <span class="hide-menu">コンフィグ</span>
                  </a>
                </li>
                @endcan

                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">ALL</span>
                </li>

                <li class="sidebar-item">
                  <a class="sidebar-link @if(str_contains(request()->path(),'shift'))active @endif" href="/shift/calendar?depart={{ Cookie::get('default_shift_depart') }}" id="get-url" aria-expanded="false">
                    <span>
                      <i class="ph ph-clock-user fs-7"></i>
                    </span>
                    <span class="hide-menu">シフト</span>
                  </a>
                </li>

                <li class="sidebar-item">
                  <a class="sidebar-link @if(str_contains(request()->path(),'notification'))active @endif" href="/notification/list" id="get-url" aria-expanded="false">
                    <span>
                      <i class="ph ph-bell fs-7"></i>
                    </span>
                    <span class="hide-menu">お知らせ</span>
                  </a>
                </li>

                <li class="sidebar-item">
                  <a class="sidebar-link @if(str_contains(request()->path(),'order'))active @endif" href="/order" id="get-url" aria-expanded="false">
                    <span>
                      <i class="ph ph-basket fs-7"></i>
                    </span>
                    <span class="hide-menu">購入リスト</span>
                  </a>
                </li>

                <li class="sidebar-item">
                  <a class="sidebar-link @if(str_contains(request()->path(),'faq'))active @endif" href="/faq" id="get-url" aria-expanded="false">
                    <span>
                      <i class="ph ph-question fs-7"></i>
                    </span>
                    <span class="hide-menu">FAQ</span>
                  </a>
                </li>

                <li class="sidebar-item">
                  <a class="sidebar-link @if(str_contains(request()->path(),'manual'))active @endif" href="/manual" id="get-url" aria-expanded="false">
                    <span>
                      <i class="ph ph-file fs-7"></i>
                    </span>
                    <span class="hide-menu">マニュアル</span>
                  </a>
                </li>

            </ul>
        </nav>

        <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
          <div class="hstack gap-3">
            <div class="john-img">
              <img src="{{ getUserImage(Auth::user()->id) }}" class="rounded-circle object-fit-cover" width="40" height="40" alt="modernize-img">
            </div>
            <div class="john-title lh-1">
              <h6 class="mb-1 fs-4 fw-semibold">{{ Auth::user()->name }}</h6>
              <span class="fs-2">{!! App\Models\Admin::getAdmin(Auth::user()->id) ? App\Models\Admin::getAdmin(Auth::user()->id)->title : $yet !!}</span>
            </div>
            <form action="{{route('signout')}}" method="post">@csrf
                <button class="border-0 bg-transparent text-primary ms-auto" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
                  <i class="ph ph-power fs-4"></i>
                </button>
            </form>
          </div>
        </div>

    </div>
</aside>
@endsection