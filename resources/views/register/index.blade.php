@extends('common.form.layout')

@section('title',       'アカウント登録')
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
            <form action="" method="post">
            @csrf
              <div class="mb-3">
                <label for="name" class="form-label"><span class="badge text-danger fw-semibold fs-1 me-2 bg-danger-subtle">必須</span>ユーザー名</label>
                <input type="text" name="name" id="name" class="form-control @if($errors->has('name')) is-invalid @endif" value="{{ old('name') }}">
              </div>
              <div class="mb-3">
                <label for="email" class="form-label"><span class="badge text-danger fw-semibold fs-1 me-2 bg-danger-subtle">必須</span>メールアドレス</label>
                <input type="email" name="email" id="email" class="form-control @if($errors->has('email')) is-invalid @endif" value="{{ old('email') }}">
              </div>
              <div class="mb-4">
                <label for="exampleInputPassword1" class="form-label"><span class="badge text-danger fw-semibold fs-1 me-2 bg-danger-subtle">必須</span>パスワード</label>
                <input type="password" name="password" id="password" class="form-control @if($errors->has('password')) is-invalid @endif">
              </div>
              <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">登録する</button>
              <div class="d-flex flex-wrap align-items-center justify-content-center">
                <p class="fs-4 mb-0 fw-bold">すでにアカウントをお持ちですか？</p>
                <a class="text-primary fw-bold px-2" href="{{ url('signin') }}">サインインはこちら</a>
              </div>
            </form>
        </div>
    </div>
</div>
@endsection

@include('common.form.footer')