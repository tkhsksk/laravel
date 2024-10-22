@extends('common.layout')

@section('title',       '購入リクエストの編集')
@section('description', '')
@section('keywords',    '')

@include('common.head')
@include('common.header')
@include('common.aside')

@section('contents')
<link href="@asset('/css/bootstrap4-toggle.min.css')" rel="stylesheet">
<script src="@asset('/js/bootstrap4-toggle.min.js')"></script>
<script src="@asset('/js/dualbox/jquery.bootstrap-duallistbox.js')"></script>

<script>
  tinyMce('order');
</script>

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
                <li class="breadcrumb-item">
                  <a class="text-muted text-decoration-none" href="/order">購入リスト</a>
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

    <form action="{{ route('order.confirm') }}" class="h-adr" novalidate="novalidate" method="post">
    @csrf
      <div class="row justify-content-center">
        <div class="col-lg-9">
          <div class="card">
            <div class="card-body p-4">

              <h4 class="card-title fw-semibold mb-3">@yield('title')項目</h4>
              <p class="card-subtitle mb-5 lh-base">必須項目を全て入力して左下の「確認する」をクリックして下さい</p>

              <input type="hidden" name="id" value="{{ $order ? old('id',$order->id) : '' }}">
              @if($order)
              <input type="hidden" name="register_id" value="{{ old('id',$order->register_id) }}">
              <input type="hidden" name="updater_id" value="{{ Auth::user()->id }}">
              @else
              <input type="hidden" name="register_id" value="{{ Auth::user()->id }}">
              <input type="hidden" name="updater_id" value="">
              @endif

              <div class="row mb-3">
                <div class="col-md-7">
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3 w-100">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-pencil-ruler text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div class=" w-100">
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}商品名</h5>
                        <input type="text" class="form-control form-control-lg" id="product_name" name="product_name" value="{{ $order ? old('product_name',$order->product_name) : old('product_name') }}">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-5">
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3 w-100">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-toggle-left text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div class=" w-100">
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}ステータス</h5>
                        @if($order)
                        <select class="form-select form-select-lg" aria-label="status" name="status">
                            @foreach($statuses as $index => $status)
                            <option value="{{ $index }}" {{ $order ? (old('status',$order->status) == $index ? 'selected' : '') : (old('status') == $index ? 'selected' : '') }}>{{ $status[0] }}</option>
                            @endforeach
                        </select>
                        @else
                        <div class="d-flex align-items-center py-2 ps-3">
                          <span class="bg-{{ App\Models\Shift::STATUS['N'][1] }} p-1 rounded-circle"></span>
                          <p class="mb-0 ms-2 fs-4">{{ App\Models\Order::STATUS['N'][0] }}</p>
                        </div>
                        <input type="hidden" name="status" value="N">
                        @endif
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <div class="card bg-primary-subtle rounded-2">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="card mb-0">
                        <div class="card-body">
                          <h5 class="card-title fw-semibold">{!! $required_badge !!}購入ユーザーの選択</h5>
                          <p class="card-subtitle mb-4">購入するユーザーを左のボックスから選択して下さい</p>
                          <div class="">
                          <form id="equipments_form" action="#" method="post">
                            @csrf
                            <select size="" name="charger_id">
                              @foreach($admins as $admin)
                              <option value="{{ $admin->id }}"
                                @if($order)
                                {{ $admin->id == $order->charger_id ? 'selected' : '' }}
                                @else
                                  @if(Cookie::get('default_charger'))
                                    {{ $admin->id == Cookie::get('default_charger') ? 'selected' : '' }}
                                  @endif
                                @endif
                                >
                              {{ getNamefromUserId($admin->id,'A') }}</option>
                              @endforeach
                            </select>
                          </form>
                          <script>
                            var charger_check = $('select[name="charger_id"]')
                            .bootstrapDualListbox({
                              filterTextClear:      '<i class="ph ph-x fs-2"></i>',
                              filterPlaceHolder:    'ユーザーの検索',
                              moveSelectedLabel:    '選択済みに移動',
                              moveAllLabel:         '選択済みに全て移動',
                              removeSelectedLabel:  '選択を解除',
                              removeAllLabel:       '選択を全て解除',
                              nonSelectedListLabel: 'すべてのユーザー',
                              selectedListLabel:    '選択中の購入ユーザー',
                              infoText:             '（{0}件）',
                              infoTextEmpty:        '（0件）',
                              infoTextFiltered:     '（該当：{0}件 / 全{1}件）',
                            });
                          </script>

                          </div> 
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <h5 class="fs-4 fw-semibold"><i class="ph ph-pencil-line me-2"></i>申請者メモ</h5>
              <p class="mb-3 card-subtitle">本文に埋め込める画像ファイルの最大サイズは <code>500KB</code> です</p>
              <textarea class="form-control bg-white tinymce" name="note">{{ $order ? old('note',$order->note) : old('note') }}</textarea>

              <div class="d-flex align-items-center justify-content-end mt-4 gap-6">
                <button onclick="submitButton(this);" class="btn btn-primary"><i class="ph ph-check fs-5 me-2"></i>
                  確認する</button>
                <button class="btn bg-danger-subtle text-danger" onClick="history.back()" type="button"><i class="ph ph-arrow-u-up-left fs-5 me-2"></i>
                  戻る</button>
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