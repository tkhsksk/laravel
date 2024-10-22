@extends('common.layout')

@section('title',       'データベースの編集')
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
                  <a class="text-muted text-decoration-none" href="/database">データベース一覧</a>
                </li>
                @isset($database->id)
                <li class="breadcrumb-item">
                  <a class="text-muted text-decoration-none" href="/database/detail/{{ $database->id }}">データベースの詳細</a>
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

    <form action="{{ route('database.confirm') }}" class="h-adr" novalidate="novalidate" method="post">
    @csrf
      <div class="row justify-content-center">
        <div class="col-lg-9">
          <div class="card">
            <div class="card-body p-4">

              <h4 class="card-title fw-semibold mb-3">@yield('title')項目</h4>
              <p class="card-subtitle mb-5 lh-base">必須項目を全て入力して左下の「確認する」をクリックして下さい</p>

              <input type="hidden" name="id" value="{{ $database ? old('id',$database->id) : '' }}">

              <div class="row mb-3">
                <div class="col-md-6">

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3 w-100">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-map-pin-line text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div class=" w-100">
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}関連サーバー</h5>
                        <select class="form-select" aria-label="server_id" name="server_id">
                            <option value="">選択して下さい</option>
                            @foreach($servers as $server)
                              <option value="{{ $server->id }}" @if($database){{ old('server_id',$database->server_id) != $server->id ?: 'selected' }}@else {{ old('server_id') != $server->id ?: 'selected' }} @endif>{!! App\Models\Site::getServer($server->id) !!}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3 w-100">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-map-pin-line text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div class=" w-100">
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}ホストアドレス</h5>
                        <input type="text" class="form-control" id="host" name="host" value="{{ $database ? old('host',$database->host) : old('host') }}">
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3 w-100">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-browser text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div class=" w-100">
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}データベースURL（phpmyadmin）</h5>
                        <input type="text" class="form-control" id="phpmyadmin" name="phpmyadmin" value="{{ $database ? old('phpmyadmin',$database->phpmyadmin) : old('phpmyadmin') }}">
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3 w-100">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-toggle-left text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div class="w-100">
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}有効状態</h5>
                        <input name="status" type="checkbox" value="true" data-toggle="toggle" data-on="有効" data-off="無効" data-onstyle="success" data-off-color="default" @if($database){{ old('status',$database->status) == 'E' ? 'checked' : '' }}@else {{ !old('status') ?: 'checked' }} @endif>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-md-6">

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3 w-100">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-password text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div class="w-100">
                        <h5 class="fs-4 fw-semibold">basic認証id</h5>
                        <input type="text" class="form-control" id="basic_id" name="basic_id" value="{{ $database ? old('basic_id',$database->basic_id) : old('basic_id') }}">
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3 w-100">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-password text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div class="w-100">
                        <h5 class="fs-4 fw-semibold">basic認証pass</h5>
                        <input type="text" class="form-control" id="basic_pass" name="basic_pass" value="{{ $database ? old('basic_pass',cryptDecrypt($database->basic_pass)) : old('basic_pass') }}">
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-lock-key-open text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}dbユーザー</h5>
                        <input type="text" class="form-control" id="user" name="user" value="{{ $database ? old('user',$database->user) : old('user') }}">
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-lock-key-open text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}dbパスワード</h5>
                        <input type="text" class="form-control" id="pass" name="pass" value="{{ $database ? old('pass',\Crypt::decrypt($database->pass)) : old('pass') }}">
                      </div>
                    </div>
                  </div>

                </div>
              </div>

              <div class="p-4 rounded-2 text-bg-light">
                <label for="note" class="form-label"><i class="ph ph-list-dashes me-2"></i>データベースについてのメモ</label>
                <textarea class="form-control bg-white" name="note" rows="4">{{ $database ? old('note',$database->note) : old('note') }}</textarea>
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