@extends('common.layout')

@section('title',       'サイトの編集')
@section('description', '')
@section('keywords',    '')

@include('common.head')
@include('common.header')
@include('common.aside')

@section('contents')
<link href="@asset('/css/bootstrap4-toggle.min.css')" rel="stylesheet">
<script src="@asset('/js/bootstrap4-toggle.min.js')"></script>

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
                  <a class="text-muted text-decoration-none" href="/site">サイト一覧</a>
                </li>
                @isset($site->id)
                <li class="breadcrumb-item">
                  <a class="text-muted text-decoration-none" href="/site/detail/{{ $site->id }}">オフィスの詳細</a>
                </li>
                @endisset
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

    <form action="{{ route('site.confirm') }}" class="h-adr" novalidate="novalidate" method="post">
    @csrf
      <div class="row justify-content-center">
        <div class="col-lg-9">
          <div class="card">
            <div class="card-body p-4">

              <h4 class="card-title fw-semibold mb-3">オフィス編集項目</h4>
              <p class="card-subtitle mb-5 lh-base">必須項目を全て入力して左下の「確認する」をクリックして下さい</p>

              <input type="hidden" name="id" value="{{ $site ? old('id',$site->id) : '' }}">
              <input type="hidden" name="register_id" value="{{ Auth::user()->id }}">

              <div class="row mb-3">
                <div class="col-md-6">

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3 w-100">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-map-pin-line text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div class=" w-100">
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}サイトURL</h5>
                        <input type="text" class="form-control" id="url" name="url" value="{{ $site ? old('url',$site->url) : old('url') }}">
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3 w-100">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-browser text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div class=" w-100">
                        <h5 class="fs-4 fw-semibold">サイト名</h5>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $site ? old('name',$site->name) : old('name') }}">
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3 w-100">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-toggle-left text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div class="row w-100">
                        <div class="col-md-6">
                          <h5 class="fs-4 fw-semibold">{!! $required_badge !!}有効状態</h5>
                          <input name="status" type="checkbox" value="true" data-toggle="toggle" data-on="有効" data-off="無効" data-onstyle="success" data-off-color="default" @if($site){{ old('status',$site->status) == 'E' ? 'checked' : '' }}@else {{ !old('status') ?: 'checked' }} @endif>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-md-6">
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-password text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">basic認証id</h5>
                        <input type="text" class="form-control" id="basic_id" name="basic_id" value="{{ $site ? old('basic_id',$site->basic_id) : old('basic_id') }}">
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-password text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">basic認証pass</h5>
                        <input type="text" class="form-control" id="basic_pass" name="basic_pass" value="{{ $site ? old('basic_pass',cryptDecrypt($site->basic_pass)) : old('basic_pass') }}">
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3 w-100">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-browsers text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div class="w-100">
                        <h5 class="fs-4 fw-semibold">サイト管理画面URL</h5>
                        <input type="text" class="form-control" id="url_admin" name="url_admin" value="{{ $site ? old('url_admin',$site->url_admin) : old('url_admin') }}">
                      </div>
                    </div>
                  </div>

                </div>
              </div>

              <div class="row justify-content-center">

                <div class="col-md-6 mb-4">
                  <div class="connect-sorting connect-sorting-todo">
                    <div class="task-container-header">
                      <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="Todo">各管理サイトについて</h6>
                    </div>
                    <div class="connect-sorting-content ui-sortable" data-sortable="true">
                      <div data-draggable="true" class="card img-task ui-sortable-handle">
                        <div class="card-body">
                          <div class="task-header">
                              <h5 class="fw-semibold d-flex align-items-center"><i class="ph ph-hard-drive me-2"></i>サーバー管理</h5>
                          </div>
                          <select class="form-select" aria-label="server_id" name="server_id">
                              <option value="">選択して下さい</option>
                            @foreach($servers as $server)
                              <option value="{{ $server->id }}" @if($site){{ old('server_id',$site->server_id) != $server->id ?: 'selected' }}@else {{ old('server_id') != $server->id ?: 'selected' }} @endif>{!! App\Models\Site::getServer($server->id) !!}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div data-draggable="true" class="card img-task ui-sortable-handle">
                        <div class="card-body">
                          <div class="task-header">
                              <h5 class="fw-semibold d-flex align-items-center"><i class="ph ph-database me-2"></i>db管理</h5>
                          </div>
                          <select class="form-select" aria-label="db_id" name="db_id">
                              <option value="">選択して下さい</option>
                            @foreach($dbs as $db)
                              <option value="{{ $db->id }}" @if($site){{ old('db_id',$site->db_id) != $db->id ?: 'selected' }}@else {{ old('db_id') != $db->id ?: 'selected' }} @endif>{!! App\Models\Site::getDatabase($db->id) !!}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div data-draggable="true" class="card img-task ui-sortable-handle">
                        <div class="card-body">
                          <div class="task-header">
                              <h5 class="fw-semibold"><i class="ph ph-browsers me-2"></i>ドメイン管理サイト</h5>
                          </div>
                          <select class="form-select" aria-label="domain_site_id" name="domain_site_id">
                              <option value="">選択して下さい</option>
                            @foreach($dsites as $dsite)
                              <option value="{{ $dsite->id }}" @if($site){{ old('domain_site_id',$site->domain_site_id) != $dsite->id ?: 'selected' }}@else {{ old('domain_site_id') != $dsite->id ?: 'selected' }} @endif>{!! App\Models\Site::getSite($dsite->id) !!}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                    </div>

                  </div>
                </div>

              </div>

              <div class="p-4 rounded-2 text-bg-light mb-3">
                <label for="git" class="form-label"><i class="ph ph-github-logo me-2"></i>git operation list</label>
                <textarea class="form-control bg-white" name="git" rows="6">{{ $site ? old('git',$site->git) : old('git') }}</textarea>
              </div>

              <div class="p-4 rounded-2 text-bg-light">
                <label for="note" class="form-label"><i class="ph ph-list-dashes me-2"></i>サイトについてのメモ</label>
                <textarea class="form-control bg-white" name="note" rows="8">{{ $site ? old('note',$site->note) : old('note') }}</textarea>
              </div>

              <div class="d-flex align-items-center justify-content-end mt-4 gap-6">
                <button onclick="submitButton(this);" class="btn btn-primary"><i class="ph ph-check fs-5 me-2"></i>
                  確認する</button>
                <button class="btn bg-danger-subtle text-danger" onClick="history.back()" type="button"><i class="ph ph-arrow-u-up-left fs-5 me-2"></i>
                  戻る</button>
              </div>

            </div>
          </div>
        </div>
      </div>
    </form>
    
	</div>
</div>
@endsection

@include('common.footer')