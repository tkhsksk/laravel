@extends('common.layout')

@section('title',       'みんなのマニュアル一覧')
@section('description', '')
@section('keywords',    '')

@include('common.head')
@include('common.header')
@include('common.aside')

@section('contents')
<script>
  function favBtn(el) {
      $(el).toggleClass('liked');
      favorite = $(el).attr('favorite-id');
      content  = $(el).attr('content-id');
      $.ajax({
          url: '{{ route('manual.favorite') }}',
          type: 'get',
          data: {
            val  : favorite,
            cont : content
          },
          datatype: 'json',
      })
      .done((data) => {
        console.log(data)
        if(data.id){
          $(el).attr('favorite-id',data.id);
        } else {
          $(el).attr('favorite-id','');
        }
      })
      .fail((data) => {
        console.log('fail')
      });
  }
</script>
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
      <p class="mb-0 text-dark">@if($manuals->total() > 0)<span class="me-1">現在</span><span class="px-1 fs-5 fw-bolder">{{ $manuals->firstItem() }}</span> 〜 <span class="px-1 fs-5 fw-bolder">{{ $manuals->lastItem() }}</span>件を表示<span class="d-md-inline d-none">しています</span>@endif</p>
      <h2 class="fw-bolder mb-0 fs-8 lh-base"><span class="fs-3 fw-normal me-md-3 me-2">現在</span>{{ $manuals->total() }}<span class="fs-3 fw-normal ms-md-3 ms-2">件のマニュアル<span class="d-md-inline d-none">が登録されています</span></span></h2>
    </div>

    <div class="d-flex justify-content-between align-items-center gap-6 mb-9">
      <button class="btn bg-warning-subtle text-warning" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
        <i class="ph ph-funnel fw-semibold me-2"></i>フィルター検索
      </button>
      <div class="d-flex gap-6">
        <a href="/manual/edit" class="btn btn-primary d-flex align-items-center px-3 gap-6">
          <i class="ph ph-plus fs-5"></i>
          <span class="d-none d-md-block font-weight-medium fs-3">マニュアルを追加する</span>
        </a>
      </div>
    </div>

    <div class="row note-has-grid">

      @foreach($manuals as $manual)
      <div class="col-md-6 col-lg-3">
        <div class="card rounded-2 overflow-hidden hover-img">
          <div class="row">
            <div class="position-relative col-md-12 col-6">
              <a href="/manual/detail/{{ $manual->id }}" class="bg-body-secondary d-block h-100">
                @if(getFirstImage($manual->note))
                <img src="@asset({{getFirstImage($manual->note)}})" class="card-img-top rounded-0 object-fit-cover" style="max-height: 220px;">
                @else
                <img src="@asset('/thumb/no-bg.jpg')" class="card-img-top rounded-0 object-fit-cover" style="max-height: 220px;">
                @endif
              </a>
              <span class="d-md-block d-none badge text-bg-light fs-2 rounded-4 lh-sm mb-9 me-9 py-1 px-2 fw-semibold position-absolute bottom-0 end-0 text-wrap">およそ{{ getReadTime($manual->note) }}で読めます</span>
              <img src="{{ getUserImage($manual->register_id) }}" alt="" class="img-fluid rounded-circle position-absolute bottom-0 start-0 mb-md-n9 mb-1 ms-md-9 ms-3 object-fit-cover" style="width:40px;height: 40px" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="登録者：{{ getNamefromUserId($manual->register_id,'U') }}">
            </div>

            <div class="card-body p-4 ps-md-4 ps-0 col-md-12 col-6">
              <span class="d-md-none d-block badge text-bg-light fs-2 rounded-4 lh-sm mb-3 py-1 px-2 fw-semibold end-0 text-wrap">およそ{{ getReadTime($manual->note) }}で読めます</span>
              <h3 class="d-block mt-md-2 mb-md-3 mb-0 fs-5 text-dark fw-semibold lh-sm"><a href="/manual/detail/{{ $manual->id }}">{{ $manual->id }}｜{{ $manual->title }}</a><a href="/manual/edit/{{ $manual->id }}" class="d-inline-block ms-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="編集する"><i class="ph ph-pencil-line fs-5"></i></a></h3>
              <div class="d-flex align-items-center gap-2 flex-wrap justify-content-md-between justify-content-end">
                <button type="button" class="likeButton fs-2 @if(isFavorite('M', $manual->id))liked @endif" onclick="favBtn(this);" favorite-id="{{ isFavorite('M', $manual->id) }}" content-id="{{ $manual->id }}">
                  <svg class="likeButton__icon me-md-1 me-0" viewBox="0 0 100 100"><path d="M91.6 13A28.7 28.7 0 0 0 51 13l-1 1-1-1A28.7 28.7 0 0 0 8.4 53.8l1 1L50 95.3l40.5-40.6 1-1a28.6 28.6 0 0 0 0-40.6z"/></svg>
                 <span class="d-md-inline d-none">ブックマーク</span>
                </button>
                <div class="d-flex align-items-center fs-2 ms-auto">
                  <i class="ph ph-calendar text-dark me-1"></i>{{ $manual->created_at->isoFormat('YYYY年M月D日(ddd)') }}
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      @endforeach

    </div>
    {{ $manuals->appends(request()->query())->links('common.pager') }}

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

              <h6 class="fw-semibold fs-3 mb-2">タイトルで検索</h6>
              <div class="input-group">
                <input type="text" name="keyword" class="form-control form-control-lg" value="{{ $keyword }}">
                <button class="btn btn-light rounded-end border" type="button" aria-label="" onclick="delInput(this);">
                  <i class="ph ph-x"></i>
                </button>
              </div>

              <h6 class="mt-4 fw-semibold fs-3 mb-2">登録ユーザー</h6>
              <select class="form-select form-select-lg" name="register_id">
                <option value="">全ての登録ユーザー</option>
                @foreach($admins as $admin)
                <option value="{{ $admin->id }}" {{ $register_id_req == $admin->id ? 'selected=""' :'' }}>{{ getNamefromUserId($admin->id,'U') }}</option>
                @endforeach
              </select>

              <h6 class="mt-4 fw-semibold fs-3 mb-2">対象部署</h6>
              <select class="form-select form-select-lg" name="department_id">
                <option value="">全ての部署</option>
                @foreach(App\Models\Department::all() as $department)
                <option value="{{ $department->id }}" {{ $department_id == $department->id ? 'selected=""' :'' }}>{{ App\Models\Department::find($department->id)->name }}</option>
                @endforeach
              </select>

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