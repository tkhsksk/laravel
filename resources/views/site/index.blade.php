@extends('common.layout')

@section('title',       'サイト一覧')
@section('description', '')
@section('keywords',    '')

@include('common.head')
@include('common.header')
@include('common.aside')

@section('contents')

@foreach($sites as $site)
<script>
  $(function loadUrlData() {
    $(window).on('load',function(){
      $.ajax({
          url: '{{ route('site.ajax') }}',
          type: 'get',
          data: {val : {{ $site->id }}},
          datatype: 'json',
      })
      .done((data) => {
          console.log(data);
      })
      .fail((data) => {
          console.log('失敗');
      });
    });
  });
</script>
@endforeach

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
        <p class="mb-0 text-dark">@if($sites->total() > 0)<span class="me-1">現在</span><span class="px-1 fs-5 fw-bolder">{{ $sites->firstItem() }}</span> 〜 <span class="px-1 fs-5 fw-bolder">{{ $sites->lastItem() }}</span>件を表示<span class="d-md-inline d-none">しています</span>@endif</p>
        <h2 class="fw-bolder mb-0 fs-8 lh-base"><span class="fs-3 fw-normal me-md-3 me-2">現在</span>{{ $sites->total() }}<span class="fs-3 fw-normal ms-md-3 ms-2">件のサイト<span class="d-md-inline d-none">が登録されています</span></span></h2>
      </div>

      <div class="card p-0">
        <div class="card-body p-3">
          <div class="d-flex justify-content-between align-items-center gap-6 mb-9">
            <button class="btn bg-warning-subtle text-warning" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
              <i class="ph ph-funnel fw-semibold me-2"></i>フィルター検索
            </button>
            <a href="/site/edit" class="btn btn-primary d-flex align-items-center px-3 gap-6">
              <i class="ph ph-browsers fs-5"></i>
              <span class="d-none d-md-block font-weight-medium fs-3">サイトを追加する</span>
            </a>
          </div>
          <div class="table-responsive rounded">
            <table class="table table-striped text-nowrap align-middle dataTable">
              <thead>
                <tr>
                  <th scope="col">サイト名</th>
                  <th scope="col">管理画面</th>
                  <th scope="col">basic認証</th>
                  <th scope="col">登録日</th>
                </tr>
              </thead>
                <tbody>

                @foreach($sites as $site)
                <tr class="odd">
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="ms-2">
                        <h6 class="fw-semibold mb-1 fs-3"><a href="/site/detail/{{ $site->id }}">{{ Str::limit($site->name, 32) }}</a><a class="ms-2" href="/site/edit/{{ $site->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="編集する"><i class="fs-4 ph ph-pencil-line"></i></a></h6>
                        <p class="fs-2 mb-0 text-muted"><a href="{{ $site->url }}" target="_blank">{{ $site->url }}<i class="ph ph-link-simple ms-2"></i></a></p>
                      </div>
                    </div>
                  </td>

                  <td>
                    @if($site->url_admin)
                    <a href="{{ $site->url_admin }}" target="_blank">
                      <div class="btn bg-transparent">
                          <i class="ph ph-browsers fs-6"></i>
                      </div>
                    </a>
                    @else
                    <p class="mb-0">なし</p>
                    @endif
                  </td>

                  <td>
                    @if($site->basic_id)
                      <p class="d-flex align-items-center mb-0 lh-1 mb-1 small">{{ $site->basic_id }}<a class="ms-1 text-bg-light d-flex align-items-center justify-content-center" data-text="{{ $site->basic_id }}" onclick="copyText(this);" role="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="コピーする"><i class="ph ph-clipboard-text text-dark d-block fs-5" data-bs-toggle="collapse" data-bs-target="#collapseSignin" aria-expanded="false" aria-controls="collapseSignin"></i></a></p>
                      <p class="d-flex align-items-center mb-0 lh-1 small">{{ cryptDecrypt($site->basic_pass) }}<a class="ms-1 text-bg-light d-flex align-items-center justify-content-center" data-text="{{ cryptDecrypt($site->basic_pass) }}" onclick="copyText(this);" role="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="コピーする"><i class="ph ph-clipboard-text text-dark d-block fs-5" data-bs-toggle="collapse" data-bs-target="#collapseSignin" aria-expanded="false" aria-controls="collapseSignin"></i></a></p>
                    @endif
                  </td>

                  <td>
                    <p class="mb-0">{{ $site->created_at }}</p>
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
              <p class="mb-0 fs-2 me-8 me-sm-9">{{ $sites->firstItem() }}–{{ $sites->lastItem() }} of {{ $sites->total() }}</p>
              {{ $sites->appends(request()->query())->links('common.pager') }}
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

              <h6 class="fw-semibold fs-3 mb-2">URL・サイト名</h6>
              <div class="input-group">
                <input type="text" name="keyword" class="form-control form-control-lg" value="{{ $keyword }}">
                <button class="btn btn-light rounded-end border" type="button" aria-label="" onclick="delInput(this);">
                  <i class="ph ph-x"></i>
                </button>
              </div>

              <div class="mt-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-semibold fs-3 mb-0">無効サイトも表示する</h6>
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