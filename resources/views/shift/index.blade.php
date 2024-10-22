@extends('common.layout')

@section('title',       'シフト一覧')
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
      <p class="mb-0 text-dark">@if($shifts->total() > 0)<span class="me-1">現在</span><span class="px-1 fs-5 fw-bolder">{{ $shifts->firstItem() }}</span> 〜 <span class="px-1 fs-5 fw-bolder">{{ $shifts->lastItem() }}</span>件を表示<span class="d-md-inline d-none">しています</span>@endif</p>
      <h2 class="fw-bolder mb-0 fs-8 lh-base"><span class="fs-3 fw-normal me-md-3 me-2">現在</span>{{ $shifts->total() }}<span class="fs-3 fw-normal ms-md-3 ms-2">件のシフト<span class="d-md-inline d-none">が登録されています</span></span></h2>
    </div>

    <div class="location-list">
      <div class="card p-0">
        <div class="card-body p-3">
          <div class="d-flex justify-content-between align-items-center gap-6 mb-9">
            <button class="btn bg-warning-subtle text-warning" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
              <i class="ph ph-funnel fw-semibold me-2"></i>フィルター検索
            </button>
            <a class="fs-6 text-muted" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Filter list"><i class="ti ti-filter"></i></a>
            <a href="/shift/admin/edit" class="btn btn-primary d-flex align-items-center px-3 gap-6">
              <i class="ph ph-clock-user fs-5"></i>
              <span class="d-none d-md-block font-weight-medium fs-3">シフトを登録する</span>
            </a>
          </div>
          <div class="table-responsive rounded">
            <table class="table table-striped text-nowrap align-middle dataTable">
              <thead>

                <tr class="odd">
                  <th scope="col">希望日時</th>
                  <th scope="col">シフト希望者</th>
                  <th scope="col">シフト承認者</th>
                  <th scope="col">ステータス</th>
                  <th scope="col">有給希望</th>
                  <th scope="col">申請日</th>
                  <th scope="col">希望者連絡事項</th>
                </tr>
              </thead>
              <tbody>

                @foreach($shifts as $shift)
                 <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="">
                        <h6 class="fw-semibold mb-1 fs-5"><a href="/shift/detail/{{ $shift->id }}">{{ $shift->preferred_date->isoFormat('Y年M月D日 (ddd)') }}</a></h6>
                        <div class="d-flex align-items-center"><i class="ph ph-clock fs-5 me-1"></i>{{ getShiftTime($shift->id) }}</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="mb-0 d-flex align-items-center">
                      <a href="/user/detail/{{ $shift->register_id }}">
                        <img src="{{ getUserImage($shift->register_id) }}" class="rounded-circle me-2 card-hover border border-2 border-white object-fit-cover" width="39" height="39">
                      {{ getNamefromUserId($shift->register_id,'A') }}</a>
                    </div>
                  </td>
                  <td>
                    <div class="mb-0 d-flex align-items-center">
                      <a href="/user/detail/{{ $shift->charger_id }}">
                        <img src="{{ getUserImage($shift->charger_id) }}" class="rounded-circle me-2 card-hover border border-2 border-white object-fit-cover" width="39" height="39">
                      {{ getNamefromUserId($shift->charger_id,'A') }}</a>
                    </div>
                  </td>
                  <td>
                    <p class="mb-0"><span class="badge fw-semibold py-1 fs-2 bg-attention-{{ App\Models\Shift::STATUS[$shift->status][3] }}">{{ App\Models\Shift::STATUS[$shift->status][0] }}</span></p>
                  </td>
                  <td>
                    @if($shift->holiday == 'E')
                    <i class="ph ph-check-circle fs-7 me-2 text-primary"></i>
                    @endif
                  </td>
                  <td>
                    <h6 class="mb-0 fs-3">
                      {{ $shift->created_at->isoFormat('Y年M月D日(ddd)') }}
                    </h6>
                  </td>
                  <td>
                    {{ $shift->note }}
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
              <p class="mb-0 fs-2 me-8 me-sm-9">{{ $shifts->firstItem() }}–{{ $shifts->lastItem() }} of {{ $shifts->total() }}</p>
              {{ $shifts->appends(request()->query())->links('common.pager') }}
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

              <h6 class="fw-semibold fs-3 mb-2">ステータス</h6>
              <select class="form-select form-select-lg" name="status">
                  <option value="">全てのステータス</option>
                  @foreach(App\Models\Shift::STATUS as $in => $status)
                  <option value="{{ $in }}" @isset($request->status){{ $request->status == $in ? 'selected=""' :'' }} @endisset>{{ $status[0] }}</option>
                  @endforeach
              </select>

              <div class="mt-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-semibold fs-3 mb-0">有給希望のみ表示する</h6>
                <div class="form-check form-switch mb-0">
                  <input class="form-check-input" type="checkbox" name="holiday" role="switch" id="flexSwitchCheckChecked" value="E" @isset($request->holiday)checked="" @endisset>
                </div>
              </div>

              <h6 class="mt-4 fw-semibold fs-3 mb-2">希望日時</h6>

              <div class="input-group mb-1">
                <input type="date" id="preferred_date_st" name="preferred_date_st" class="form-control form-control-lg" value="@isset($request->preferred_date_st){{ $request->preferred_date_st }}@endisset">
                <button class="btn bg-primary-subtle text-primary" type="button" aria-label="{{ now()->format('Y-m-d') }}" onclick="inputToday(this);">
                  本日
                </button>
                <button class="btn btn-light rounded-end" type="button" aria-label="" onclick="delInput(this);">
                  <i class="ph ph-x"></i>
                </button>
              </div>

              <p class="text-center fs-4 mb-1">から</p>

              <div class="input-group">
                <input type="date" id="preferred_date_en" name="preferred_date_en" class="form-control form-control-lg" value="@isset($request->preferred_date_en){{ $request->preferred_date_en }}@endisset">
                <button class="btn bg-primary-subtle text-primary" type="button" aria-label="{{ now()->format('Y-m-d') }}" onclick="inputToday(this);">
                  本日
                </button>
                <button class="btn btn-light rounded-end" type="button" aria-label="" onclick="delInput(this);">
                  <i class="ph ph-x"></i>
                </button>
              </div>

              <h6 class="mt-4 fw-semibold fs-3 mb-2">シフト希望者</h6>
              <select class="form-select form-select-lg" name="register_id">
                  <option value="">全てのユーザー</option>
                  @foreach($admins as $admin)
                  <option value="{{ $admin->id }}" @isset($request->register_id){{ $request->register_id == $admin->id ? 'selected=""' :'' }} @endisset>{{ getNamefromUserId($admin->id,'A') }}</option>
                  @endforeach
              </select>

              <h6 class="mt-3 fw-semibold fs-3 mb-2">シフト承認者</h6>
              <select class="form-select form-select-lg" name="charger_id">
                  <option value="">全てのユーザー</option>
                  @foreach($admins as $admin)
                  <option value="{{ $admin->id }}" @isset($request->charger_id){{ $request->charger_id == $admin->id ? 'selected=""' :'' }} @endisset>{{ getNamefromUserId($admin->id,'A') }}</option>
                  @endforeach
              </select>

              <h6 class="mt-4 fw-semibold fs-3 mb-2">申請日</h6>

              <div class="input-group mb-1">
                <input type="date" id="created_at_st" name="created_at_st" class="form-control form-control-lg" value="@isset($request->created_at_st){{ $request->created_at_st }}@endisset">
                <button class="btn bg-primary-subtle text-primary" type="button" aria-label="{{ now()->format('Y-m-d') }}" onclick="inputToday(this);">
                  本日
                </button>
                <button class="btn btn-light rounded-end" type="button" aria-label="" onclick="delInput(this);">
                  <i class="ph ph-x"></i>
                </button>
              </div>

              <p class="text-center fs-4 mb-1">から</p>

              <div class="input-group">
                <input type="date" id="created_at_en" name="created_at_en" class="form-control form-control-lg" value="@isset($request->created_at_en){{ $request->created_at_en }}@endisset">
                <button class="btn bg-primary-subtle text-primary" type="button" aria-label="{{ now()->format('Y-m-d') }}" onclick="inputToday(this);">
                  本日
                </button>
                <button class="btn btn-light rounded-end" type="button" aria-label="" onclick="delInput(this);">
                  <i class="ph ph-x"></i>
                </button>
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