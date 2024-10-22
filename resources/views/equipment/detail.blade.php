@extends('common.layout')

@section('title',       '機材の詳細')
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
        <div class="card position-relative">
          <a href="/equipment/edit/{{ $equipment->id }}" class="text-bg-primary fs-6 rounded-circle p-2 text-white d-inline-flex position-absolute top-0 end-0 mt-n3 me-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="編集する"><i class="ph ph-pencil-line fs-6"></i></a>
          <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between">
              <div>
                <p class="mb-1">機材の社内名称</p>
                <h4 class="fw-semibold mb-3 d-flex align-items-center"><i class="ph ph-laptop me-2 fs-5"></i>{{ $equipment->portia_number }}</h4>
              </div>
              <div>
                <div class="d-flex align-items-center">
                  <span class="{{ App\Models\Equipment::EQUIPMENT_STATUS[$equipment->status][1] }} p-1 rounded-circle"></span>
                  <p class="mb-0 ms-2">{{ App\Models\Equipment::EQUIPMENT_STATUS[$equipment->status][0] }}</p>
                </div>
                <p class="text-muted mb-0">登録日：{{ $equipment->created_at->format('Y/n/j') }}</p>
                <p class="text-muted">更新日：{!! $equipment->updated_at ? $equipment->updated_at->format('Y/n/j') : $yet !!}</p>
              </div>
            </div>

            <div class="p-4 rounded-2 text-bg-light mb-4 d-flex">
              <i class="ph ph-list-dashes me-2 pt-1"></i><p class="mb-0 fs-3">{!! $equipment->note ? nl2br($equipment->note) : '<span class="text-muted">機材メモ未登録</span>' !!}</p>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <li class="d-flex align-items-center gap-6 mb-3">
                  <h6 class="fs-3 fw-semibold mb-0">カテゴリー：{{ App\Models\Equipment::EQUIPMENT_CATEGORIES[$equipment->category][0] }}</h6>
                </li>
                <img src="@asset('/image/equipment/{{$equipment->category}}.jpg')" class="card-img-top rounded-0 h-100 object-fit-cover" style="max-height: 250px" alt="{{ $equipment->category }}">
              </div>
              <div class="col-md-6">

                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="d-flex align-items-center gap-3">
                    <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                      <i class="ph ph-map-pin-line text-dark d-block fs-7" width="22" height="22"></i>
                    </div>
                    <div>
                      <h5 class="fs-4 fw-semibold">現在の保管場所</h5>
                      <p class="mb-0"><a href="/location/detail/{{ $equipment->location_id }}">{{ $equipment->location->name }}</a></p>
                    </div>
                  </div>
                </div>

                @if($equipment->admin)
                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="d-flex align-items-center gap-3">
                    <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                      <i class="ph ph-user text-dark d-block fs-7" width="22" height="22"></i>
                    </div>
                    <div>
                      <h5 class="fs-4 fw-semibold">現在の機材利用者</h5>
                      <p class="mb-0"><a href="/user/detail/{{ $equipment->admin->id }}">{{ getNamefromUserId($equipment->admin->user->id) }}</a></p>
                    </div>
                  </div>
                </div>
                @endif

                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="d-flex align-items-center gap-3">
                    <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                      <i class="ph ph-barcode text-dark d-block fs-7" width="22" height="22"></i>
                    </div>
                    <div>
                      <h5 class="fs-4 fw-semibold">機材型番</h5>
                      <p class="mb-0">{{ $equipment->number }}</p>
                    </div>
                  </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="d-flex align-items-center gap-3">
                    <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                      <i class="ph ph-currency-jpy text-dark d-block fs-7" width="22" height="22"></i>
                    </div>
                    <div>
                      <h5 class="fs-4 fw-semibold">機材購入価格</h5>
                      <p class="mb-0">{!! number_format($equipment->price) == 0 ? $yet : number_format($equipment->price).'円' !!}</p>
                    </div>
                  </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="d-flex align-items-center gap-3">
                    <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                      <i class="ph ph-calendar text-dark d-block fs-7" width="22" height="22"></i>
                    </div>
                    <div>
                      <h5 class="fs-4 fw-semibold">機材購入日</h5>
                      <p class="mb-0">{{ $equipment->purchased_at->format('Y年n月j日') }}</p>
                    </div>
                  </div>
                </div>

              </div>
            </div>

            <div class="row">

              <div class="col-md-6 mb-4">
                <div class="connect-sorting connect-sorting-todo">
                  <div class="task-container-header">
                    <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="Todo">バージョン・サイズなど</h6>
                  </div>
                  <div class="connect-sorting-content ui-sortable" data-sortable="true">
                    <div data-draggable="true" class="card img-task ui-sortable-handle">
                      <div class="card-body">
                        <div class="task-header">
                            <h5 class="fw-semibold"><i class="ph ph-apple-logo me-2"></i>機材に導入されているOS</h5>
                        </div>
                        <div class="task-content">
                          @if($equipment->os)
                          <p class="mb-0">
                            {{ $equipment->os }}（{{ $equipment->os_version }}）
                          </p>
                          @endif
                        </div>
                      </div>
                    </div>

                    <div data-draggable="true" class="card img-task ui-sortable-handle">
                      <div class="card-body">
                        <div class="task-header">
                            <h5 class="fw-semibold"><i class="ph ph-monitor me-2"></i>ディスプレイサイズ</h5>
                        </div>
                        <div class="task-content">
                          <p class="mb-0">
                            {{ floatval($equipment->display_size) }}インチ
                          </p>
                        </div>
                      </div>
                    </div>

                    @if($equipment->used_at)
                    <div data-draggable="true" class="card img-task ui-sortable-handle">
                      <div class="card-body">
                        <div class="task-header">
                            <h5 class="fw-semibold"><i class="ph ph-calendar me-2"></i>機材の利用開始日</h5>
                        </div>
                        <div class="task-content">
                          <p class="mb-0">
                            {{ $equipment->used_at->format('Y年n月j日') }}
                          </p>
                        </div>
                      </div>
                    </div>
                    @endif

                  </div>

                </div>
              </div>

              <div class="col-md-6 mb-4">
                <div class="connect-sorting connect-sorting-todo">
                  <div class="task-container-header">
                    <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="Todo">機材スペックなど</h6>
                  </div>
                  <div class="connect-sorting-content ui-sortable" data-sortable="true">
                    <div data-draggable="true" class="card img-task ui-sortable-handle">
                      <div class="card-body">
                        <div class="task-header">
                            <h5 class="fw-semibold"><i class="ph ph-memory me-2"></i>機材メモリ</h5>
                        </div>
                        <div class="task-content">
                          <p class="mb-0">
                            {{ $equipment->memory }}
                          </p>
                        </div>
                      </div>
                    </div>

                    <div data-draggable="true" class="card img-task ui-sortable-handle">
                      <div class="card-body">
                        <div class="task-header">
                            <h5 class="fw-semibold"><i class="ph ph-hard-drives me-2"></i>機材ストレージ</h5>
                        </div>
                        <div class="task-content">
                          <p class="mb-0">
                            {{ $equipment->storage }}
                          </p>
                        </div>
                      </div>
                    </div>

                    <div data-draggable="true" class="card img-task ui-sortable-handle">
                      <div class="card-body">
                        <div class="task-header">
                            <h5 class="fw-semibold"><i class="ph ph-cpu me-2"></i>機材プロセッサ</h5>
                        </div>
                        <div class="task-content">
                          <p class="mb-0">
                            {{ $equipment->processor }}
                          </p>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    
	</div>
</div>
@endsection

@include('common.footer')