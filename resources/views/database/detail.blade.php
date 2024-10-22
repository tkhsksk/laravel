@extends('common.layout')

@section('title',       'データベースの詳細')
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
                <li class="breadcrumb-item">
                  <a class="text-muted text-decoration-none" href="/database">データベース一覧</a>
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
        <div class="card position-relative">
          <a href="/database/edit/{{ $database->id }}" class="text-bg-primary fs-6 rounded-circle p-2 text-white d-inline-flex position-absolute top-0 end-0 mt-n3 me-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="編集する"><i class="ph ph-pencil-line fs-6"></i></a>
          <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between">
              <div>
                <p class="mb-1">ホストアドレス</p>
                <h4 class="fw-semibold mb-3 d-flex align-items-center text-break flex-wrap gap-1"><i class="ph ph-browsers fs-5"></i>{{ $database->host }}</h4>
              </div>
              <div>
                <div class="d-flex align-items-center">
                  <span class="{{ App\Models\Admin::ADMIN_STATUS[$database->status][1] }} p-1 rounded-circle"></span>
                  <p class="mb-0 ms-2">{{ App\Models\Admin::ADMIN_STATUS[$database->status][0] }}</p>
                </div>
                <p class="text-muted mb-0">登録日：{{ $database->created_at->format('Y/n/j') }}</p>
                <p class="text-muted">更新日：{!! $database->updated_at ? $database->updated_at->format('Y/n/j') : $yet !!}</p>
              </div>
            </div>

            <div class="p-4 rounded-2 text-bg-light mb-4 d-flex">
              <i class="ph ph-list-dashes me-2 pt-1"></i><p class="mb-0 fs-3">{!! $database->note ? nl2br($database->note) : '<span class="text-muted">サーバーメモ未登録</span>' !!}</p>
            </div>

            <div class="row mb-3">
              <div class="col-md-6 mb-3">
                <div class="ratio ratio-4x3">
                  <img src="{{ getSiteDatas($database->url)['ogpimg'] }}" class="object-fit-contain card-img" alt="">
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="d-flex align-items-center gap-3">
                    <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                      <i class="ph ph-app-window text-dark d-block fs-7" width="22" height="22"></i>
                    </div>
                    <div>
                      <h5 class="fs-4 fw-semibold">データベースURL</h5>
                      <p class="mb-0 text-break"><a href="{{ $database->phpmyadmin }}" target="_blank">{{ $database->phpmyadmin }}</a></p>
                    </div>
                  </div>
                </div>

                 <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="d-flex align-items-center gap-3">
                    <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                      <i class="ph ph-password text-dark d-block fs-7" width="22" height="22"></i>
                    </div>
                    <div>
                      <h5 class="fs-4 fw-semibold">basic認証</h5>
                      @if($database->basic_id)
                      <div class="table-responsive border rounded">
                        <table class="table mb-0">
                          <tr><td class="fw-semibold p-2 bg-info-subtle text-end w-30">user</td><td class="p-2"><span class="d-flex">{{ $database->basic_id }}<a class="ms-1 d-flex align-items-center justify-content-center" data-text="{{ $database->basic_id }}" onclick="copyText(this);" role="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="コピーする"><i class="ph ph-clipboard-text text-dark d-block fs-5" data-bs-toggle="collapse" data-bs-target="#collapseSignin" aria-expanded="false" aria-controls="collapseSignin"></i></a></span></td></tr>
                          <tr><td class="fw-semibold p-2 bg-info-subtle text-end w-30 border-0">pass</td><td class="p-2 border-0"><span class="d-flex">{{ \Crypt::decrypt($database->basic_pass) }}<a class="ms-1 d-flex align-items-center justify-content-center" data-text="{{ \Crypt::decrypt($database->basic_pass) }}" onclick="copyText(this);" role="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="コピーする"><i class="ph ph-clipboard-text text-dark d-block fs-5" data-bs-toggle="collapse" data-bs-target="#collapseSignin" aria-expanded="false" aria-controls="collapseSignin"></i></a></span></td></tr>
                        </table>
                      </div>
                      @endif
                    </div>
                  </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="d-flex align-items-center gap-3">
                    <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                      <i class="ph ph-password text-dark d-block fs-7" width="22" height="22"></i>
                    </div>
                    <div>
                      <h5 class="fs-4 fw-semibold">ログイン情報</h5>
                      @if($database->user)
                      <div class="table-responsive border rounded">
                        <table class="table mb-0">
                          <tr><td class="fw-semibold p-2 bg-info-subtle text-end">dbユーザー</td><td class="p-2"><span class="d-flex">{{ $database->user }}<a class="ms-1 d-flex align-items-center justify-content-center" data-text="{{ $database->user }}" onclick="copyText(this);" role="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="コピーする"><i class="ph ph-clipboard-text text-dark d-block fs-5" data-bs-toggle="collapse" data-bs-target="#collapseSignin" aria-expanded="false" aria-controls="collapseSignin"></i></a></span></td></tr>
                          <tr><td class="fw-semibold p-2 bg-info-subtle text-end border-0">dbパスワード</td><td class="p-2 border-0"><span class="d-flex">{{ \Crypt::decrypt($database->pass) }}<a class="ms-1 d-flex align-items-center justify-content-center" data-text="{{ \Crypt::decrypt($database->pass) }}" onclick="copyText(this);" role="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="コピーする"><i class="ph ph-clipboard-text text-dark d-block fs-5" data-bs-toggle="collapse" data-bs-target="#collapseSignin" aria-expanded="false" aria-controls="collapseSignin"></i></a></span></td></tr>
                        </table>
                      </div>
                      @endif
                    </div>
                  </div>
                </div>

                <div class="d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center gap-3">
                    <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                      <i class="ph ph-envelope-simple-open text-dark d-block fs-7" width="22" height="22"></i>
                    </div>
                    <div>
                      <h5 class="fs-4 fw-semibold">関連サーバー</h5>
                      <p class="mb-0 text-break"><a href="/server/detail/{{ $database->server_id }}">{!! App\Models\Site::getServer($database->server_id) !!}</a></p>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
	</div>
</div>
@endsection

@include('common.footer')