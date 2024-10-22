@extends('common.layout')

@section('title',       'オフィス一覧')
@section('description', '')
@section('keywords',    '')

@include('common.head')
@include('common.header')
@include('common.aside')

@section('contents')
<div class="body-wrapper">
	<div class="container-fluid">

    @include('common.alert')

		<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
      <div class="card-body px-4 py-3">
        <div class="row align-items-center">
          <div class="col-9">
            <h4 class="fw-semibold mb-8">@yield('title')</h4>
            <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '>'">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a class="text-muted text-decoration-none" href="/">トップ</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">@yield('title')</li>
              </ol>
            </nav>
          </div>
          <div class="col-3">
            <div class="text-center mb-n5">
              <img src="@asset('/image/titleBg.svg')" alt="" class="img-fluid mb-n3 ps-md-4">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-between mb-2 align-items-end flex-wrap">
      <p class="mb-0 text-dark">@if($locations->total() > 0)<span class="me-1">現在</span><span class="px-1 fs-5 fw-bolder">{{ $locations->firstItem() }}</span> 〜 <span class="px-1 fs-5 fw-bolder">{{ $locations->lastItem() }}</span>件を表示<span class="d-md-inline d-none">しています</span>@endif</p>
      <h2 class="fw-bolder mb-0 fs-8 lh-base"><span class="fs-3 fw-normal me-md-3 me-2">現在</span>{{ $locations->total() }}<span class="fs-3 fw-normal ms-md-3 ms-2">件のオフィス<span class="d-md-inline d-none">が登録されています</span></span></h2>
    </div>

    <div class="location-list">
      <div class="card p-0">
        <div class="card-body p-3">
          <div class="d-flex justify-content-between align-items-center gap-6 mb-9">
            <button class="btn bg-warning-subtle text-warning" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
              <i class="ph ph-funnel fw-semibold me-2"></i>フィルター検索
            </button>
            <a href="/location/edit" class="btn btn-primary d-flex align-items-center px-3 gap-6">
              <i class="ph ph-building-office fs-5"></i>
              <span class="d-none d-md-block font-weight-medium fs-3">オフィスを追加する</span>
            </a>
          </div>
          <div class="table-responsive rounded">
            <table class="table table-striped text-nowrap align-middle dataTable">
              <thead>

                <tr>
                  <th scope="col">名称</th>
                  <th scope="col">最寄駅</th>
                  <th scope="col">入居日</th>
                  <th scope="col">利用者</th>
                  <th scope="col">ステータス</th>
                  <th scope="col">電話番号</th>
                </tr>
              </thead>
              <tbody>

                @foreach($locations as $location)
                <tr class="odd">
                  <td class="sorting_1">
                    <div class="d-flex align-items-center">
                      <div style="width: 46px;height: 46px;" class="rounded-circle object-fit-cover hover-img position-relative overflow-hidden">
                        <iframe src="https://www.google.com/maps?q={{ $location->address }}&output=embed&z=5" frameborder="0" style="border:0;" allowfullscreen class="position-absolute top-50 start-50 translate-middle"></iframe>
                        <a style="width: 39px;height: 39px;" class="d-block position-absolute" href="/location/detail/{{ $location->id }}"></a>
                      </div>
                      <div class="ms-3">
                        <h6 class="fw-semibold mb-1 fs-4"><a href="/location/detail/{{ $location->id }}">{{ $location->name }}</a></h6>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="mb-0 d-flex align-items-center flex-wrap fs-3 text-muted"><i class="ph ph-train fs-4 me-1"></i>{{ $location->nearest_station }}駅</p>
                  </td>
                  <td>
                    <p class="mb-0">{{ $location->contracted_at ? $location->contracted_at->format('Y/m/d') : '未登録' }}</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      @foreach($location->admin as $admin)
                        @if($loop->iteration == 4)                     
                         @break                     
                        @endif 
                      @if($admin)
                      <a href="/user/detail/{{ $admin->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ getNamefromUserId($admin->user->id) }}">
                        <img src="{{ getUserImage($admin->user_id) }}" class="rounded-circle me-n2 card-hover border border-2 border-white object-fit-cover" width="39" height="39">
                      </a>
                      @endif
                      @endforeach
                    </div>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <span class="{{ App\Models\Location::LOCATION_STATUS[$location->status][1] }} p-1 rounded-circle"></span>
                      <p class="mb-0 ms-2">{{ App\Models\Location::LOCATION_STATUS[$location->status][0] }}</p>
                    </div>
                  </td>
                  <td>
                    <h6 class="mb-0 fs-3">
                      {{ $location->phone ? $location->phone : '未登録' }}
                    </h6>
                  </td>
                </tr>
                @endforeach
                
              </tbody>
            </table>
            <div class="d-flex align-items-center justify-content-end py-1">
              <p class="mb-0 fs-2 d-none">表示件数：</p>
              <select class="form-select w-auto ms-0 ms-sm-2 me-8 me-sm-4 py-1 pe-7 ps-2 border-0 d-none" aria-label="Default select example">
                <option selected="">5</option>
                <option value="1">10</option>
                <option value="2">25</option>
              </select>
              <p class="mb-0 fs-2 me-8 me-sm-9">{{ $locations->firstItem() }}–{{ $locations->lastItem() }} of {{ $locations->total() }}</p>
              {{ $locations->appends(request()->query())->links('common.pager') }}
            </div>
          </div>

        </div>
      </div>
    </div>
	</div>
</div>

<div class="offcanvas customizer offcanvas-start text-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <form method="get">
  <div class="d-flex align-items-center justify-content-between p-3 border-bottom">

    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    <div class="d-flex align-items-center gap-7">
      <h4 class="offcanvas-title fw-semibold fs-4" id="offcanvasExampleLabel">
        <i class="ph ph-funnel fw-semibold me-2"></i>フィルター検索
      </h4>
      <button type="submit" class="btn btn-primary">検索</button>
    </div>
  </div>
  <div class="offcanvas-body h-n80 simplebar-scrollable-y" data-simplebar="init">
    <div class="simplebar-wrapper">
      <div class="simplebar-height-auto-observer-wrapper">
        <div class="simplebar-height-auto-observer"></div>
      </div>
      <div class="simplebar-mask">
        <div class="simplebar-offset">
          <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content">
            <div class="simplebar-content">

              <h6 class="fw-semibold fs-3 mb-2">名称</h6>
              <div class="input-group">
              <input type="text" name="keyword" class="form-control form-control-lg" value="{{ $keyword }}">
                <button class="btn btn-light rounded-end border" type="button" aria-label="" onclick="delInput(this);">
                  <i class="ph ph-x"></i>
                </button>
              </div>

              <div class="mt-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-semibold fs-3 mb-0">入居中以外も表示する</h6>
                <div class="form-check form-switch mb-0">
                  <input class="form-check-input" type="checkbox" name="status" role="switch" id="flexSwitchCheckChecked" value="1" @isset($status)checked="" @endisset onChange="search(this);">
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="simplebar-placeholder"></div>
    </div>
    <div class="simplebar-track simplebar-horizontal">
      <div class="simplebar-scrollbar"></div>
    </div>
    <div class="simplebar-track simplebar-vertical">
      <div class="simplebar-scrollbar"></div>
    </div>
  </div>
  </form>
</div>
@endsection

@include('common.footer')