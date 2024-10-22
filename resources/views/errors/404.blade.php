@extends('common.layout')

@section('title',       'ページが見つかりませんでした')
@section('description', '')
@section('keywords',    '')

@include('common.head')
@include('common.header')
@include('common.aside')

@section('contents')
<div class="body-wrapper">
	<div class="container-fluid">

  <div class="py-5">
    <img src="@asset('/thumb/portia.svg')" style="max-height: 223px;" class="d-block mx-auto mb-4 px-md-0">
    <h2 class="text-center display-2">404</h2>
    <p class="text-center">ページが見つかりませんでした</p>
    <div class="d-flex justify-content-center">
      <a href="{{ url()->previous() }}" class="btn btn-primary">直前のページに戻る</a>
    </div>
  </div>

	</div>
</div>
@endsection

@include('common.footer')