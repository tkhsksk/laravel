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
                  <a class="text-muted text-decoration-none" href="/equipment">機材一覧</a>
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
            <form class="form-horizontal r-separator" action="{{ route('equipment.store') }}" novalidate="novalidate" method="post">
              @csrf
              <input type="hidden" name="id" value="@isset($inputs['id']){{ $inputs['id'] }}@endisset">

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-3 text-end control-label col-form-label">機材の名称</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['portia_number'] }}</p>
                    <input type="hidden" name="portia_number" value="{{ $inputs['portia_number'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-3 text-end control-label col-form-label">機材利用状態</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ App\Models\Equipment::EQUIPMENT_STATUS[$inputs['status']][0] }}</p>
                    <input type="hidden" name="status" value="{{ $inputs['status'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-3 text-end control-label col-form-label">機材カテゴリー</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ App\Models\Equipment::EQUIPMENT_CATEGORIES[$inputs['category']][0] }}</p>
                    <input type="hidden" name="category" value="{{ $inputs['category'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-3 text-end control-label col-form-label">機材保管場所</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['location_id'] ? App\Models\Location::find($inputs['location_id'])->corp->name.'｜'.App\Models\Location::find($inputs['location_id'])->name : '' }}</p>
                    <input type="hidden" name="location_id" value="{{ $inputs['location_id'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-3 text-end control-label col-form-label">機材を利用しているユーザー</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $name }}</p>
                    <input type="hidden" name="admin_id" value="{{ $inputs['admin_id'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-3 text-end control-label col-form-label">機材型番</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['number'] }}</p>
                    <input type="hidden" name="number" value="{{ $inputs['number'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-3 text-end control-label col-form-label">機材購入価格</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['price'] }} 円</p>
                    <input type="hidden" name="price" value="{{ $inputs['price'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-5">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-3 text-end control-label col-form-label">機材購入日</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['purchased_at'] }}</p>
                    <input type="hidden" name="purchased_at" value="{{ $inputs['purchased_at'] }}">
                  </div>
                </div>
              </div>
              <p></p>

              <div class="row">
                <div class="col-md-6 mb-5">
                  <h4 class="card-title fw-semibold mb-3">バージョン・サイズなど</h4>

                  <div class="form-group mb-0">
                    <div class="row align-items-center">
                      <label for="inputText1" class="col-6 text-end control-label col-form-label">機材に導入されているOS</label>
                      <div class="col-6 border-start pb-2 pt-2">
                        <p class="mb-0">{{ $inputs['os'] }}（{{ $inputs['os_version'] }}）</p>
                        <input type="hidden" name="os" value="{{ $inputs['os'] }}">
                        <input type="hidden" name="os_version" value="{{ $inputs['os_version'] }}">
                      </div>
                    </div>
                  </div>

                  <div class="form-group mb-0">
                    <div class="row align-items-center">
                      <label for="inputText1" class="col-6 text-end control-label col-form-label">ディスプレイサイズ</label>
                      <div class="col-6 border-start pb-2 pt-2">
                        <p class="mb-0">{{ $inputs['display_size'] }} インチ</p>
                        <input type="hidden" name="display_size" value="{{ $inputs['display_size'] }}">
                      </div>
                    </div>
                  </div>

                  <div class="form-group mb-0">
                    <div class="row align-items-center">
                      <label for="inputText1" class="col-6 text-end control-label col-form-label">機材の利用開始日</label>
                      <div class="col-6 border-start pb-2 pt-2">
                        <p class="mb-0">{{ $inputs['used_at'] }}</p>
                        <input type="hidden" name="used_at" value="{{ $inputs['used_at'] }}">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 mb-5">
                  <h4 class="card-title fw-semibold mb-3">機材スペックなど</h4>

                  <div class="form-group mb-0">
                    <div class="row align-items-center">
                      <label for="inputText1" class="col-6 text-end control-label col-form-label">機材メモリ</label>
                      <div class="col-6 border-start pb-2 pt-2">
                        <p class="mb-0">{{ $inputs['memory'] }}</p>
                        <input type="hidden" name="memory" value="{{ $inputs['memory'] }}">
                      </div>
                    </div>
                  </div>

                  <div class="form-group mb-0">
                    <div class="row align-items-center">
                      <label for="inputText1" class="col-6 text-end control-label col-form-label">機材ストレージ</label>
                      <div class="col-6 border-start pb-2 pt-2">
                        <p class="mb-0">{{ $inputs['storage'] }}</p>
                        <input type="hidden" name="storage" value="{{ $inputs['storage'] }}">
                      </div>
                    </div>
                  </div>

                  <div class="form-group mb-0">
                    <div class="row align-items-center">
                      <label for="inputText1" class="col-6 text-end control-label col-form-label">機材プロセッサ</label>
                      <div class="col-6 border-start pb-2 pt-2">
                        <p class="mb-0">{{ $inputs['processor'] }}</p>
                        <input type="hidden" name="processor" value="{{ $inputs['processor'] }}">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-12 mb-5">
                  <h4 class="card-title fw-semibold mb-3">機材についてのメモ</h4>

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