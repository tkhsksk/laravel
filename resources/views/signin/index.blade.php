@extends('common.form.layout')

@section('title',       'サインイン')
@section('description', '')
@section('keywords',    '')

@include('common.form.head')
@include('common.form.header')

@section('contents')
<div class="col-xl-5 col-xxl-4">
  <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
    <div class="auth-max-width col-sm-8 col-md-6 col-xl-7 px-4">
      <h2 class="fs-7 fw-bolder mb-3">{{ App\Models\Config::find(1)->site_name }}へようこそ 🍰</h2>
      <p class="mb-7 text-center">@yield('title')｜勤怠管理システム</p>
      <hr class="mb-4" />

      @if(session('flash.success'))
      <div class="alert alert-success" role="alert">
          {!! session('flash.success') !!}
      </div>
      @endif

      @if(session('flash.failed') or $errors->any())
      <div class="alert alert-danger" role="alert">
          {{ session('flash.failed') }}
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
      </div>
      @endif

      @if($errors->has('email'))
      <div class="invalid-feedback">{{$errors->first('email')}}</div>
      @endif

      <div class="" id="accordionLogin">
        <div class="accordion-item mb-3">
          <h2 class="accordion-header" id="flush-headingOne">
            <button class="btn bg-primary-subtle text-primary collapsed w-100 py-8 fs-4" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
              <i class="ph ph-smiley me-2"></i>サインインする
            </button>
          </h2>
          <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionLogin">
            <div class="accordion-body">
              <div class="card card-body my-3">
                <form action="" method="post">
                @csrf
                  <div class="mb-3">
                    <label for="email" class="form-label"><span class="badge text-danger fw-semibold fs-1 me-2 bg-danger-subtle">必須</span>メールアドレス</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                  </div>

                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label"><span class="badge text-danger fw-semibold fs-1 me-2 bg-danger-subtle">必須</span>パスワード</label>
                    <input type="password" name="password" id="password" class="form-control">
                  </div>

                  <button onclick="submitButton(this);" class="btn btn-primary w-100 py-8 fs-4 mb-1 rounded-2">サインイン</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="accordion-item mb-3">
          <h2 class="accordion-header" id="flush-headingTwo">
            <button class="btn d-block bg-warning-subtle text-warning collapsed w-100 py-8 fs-4" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
              <i class="ph ph-smiley-meh me-2"></i>パスワードが分からない
            </button>
          </h2>
          <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionLogin" style="">
            <div class="accordion-body">
              <div class="card card-body my-3">
                <p>パスワードを忘れてしまった、もしくは初回ログインのユーザーは以下よりパスワードを再設定してください</p>
                <a href="{{ url('password') }}" class="btn btn-rounded btn-warning d-block">パスワードをお忘れの方 / 初回ログインの方</a>
              </div>
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="flush-headingThree">
            <button class="btn d-block btn-light text-dark collapsed w-100 py-8 fs-4" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
              <i class="ph ph-smiley-sad me-2"></i>ログイン情報を何も持っていない
            </button>
          </h2>
          <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionLogin">
            <div class="accordion-body">
              <div class="card card-body my-3">
                <p>会員登録する必要があります</p>
                <a class="btn btn-rounded btn-dark d-block" href="{{ url('register') }}">アカウント登録はこちら</a>
              </div>
            </div>
          </div>
        </div>

    </div>
  </div>
</div>
@endsection

@include('common.form.footer')