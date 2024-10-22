@extends('common.layout')

@section('title',       'ユーザー情報の確認')
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
                  <a class="text-muted text-decoration-none" href="/admin">社員・パート一覧</a>
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
          </div><div class="card-header bg-attention-3">
            <p class="mb-0">まだ登録は完了していません！右下の登録ボタンをクリックしてください！</p>
          </div>
          <div class="card-body">
            <h4 class="card-title fw-semibold mb-3">入力内容の確認</h4>
            <p class="card-subtitle mb-5 lh-base">入力内容を確認して右下の「登録する」をクリックして下さい</p>
            <form class="form-horizontal r-separator" action="{{ route('location.store') }}" novalidate="novalidate" method="post">
              @csrf
              <input type="hidden" name="id" value="@isset($inputs['id']){{ $inputs['id'] }}@endisset">

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-3 text-end control-label col-form-label">企業名</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ App\Models\Corp::find($inputs['corp_id'])->name }}</p>
                    <input type="hidden" name="corp_id" value="{{ $inputs['corp_id'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-3 text-end control-label col-form-label">オフィス名称</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['name'] }}</p>
                    <input type="hidden" name="name" value="{{ $inputs['name'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-3 text-end control-label col-form-label">オフィス入居状態</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ App\Models\Location::LOCATION_STATUS[$inputs['status']][0] }}</p>
                    <input type="hidden" name="status" value="{{ $inputs['status'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-3 text-end control-label col-form-label">オフィス住所</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">〒 {{ getPost($inputs['post']) }}<br />{{ $inputs['address'] }}</p>
                    <input type="hidden" name="post" value="{{ $inputs['post'] }}">
                    <input type="hidden" name="address" value="{{ $inputs['address'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-3 text-end control-label col-form-label">オフィス電話番号</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['phone'] }}</p>
                    <input type="hidden" name="phone" value="{{ $inputs['phone'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-3 text-end control-label col-form-label">オフィス最寄駅</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['nearest_station'] }}駅 @if($inputs['other_stations'])（他最寄：{{$inputs['other_stations']}}駅）@endif</p>
                    <input type="hidden" name="nearest_station" value="{{ $inputs['nearest_station'] }}">
                    <input type="hidden" name="other_stations" value="{{ $inputs['other_stations'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-3 text-end control-label col-form-label">オフィス入居開始日</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ date('Y年n月j日',strtotime($inputs['occupancy_at'])) }}</p>
                    <input type="hidden" name="occupancy_at" value="{{ $inputs['occupancy_at'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-5">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-3 text-end control-label col-form-label">雇用保険適用事業所番号</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['employment_insurance_number'] }}</p>
                    <input type="hidden" name="employment_insurance_number" value="{{ $inputs['employment_insurance_number'] }}">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-5">
                  <h4 class="card-title fw-semibold mb-3">平米数・金額など</h4>

                  <div class="form-group mb-0">
                    <div class="row align-items-center">
                      <label for="inputText1" class="col-6 text-end control-label col-form-label">オフィス平米数</label>
                      <div class="col-6 border-start pb-2 pt-2">
                        <p class="mb-0">{{ $inputs['width'] }}㎡</p>
                        <input type="hidden" name="width" value="{{ $inputs['width'] }}">
                      </div>
                    </div>
                  </div>

                  <div class="form-group mb-0">
                    <div class="row align-items-center">
                      <label for="inputText1" class="col-6 text-end control-label col-form-label">オフィス築年数</label>
                      <div class="col-6 border-start pb-2 pt-2">
                        <p class="mb-0">築 {{ $inputs['age'] }} 年</p>
                        <input type="hidden" name="age" value="{{ $inputs['age'] }}">
                      </div>
                    </div>
                  </div>

                  <div class="form-group mb-0">
                    <div class="row align-items-center">
                      <label for="inputText1" class="col-6 text-end control-label col-form-label">オフィス家賃</label>
                      <div class="col-6 border-start pb-2 pt-2">
                        <p class="mb-0">{{ number_format($inputs['rent']) }}円</p>
                        <input type="hidden" name="rent" value="{{ $inputs['rent'] }}">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 mb-5">
                  <h4 class="card-title fw-semibold mb-3">日付・期日など</h4>

                  <div class="form-group mb-0">
                    <div class="row align-items-center">
                      <label for="inputText1" class="col-6 text-end control-label col-form-label">オフィス契約日</label>
                      <div class="col-6 border-start pb-2 pt-2">
                        <p class="mb-0">{{ date('Y年n月j日',strtotime($inputs['contracted_at'])) }}</p>
                        <input type="hidden" name="contracted_at" value="{{ $inputs['contracted_at'] }}">
                      </div>
                    </div>
                  </div>

                  <div class="form-group mb-0">
                    <div class="row align-items-center">
                      <label for="inputText1" class="col-6 text-end control-label col-form-label">オフィス家賃引落日</label>
                      <div class="col-6 border-start pb-2 pt-2">
                        <p class="mb-0">毎月 {{ $inputs['payment_date'] }} 日</p>
                        <input type="hidden" name="payment_date" value="{{ $inputs['payment_date'] }}">
                      </div>
                    </div>
                  </div>

                  <div class="form-group mb-0">
                    <div class="row align-items-center">
                      <label for="inputText1" class="col-6 text-end control-label col-form-label">オフィス退去日</label>
                      <div class="col-6 border-start pb-2 pt-2">
                        <p class="mb-0">{{ $inputs['leaving_at'] ? date('Y年n月j日',strtotime($inputs['leaving_at'])) : '' }}</p>
                        <input type="hidden" name="leaving_at" value="{{ $inputs['leaving_at'] }}">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-12 mb-5">
                  <h4 class="card-title fw-semibold mb-3">オフィスについてのメモ</h4>

                  <div class="form-group mb-0">
                    <div class="row align-items-center">
                      <p class="mb-0">{!! nl2br($inputs['note']) !!}</p>
                      <input type="hidden" name="note" value="{{ $inputs['note'] }}">
                    </div>
                  </div>
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