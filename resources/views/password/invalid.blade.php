@extends('common.form.layout')

@section('title',       'パスワード再発行期限切れ')
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
      @if(session('flash.success'))<div class="alert alert-success" role="alert">
          {{ session('flash.success') }}
      </div>@endif
      @if(session('flash.failed') or $errors->any())<div class="alert alert-danger" role="alert">
          {{ session('flash.failed') }}
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
      </div>@endif
      @if($errors->has('email'))<div class="invalid-feedback">{{$errors->first('email')}}</div>@endif
      <p class="text-center">有効期限が切れました😭<br />パスワードを再発行する場合は<br />以下のリンクより再度実行してください</p>
      <div class="d-flex align-items-center justify-content-center mb-4">
        <a href="{{ url('password') }}">パスワードをお忘れの方</a>
      </div>
    </div>
  </div>
</div>
@endsection

@include('common.form.footer')