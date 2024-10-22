@extends('common.layout')

@section('title',       'お知らせの確認')
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
                  <a class="text-muted text-decoration-none" href="/notification">お知らせ一覧</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">@yield('title')</li>
              </ol>
            </nav>
          </div>
          <div class="col-3">
            <div class="text-center mb-n5">
              <img src="@asset('/image/titleBg.svg')" alt="" class="img-fluid mb-n3">
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
            <form class="form-horizontal r-separator" action="{{ route('notification.store') }}" novalidate="novalidate" method="post">
              @csrf
              <input type="hidden" name="id" value="@isset($inputs['id']){{ $inputs['id'] }}@endisset">

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-3 text-end control-label col-form-label">登録者</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ getNamefromUserId($inputs['register_id'],'A') }}</p>
                    <input type="hidden" name="register_id" value="{{ $inputs['register_id'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-3 text-end control-label col-form-label">公開状態</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">@isset($inputs['status']) 公開 @else 非公開 @endisset</p>
                    <input type="hidden" name="status" value="@isset($inputs['status']) E @else D @endisset">
                  </div>
                </div>
              </div>

              <div class="form-group mb-5">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-3 text-end control-label col-form-label">閲覧権限</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">@isset($inputs['role']) {{ App\Models\Admin::ADMIN_ROLES[$inputs['role']][0] }}権限以上 @else 全ユーザーが閲覧可能 @endisset</p>
                    <input type="hidden" name="role" value="{{ $inputs['role'] }}">
                  </div>
                </div>
              </div>

              <div class="row">
                @if($inputs['started_at'] || $inputs['ended_at'])
                <div class="col-md-12 mb-5">
                  <h4 class="card-title fw-semibold mb-3">表示期間</h4>
                  <div class="d-flex align-items-center justify-content-center">
                    <div>
                      @if($inputs['started_at'])
                      <p class="mb-0 text-center fs-7 fw-semibold">
                        <i class="ph ph-calendar me-2 fs-5"></i>{{ $inputs['started_at'] }}
                      </p>
                      @else
                      <p class="mb-0 text-center fs-7 fw-semibold">登録時点</p>
                      @endif
                      @if($inputs['started_hr_at'])
                      <p class="fs-5">
                        <i class="ph ph-clock-user me-2 fs-5"></i>{{ $inputs['started_hr_at'] }}：{{ sprintf('%02d', $inputs['started_min_at']) }} 
                      </p>
                      @endif
                    </div>
                    <span class="px-3">〜</span>
                    <div>
                      @if($inputs['ended_at'])
                      <p class="mb-0 text-center fs-7 fw-semibold">
                        <i class="ph ph-calendar me-2 fs-5"></i>{{ $inputs['ended_at'] }}
                      </p>
                      @else
                      <p class="mb-0 text-center fs-7 fw-semibold">登録時点</p>
                      @endif
                      @if($inputs['ended_hr_at'])
                      <p class="fs-5">
                        <i class="ph ph-clock-user me-2 fs-5"></i>{{ $inputs['ended_hr_at'] }}：{{ sprintf('%02d', $inputs['ended_min_at']) }}
                      </p>
                      @endif
                    </div>
                  </div>
                </div>
                @endif
                <input type="hidden" name="started_at" value="{{ $inputs['started_at'] }}">
                <input type="hidden" name="started_hr_at" value="{{ $inputs['started_hr_at'] }}">
                <input type="hidden" name="started_min_at" value="{{ $inputs['started_min_at'] }}">
                <input type="hidden" name="ended_at" value="{{ $inputs['ended_at'] }}">
                <input type="hidden" name="ended_hr_at" value="{{ $inputs['ended_hr_at'] }}">
                <input type="hidden" name="ended_min_at" value="{{ $inputs['ended_min_at'] }}">

                <div class="col-md-12">
                  <h4 class="card-title fw-semibold mb-3"><i class="ph ph-eyes me-2"></i>お知らせの表示確認</h4>

                    <div class="card overflow-hidden notification-body">
                      <div class="card-body p-4">
                      <h2 class="fs-7 fw-semibold mt-4 mb-2">{{ $inputs['title'] }}</h2>
                      </div>
                      <div class="card-body border-top p-4 fs-4">
                      {!! $inputs['note'] !!}
                      </div>
                    </div>
                  <input type="hidden" name="title" value="{{ $inputs['title'] }}">
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