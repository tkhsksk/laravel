@extends('common.layout')

@section('title',       'サーバー情報の確認')
@section('description', '')
@section('keywords',    '')

@include('common.head')
@include('common.header')
@include('common.aside')

@section('contents')
<div class="body-wrapper">
	<div class="container-fluid">

    @if(session('flash.failed') or $errors->any())
    <div class="alert customize-alert alert-dismissible alert-light-danger bg-danger-subtle text-danger fade show remove-close-icon" role="alert">
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        {{ session('flash.failed') }}
        @foreach ($errors->all() as $error)
        <div class="d-flex align-items-center me-3 me-md-0 fs-4"><i class="fa-solid fa-check fs-3 me-2 text-danger"></i>{{ $error }}</div>
        @endforeach
    </div>
    @endif

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
                  <a class="text-muted text-decoration-none" href="/server">サーバー一覧</a>
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
        <div class="card">
          <div class="card-header bg-attention-3">
            <p class="mb-0 d-flex h4 text-white align-items-center flex-wrap justify-content-center"><img src="@asset('/thumb/cry.svg')" style="max-width: 58px;" class="d-block me-2 mb-1">まだ登録は完了していません！右下の登録ボタンをクリックしてください！</p>
          </div>
          <div class="card-body">
            <h4 class="card-title fw-semibold mb-3">入力内容の確認</h4>
            <p class="card-subtitle mb-5 lh-base">入力内容を確認して右下の「登録する」をクリックして下さい</p>
            <form class="form-horizontal r-separator" action="{{ route('server.store') }}" novalidate="novalidate" method="post">
              @csrf
              <input type="hidden" name="id" value="@isset($inputs['id']){{ $inputs['id'] }}@endisset">

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-3 text-end control-label col-form-label">サーバーURL</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['url'] }}</p>
                    <input type="hidden" name="url" value="{{ $inputs['url'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-3 text-end control-label col-form-label">サーバー名称</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['name']?$inputs['name']:getSiteDatas($inputs['url'])['title'] }}</p>
                    <input type="hidden" name="name" value="{{ $inputs['name']?$inputs['name']:getSiteDatas($inputs['url'])['title'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-3 text-end control-label col-form-label">サーバープラン</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['plan'] }}</p>
                    <input type="hidden" name="plan" value="{{ $inputs['plan'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-md-3 text-end control-label col-form-label">有効状態</label>
                  <div class="col-md-3 border-start pb-2 pt-2 border-end">
                    <p class="mb-0">@isset($inputs['status']) 有効 @else 無効 @endisset</p>
                    <input type="hidden" name="status" value="@isset($inputs['status']) E @else D @endisset">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-md-3 text-end control-label col-form-label">ログインid</label>
                  <div class="col-md-3 border-start pb-2 pt-2 border-end">
                    <p class="mb-0">{{ $inputs['login_id'] }}</p>
                    <input type="hidden" name="login_id" value="{{ $inputs['login_id'] }}">
                  </div>
                  <label for="inputText1" class="col-md-3 text-end control-label col-form-label">ログインpass</label>
                  <div class="col-md-3 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['login_pass'] }}</p>
                    <input type="hidden" name="login_pass" value="{{ \Crypt::encrypt($inputs['login_pass']) }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-5">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-md-3 text-end control-label col-form-label">メール受信サーバー</label>
                  <div class="col-md-3 border-start pb-2 pt-2 border-end">
                    <p class="mb-0">{{ $inputs['mail_receive'] }}</p>
                    <input type="hidden" name="mail_receive" value="{{ $inputs['mail_receive'] }}">
                  </div>
                  <label for="inputText1" class="col-md-3 text-end control-label col-form-label">メール送信サーバー</label>
                  <div class="col-md-3 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['mail_send'] }}</p>
                    <input type="hidden" name="mail_send" value="{{ $inputs['mail_send'] }}">
                  </div>
                </div>
              </div>

              <h4 class="card-title fw-semibold mb-3">サーバーについてのメモ</h4>

              <div class="form-group mb-5 border-bottom-0">
                <div class="row align-items-center">
                  <p class="mb-0">{!! nl2br($inputs['note']) !!}</p>
                  <input type="hidden" name="note" value="{{ $inputs['note'] }}">
                </div>
              </div>

              <div class="d-flex align-items-center justify-content-end mt-4 gap-6">
                <button onclick="submitButton(this);" class="btn btn-primary">
                  <i class="ph ph-check fs-5 me-2"></i>
                  登録
                </button>
                <button type="button" class="btn bg-danger-subtle text-danger" onClick="history.back()">
                  <i class="ph ph-arrow-u-up-left fs-5 me-2"></i>
                  戻る
                </button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
    
	</div>
</div>
@endsection

@include('common.footer')