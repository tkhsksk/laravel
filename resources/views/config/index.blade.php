@extends('common.layout')

@section('title',       'コンフィグ')
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

    <form class="form-horizontal r-separator" action="{{ route('config.store') }}" novalidate="novalidate" method="post">
      @csrf
      <div class="row">
        <div class="col-12 d-flex justify-content-end mb-3">
          <button onclick="submitButton(this);" class="btn btn-primary">
            <i class="ph ph-check fs-5 me-2"></i>
            登録
          </button>
        </div>
        <div class="col-lg-6 d-flex align-items-stretch">
          <div class="card w-100 border position-relative overflow-hidden">
            <div class="card-body p-4">
              <h4 class="card-title fw-semibold">各種設定</h4>
              <p class="card-subtitle mb-4">サイト名やその他設定を入力してください</p>
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">サイト名</label>
                  <input type="text" class="form-control" name="site_name" value="{{ $config->site_name }}">
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword3" class="form-label">MatterMostのPostステータス</label><br />
                  <input name="mm_status" type="checkbox" value="true" data-toggle="toggle" data-on="有効" data-off="無効" data-onstyle="success" data-off-color="default" {{ $config->mm_status == 'E' || old('mm_status') ? 'checked' : '' }}>
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword2" class="form-label">MatterMostのPost用URL</label>
                  <input type="text" class="form-control" name="mm_url" value="{{ $config->mm_url }}" placeholder="https://mm.portia.co.jp/api/v4/posts">
                </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 d-flex align-items-stretch">
          <div class="card w-100 border position-relative overflow-hidden">
            <div class="card-body p-4">
              <h4 class="card-title fw-semibold">休業日設定</h4>
              <p class="card-subtitle mb-4">国民の休日以外の休日がある場合は、指定の書式で、改行して入力してください<br />（例:2024-06-12:夏季休業日）</p>
                <div>
                  <label for="exampleInputPassword3" class="form-label">休業日</label>
                  <textarea class="form-control" id="exampleInputPassword3" name="corp_holiday" rows=8 placeholder="2024-08-16:夏季休業日&#13;2025-02-22:会社設立日&#13;：">{{ $config->corp_holiday }}</textarea>
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