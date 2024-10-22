@extends('common.layout')

@section('title',       '購入リクエストの詳細')
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

    <div class="row justify-content-center">
      <div class="col-lg-9">
        <div class="card position-relative">
          <a href="/order/edit/{{ $order->id }}" class="text-bg-primary fs-6 rounded-circle p-2 text-white d-inline-flex position-absolute top-0 end-0 mt-n3 me-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="編集する"><i class="ph ph-pencil-line fs-6"></i></a>
          <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between">
              <div>
                <p class="mb-1">商品名</p>
                <h4 class="fw-semibold mb-4 d-flex align-items-center fs-8">{{ $order->product_name }}</h4>
                <div class="d-flex align-items-center gap-6 flex-wrap mb-1">

                  <a href="/user/detail/{{ $order->register_id }}"><img src="{{ getUserImage($order->register_id) }}" alt="modernize-img" class="rounded-circle object-fit-cover" width="40" height="40"></a>
                  <h4 class="fw-semibold d-flex align-items-center mb-0 h6">
                    <a href="/user/detail/{{ $order->register_id }}">
                      {{ getNamefromUserId($order->register_id,'A') }}
                      <p class="mb-0 fs-2 text-muted fw-normal pt-1">リクエストユーザー</p>
                    </a>
                  </h4>

                  <div class="text-center px-1">
                    <i class="ph ph-caret-right fs-6 fw-semibold text-muted"></i>
                  </div>

                  <a href="/user/detail/{{ $order->charger_id }}"><img src="{{ getUserImage($order->charger_id) }}" alt="modernize-img" class="rounded-circle object-fit-cover" width="40" height="40"></a>
                  <h4 class="fw-semibold d-flex align-items-center mb-0 h6">
                    <a href="/user/detail/{{ $order->charger_id }}">
                      {{ getNamefromUserId($order->charger_id,'A') }}
                      <p class="mb-0 fs-2 text-muted fw-normal pt-1">購入ユーザー</p>
                    </a>
                  </h4>

                </div>
              </div>

              <div>
                <div class="d-flex align-items-center">
                  <span class="bg-{{ App\Models\order::STATUS[$order->status][1] }} p-1 rounded-circle"></span>
                  <p class="mb-0 ms-2">{{ App\Models\order::STATUS[$order->status][0] }}</p>
                </div>
                <p class="text-muted mb-0">登録日：{{ $order->created_at->format('Y/n/j') }}</p>
                <p class="text-muted">更新日：{!! $order->updated_at ? $order->updated_at->format('Y/n/j') : $order->created_at->format('Y/n/j') !!}</p>
              </div>
            </div>

          </div>

          <div class="card-body p-0 border-top">
            <div class="d-flex">
              <div class="col-6 border-end p-4">
                <span class="text-uppercase d-flex mb-7 align-items-center fw-bolder fs-4"><i class="ph ph-truck text-primary fs-6 me-2"></i><span>購入日</span></span>
                <div class="d-flex mb-3">
                  <h5 class="fw-bolder fs-6 mb-0"><i class="ph ph-calendar text-dark d-block fs-7" width="22" height="22"></i></h5>
                  <h2 class="fw-bolder fs-10 ms-3 mb-0">{!! $order->purchase_at ?$order->purchase_at->isoFormat('YYYY/M/D(ddd) H:mm:ss'):'<span class="text-muted fw-normal">未購入</span>' !!}</h2>
                </div>
              </div>
              <div class="col-6 p-4">
                <span class="text-uppercase d-flex mb-7 align-items-center fw-bolder fs-4"><i class="ph ph-check-circle text-success fs-6 me-2"></i><span>到着日</span></span>
                <div class="d-flex mb-3">
                  <h5 class="fw-bolder fs-6 mb-0"><i class="ph ph-calendar text-dark d-block fs-7" width="22" height="22"></i></h5>
                  <h2 class="fw-bolder fs-10 ms-3 mb-0">{!! $order->arrival_at ?$order->arrival_at->isoFormat('YYYY/M/D(ddd) H:mm:ss'):'<span class="text-muted fw-normal">未到着</span>' !!}</h2>
                </div>
              </div>
            </div>
          </div>

          <div class="card-body border-top p-4 fs-4 notification-body">
            <h5 class="fs-4 fw-semibold"><i class="ph ph-pencil-line me-2"></i>申請者メモ</h5>
            {!! $order->note ? $order->note : '<span class="text-muted">申請者メモなし</span>' !!}
          </div>

        </div>
      </div>
    </div>
    
	</div>
</div>
@endsection

@include('common.footer')