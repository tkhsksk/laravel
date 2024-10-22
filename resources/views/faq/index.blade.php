@extends('common.layout')

@section('title',       'よくある質問')
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
      <p class="mb-0 text-dark">@if($faqs->total() > 0)<span class="me-1">現在</span><span class="px-1 fs-5 fw-bolder">{{ $faqs->firstItem() }}</span> 〜 <span class="px-1 fs-5 fw-bolder">{{ $faqs->lastItem() }}</span>件目を表示<span class="d-md-inline d-none">しています</span>@endif</p>
      <h2 class="fw-bolder mb-0 fs-8 lh-base"><span class="fs-3 fw-normal me-md-3 me-2">現在</span>{{ $faqs->total() }}<span class="fs-3 fw-normal ms-md-3 ms-2">件のFAQ<span class="d-md-inline d-none">が登録されています</span></span></h2>
    </div>

    <div class="d-flex justify-content-between align-items-center gap-6 mb-9">
      <button class="btn bg-warning-subtle text-warning" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
        <i class="ph ph-funnel fw-semibold me-2"></i>フィルター検索
      </button>
      <div class="d-flex gap-6">
        <a href="/faq/edit" class="btn btn-primary d-flex align-items-center px-3 gap-6">
          <i class="ph ph-question fs-5"></i>
          <span class="d-none d-md-block font-weight-medium fs-3">FAQを追加する</span>
        </a>
      </div>
    </div>

    <div class="row justify-content-center mb-5">
      <div class="col-12">
        <div class="card">
        <ul class="list mb-0 list-group">
        @foreach($faqs as $faq)
            <a href="javascript:void(0)" class="bg-hover-light-black list-group-item getAnswer d-md-flex px-4 py-3" data-bs-toggle="modal" data-bs-target="#answerModal" data-bs-dismiss="modal" data-faq-id="{{ $faq->id }}">
              <div class="d-flex mb-md-0 mb-1">
                <div class="position-relative me-2" style="width:22px;height:22px;"><span class="bg-tinymce rounded-circle w-100 h-100 top-0 start-0 lh-1 d-flex justify-content-center align-items-center text-white small">Q</span></div>
                <div>
                  <span class="badge fw-semibold py-1 fs-2 bg-success-new-subtle text-success-new me-2">{{ App\Models\Department::find($faq->department_id) ? App\Models\Department::find($faq->department_id)->name : 'すべての部署' }}</span>
                </div>
              </div>
              <p class="mb-0 h5" style="width: calc(100% - 22px)">{{ $faq->question }}</p>
            </a>
        @endforeach
        </ul>
        </div>
      </div>
    </div>
    {{ $faqs->appends(request()->query())->links('common.pager') }}
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

              <h6 class="fw-semibold fs-3 mb-2">Questionで検索</h6>
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

              <h6 class="mt-4 fw-semibold fs-3 mb-2">公開状態</h6>
              <select class="form-select form-select-lg" id="inlineFormCustomSelect" name="status" onChange="search(this);">
                <option value="">すべて</option>
                <option value="E" @isset($status){{ $status == 'E' ? 'selected=""' :'' }} @endisset>公開</option>
                <option value="D" @isset($status){{ $status == 'D' ? 'selected=""' :'' }} @endisset>非公開</option>
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

@if(request()->input('pw-faq') && request()->input('page') == '')
<script>
  $(function(){
    const id = {{ request()->input('pw-faq') }};
    const an = $('#answerModal .modal-content');
    getFaq(id, an);
    $('#answerModal').modal('show')
  })
</script>
@endif

@endsection

@include('common.footer')