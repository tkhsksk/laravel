@extends('common.form.layout')

@section('title',       'パスワードリセット')
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
          {{ session('flash.success') }}
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
      
      <form action="" method="post">
      @csrf
        <div class="mb-3">
          <label for="email" class="form-label"><span class="badge text-danger fw-semibold fs-1 me-2 bg-danger-subtle">必須</span>メールアドレス</label>
          <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
        </div>

        <button type="submit" class="btn btn-primary w-100 py-8 fs-3 mb-4 rounded-2">メールアドレスに<br />パスワード再設定用のリンクを送る</button>
      </form>
    </div>
  </div>
</div>
@endsection

@include('common.form.footer')