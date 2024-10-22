@extends('common.layout')

@section('title',       'ユーザー情報の詳細')
@section('description', '')
@section('keywords',    '')

@include('common.head')
@include('common.header')
@include('common.aside')

@section('contents')
<script>
$(function() {
   $('.nav-pills button[data-bs-target="#pills-{{ Cookie::get('tab') }}"]').tab('show');   
});
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
                <li class="breadcrumb-item">
                  <a class="text-muted text-decoration-none" href="/admin">社員・パート一覧</a>
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
    
    <div class="row justify-content-center">
      <div class="col-lg-9">

        <div class="nav nav-pills p-3 mb-3 rounded align-items-center card flex-row" id="pills-tab" role="tablist">
          <div class="card-body p-4 d-flex flex-wrap justify-content-between">

            <div class="d-flex align-items-center gap-3">
              <img src="{{ getUserImage($user->id) }}" alt="" class="img-fluid rounded-circle object-fit-cover" style="height:40px;width:40px;">
              <div>
                <p class="mb-1">ユーザー名</p>
                <h4 class="fw-semibold mb-1 d-flex align-items-center">{{ getNamefromUserId($user->id) }}</h4>
                <span class="fs-2 d-flex align-items-center"><i class="ph ph-envelope-open text-dark fs-3 me-1"></i>{{ $user->email }}</span>
              </div>
            </div>

            <div>
              <div class="d-flex align-items-center">
                {!! getStatus('有効','無効',$admin->status) !!}
              </div>
              <p class="text-muted mb-0">登録日：{{ $admin->created_at->format('Y/n/j') }}</p>
              <p class="text-muted mb-0">更新日：{!! $admin->updated_at ? $admin->updated_at->format('Y/n/j') : $yet !!}</p>
            </div>
            
          </div>
          <a href="/user/edit/{{ $user->id }}" class="text-bg-primary fs-6 rounded-circle p-2 text-white d-inline-flex position-absolute top-0 end-0 mt-n3 me-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="編集する"><i class="ph ph-pencil-line fs-6"></i></a>

          <div class="d-flex">
            @foreach(App\Models\Admin::ADMIN_MENU_TABS as $tab => $i)
            <li class="nav-item" role="presentation">
              <button class="nav-link gap-6 note-link d-flex align-items-center justify-content-center px-3 px-md-3 me-0 me-md-2 text-body-color fs-3 
              @if($tab == Cookie::get('tab'))
              active
              @endif" id="pills-{{ $tab }}-tab" data-bs-toggle="pill" data-bs-target="#pills-{{ $tab }}" type="button" role="{{ $tab }}" aria-controls="pills-{{ $tab }}" aria-selected="true" onclick="setTabCookie(this);">
                <i class="{{ $i[1] }} fs-6"></i>
                <span class="d-none d-md-block">{{ $i[0] }}</span>
              </button>
            </li>
            @endforeach
          </div>

        </div>
        <div class="tab-content" id="pills-tabContent">
          @foreach(App\Models\Admin::ADMIN_MENU_TABS as $tab => $i)
            @include('user.detail.tabs.'.$tab, ['name' => $tab,'data' => $i])
          @endforeach
        </div>

      </div>
    </div>
    
	</div>
</div>

@if(!Cookie::get('tab'))
<script>
$(function() {
  $('#pills-admin-tab').tab('show');
});
</script>
@endif

@endsection

@include('common.footer')