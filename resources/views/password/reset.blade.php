@extends('common.form.layout')

@section('title',       'パスワードの再発行')
@section('description', '')
@section('keywords',    '')

@include('common.form.head')
@include('common.form.header')

@section('contents')
<div class="col-xl-5 col-xxl-4">
  <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
    <div class="auth-max-width col-sm-8 col-md-6 col-xl-7 px-4">
      <h2 class="fs-7 fw-bolder mb-3">{{ App\Models\Config::find(1)->site_name }}へようこそ 🍰</h2>
      <p class="mb-7">@yield('title')｜勤怠管理システム</p>
      <hr class="mb-4" />

      @if ($errors->any())
      <div class="alert alert-danger" role="alert">
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
      </div>
      @endif

      <p class="fs-4 fw-bold">右にある<i class="ph ph-clipboard-text text-dark"></i>ボタンをクリックして、パスワードをコピーしてください</p>
      <div class="d-flex align-items-center mb-2">
        <span class="h5 me-2 text-break font-monospace mb-0">{{ $password }}</span>
        <a class="text-bg-light rounded-1 text-primary p-6 d-flex align-items-center justify-content-center" data-text="{{ $password }}" onclick="copyText(this);" role="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="コピーする"><i class="ph ph-clipboard-text text-dark d-block fs-6" width="22" height="22" data-bs-toggle="collapse" data-bs-target="#collapseSignin" aria-expanded="false" aria-controls="collapseSignin"></i></a>
      </div>
      <div class="collapse" id="collapseSignin" style="">
        <div class="card card-body">
          <div class="d-flex flex-wrap align-items-center justify-content-center">
            <p class="fs-4 fw-bold">コピーが完了しました、以下よりサインインページに進んで<span class="bg-primary-subtle text-primary"><i class="ph ph-smiley me-2"></i>サインインする</span>のボタンよりサインインしてください</p>
            <a class="text-primary fw-bold px-2 fs-4" href="{{ url('signin') }}">サインインはこちら</a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

@include('common.form.footer')