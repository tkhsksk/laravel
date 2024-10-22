@extends('common.layout')

@section('title',       'オフィスの編集')
@section('description', '')
@section('keywords',    '')

@include('common.head')
@include('common.header')
@include('common.aside')

@section('contents')

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
                  <a class="text-muted text-decoration-none" href="/location">オフィス一覧</a>
                </li>
                @isset($location->id)
                <li class="breadcrumb-item">
                  <a class="text-muted text-decoration-none" href="/location/detail/{{ $location->id }}">オフィスの詳細</a>
                </li>
                @endisset
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

    <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>

    <form action="{{ route('location.confirm') }}" class="h-adr" novalidate="novalidate" method="post">
    @csrf
      <div class="row justify-content-center">
        <div class="col-lg-9">
          <div class="card">
            <div class="card-body p-4">

              <h4 class="card-title fw-semibold mb-3">オフィス編集項目</h4>
              <p class="card-subtitle mb-5 lh-base">必須項目を全て入力して左下の「確認する」をクリックして下さい</p>

              <input type="hidden" name="id" value="{{ $location ? old('id',$location->id) : '' }}">

              <div class="row mb-3">
                <div class="col-md-6">

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3 w-100">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-building-office text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div class=" w-100">
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}企業名称</h5>
                        <select class="form-select" aria-label="corp_id" name="corp_id">
                            <option value="">選択して下さい</option>
                          @foreach($corps as $corp)
                            <option value="{{ $corp->id }}" {{ $location ? (old('corp_id',$location->corp_id) == $corp->id ? 'selected' : '') : (old('corp_id') == $corp->id ? 'selected' : '') }}>{{ $corp->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3 w-100">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-door-open text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div class=" w-100">
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}オフィス名称</h5>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $location ? old('name',$location->name) : old('name') }}">
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-toggle-left text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}オフィス入居状態</h5>
                        <select class="form-select" aria-label="status" name="status">
                            <option value="">選択して下さい</option>
                          @foreach(App\Models\Location::LOCATION_STATUS as $index => $status)
                            <option value="{{ $index }}" {{ $location ? (old('status',$location->status) == $index ? 'selected' : '') : (old('status') == $index ? 'selected' : '') }}>{{ $status[0] }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3 w-100">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-map-pin-line text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div class=" w-100">
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}オフィス郵便番号</h5>
                        <div class="input-group border rounded-1" style="max-width: 9rem;">
                          <span class="input-group-text bg-transparent px-6 border-0" id="post">
                            〒
                          </span>
                          <input type="hidden" class="p-country-name" value="Japan">
                          <input type="text" id="post" name="post" class="form-control border-0 ps-2 p-postal-code" value="{{ $location ? old('post',$location->post) : old('post') }}">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3 w-100">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-map-pin-line text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div class=" w-100">
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}オフィス住所</h5>
                        <input type="text" class="form-control p-region p-locality p-street-address p-extended-address" id="address" name="address" value="{{ $location ? old('address',$location->address) : old('address') }}">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-device-mobile text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}オフィス電話番号</h5>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $location ? old('phone',$location->phone) : old('phone') }}">
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-train text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}オフィス最寄駅</h5>
                        <div class="input-group border rounded-1">
                          <input type="text" id="nearest_station" name="nearest_station" class="form-control border-0" value="{{ $location ? old('nearest_station',$location->nearest_station) : old('nearest_station') }}">
                          <span class="input-group-text bg-transparent px-6 border-0" id="nearest_station">駅</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-train text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">他オフィス最寄駅</h5>
                        <div class="input-group border rounded-1">
                          <input type="text" id="other_stations" name="other_stations" class="form-control border-0" value="{{ $location ? old('other_stations',$location->other_stations) : old('other_stations') }}">
                          <span class="input-group-text bg-transparent px-6 border-0" id="other_stations">駅</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-calendar text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}オフィス入居開始日</h5>
                        <div class="input-group">
                          <input type="date" id="occupancy_at" name="occupancy_at" class="form-control" value="{{ $location ? old('occupancy_at',$location->occupancy_at->format('Y-m-d')) : old('occupancy_at') }}">
                          <button class="btn bg-primary-subtle text-primary  rounded-end" type="button" aria-label="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" onclick="inputToday(this);">
                            本日の日付
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-files text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}雇用保険適用事業所番号</h5>
                        <input type="text" class="form-control" id="employment_insurance_number" name="employment_insurance_number" value="{{ $location ? old('employment_insurance_number',$location->employment_insurance_number) : old('employment_insurance_number') }}">
                      </div>
                    </div>
                  </div>

                </div>
              </div>

              <div class="row">

                <div class="col-md-6 mb-4">
                  <div class="connect-sorting connect-sorting-todo">
                    <div class="task-container-header">
                      <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="Todo">平米数・金額など</h6>
                    </div>
                    <div class="connect-sorting-content ui-sortable" data-sortable="true">
                      <div data-draggable="true" class="card img-task ui-sortable-handle">
                        <div class="card-body">
                          <div class="task-header">
                              <h5 class="fw-semibold d-flex align-items-center"><i class="ph ph-house-line me-2"></i>オフィス平米数</h5>
                          </div>
                          <div class="input-group border rounded-1">
                            <input type="text" id="width" name="width" class="form-control border-0" value="{{ $location ? floatval(old('width',$location->width)) : old('width') }}">
                            <span class="input-group-text bg-transparent px-6 border-0" id="width">㎡</span>
                          </div>
                        </div>
                      </div>

                      <div data-draggable="true" class="card img-task ui-sortable-handle">
                        <div class="card-body">
                          <div class="task-header">
                              <h5 class="fw-semibold d-flex align-items-center"><i class="ph ph-house-line me-2"></i>オフィス築年数</h5>
                          </div>
                          <div class="input-group border rounded-1">
                            <input type="text" id="age" name="age" class="form-control border-0" value="{{ $location ? floatval(old('age',$location->age)) : old('age') }}">
                            <span class="input-group-text bg-transparent px-6 border-0" id="age">年</span>
                          </div>
                        </div>
                      </div>

                      <div data-draggable="true" class="card img-task ui-sortable-handle">
                        <div class="card-body">
                          <div class="task-header">
                              <h5 class="fw-semibold"><i class="ph ph-currency-jpy me-2"></i>オフィス家賃</h5>
                          </div>
                          <div class="input-group border rounded-1">
                            <input type="text" id="rent" name="rent" class="form-control border-0" value="{{ $location ? old('rent',$location->rent) : old('rent') }}">
                            <span class="input-group-text bg-transparent px-6 border-0" id="rent">円</span>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>

                <div class="col-md-6 mb-4">
                  <div class="connect-sorting connect-sorting-todo">
                    <div class="task-container-header">
                      <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="Todo">日付・期日など</h6>
                    </div>
                    <div class="connect-sorting-content ui-sortable" data-sortable="true">
                      <div data-draggable="true" class="card img-task ui-sortable-handle">
                        <div class="card-body">
                          <div class="task-header">
                              <h5 class="fw-semibold">{!! $required_badge !!}<i class="ph ph-calendar me-2"></i>オフィス契約日</h5>
                          </div>
                          <div class="input-group">
                            <input type="date" id="contracted_at" name="contracted_at" class="form-control" value="{{ $location ? old('contracted_at',$location->contracted_at->format('Y-m-d')) : old('contracted_at') }}">
                            <button class="btn bg-primary-subtle text-primary  rounded-end" type="button" aria-label="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" onclick="inputToday(this);">
                              本日の日付
                            </button>
                          </div>
                        </div>
                      </div>

                      <div data-draggable="true" class="card img-task ui-sortable-handle">
                        <div class="card-body">
                          <div class="task-header">
                              <h5 class="fw-semibold">
                                <i class="ph ph-calendar me-2"></i>オフィス家賃引落日
                              </h5>
                          </div>
                          <div class="input-group border rounded-1">
                            <span class="input-group-text bg-transparent px-6 border-0">毎月</span>
                            <input type="text" id="payment_date" name="payment_date" class="form-control border-0 px-0" value="{{ $location ? old('payment_date',$location->payment_date) : old('payment_date') }}">
                            <span class="input-group-text bg-transparent px-6 border-0">日</span>
                          </div>
                        </div>
                      </div>

                      <div data-draggable="true" class="card img-task ui-sortable-handle">
                        <div class="card-body">
                          <div class="task-header">
                              <h5 class="fw-semibold"><i class="ph ph-calendar me-2"></i>オフィス退去日</h5>
                          </div>
                          <div class="task-content">
                            <div class="input-group">
                              <input type="date" id="leaving_at" name="leaving_at" class="form-control" value="{{ $location ? ($location->leaving_at ? old('leaving_at',$location->leaving_at->format('Y-m-d')) : old('leaving_at')) : old('leaving_at') }}">
                              <button class="btn bg-primary-subtle text-primary  rounded-end" type="button" aria-label="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" onclick="inputToday(this);">
                                本日の日付
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>

              </div>

              <div class="p-4 rounded-2 text-bg-light">
                <label for="note" class="form-label"><i class="ph ph-list-dashes me-2"></i>オフィスについてのメモ</label>
                <textarea class="form-control bg-white" name="note" rows="8">{{ $location ? old('note',$location->note) : old('note') }}</textarea>
              </div>

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