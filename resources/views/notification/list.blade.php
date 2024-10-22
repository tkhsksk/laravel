@extends('common.layout')

@section('title',       'お知らせ一覧')
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

    <div class="row justify-content-end mb-3">
      <div class="col-lg-6 d-flex justify-content-md-start justify-content-center">
        {{ $notifications->links('common.pager') }}
      </div>
      <div class="col-lg-6 text-end">
        <h2 class="fw-bolder mb-0 fs-8 lh-base"><span class="fs-3 fw-normal me-3">現在</span>{{ $notifications->count() }}<span class="fs-3 fw-normal ms-3">件のお知らせが公開されています</span></h2>
      </div>
    </div>

    <div class="row justify-content-center">

      @foreach($notifications as $notification)
      <div class="col-md-6 col-lg-3">
        <div class="card rounded-2 overflow-hidden hover-img">
          <div class="row">
            <div class="position-relative col-md-12 col-6">
              <a href="/notification/detail/{{ $notification->id }}">
                @if(getFirstImage($notification->note))
                <img src="@asset({{getFirstImage($notification->note)}})" class="card-img-top rounded-0 object-fit-cover" style="max-height: 220px;">
                @else
                <img src="@asset('/thumb/no-bg.svg')" class="card-img-top rounded-0 object-fit-cover" style="max-height: 220px;">
                @endif
              </a>
              <span class="d-md-inline-block d-none badge text-bg-light fs-2 rounded-4 lh-sm mb-9 me-9 py-1 px-2 fw-semibold position-absolute bottom-0 end-0"><i class="ph ph-calendar text-dark me-2"></i>{{ $notification->created_at->format('Y年n月j日') }}</span>
              <img src="{{ getUserImage($notification->register_id) }}" alt="" class="img-fluid rounded-circle position-absolute bottom-0 start-0 mb-md-n9 mb-1 ms-md-9 ms-3 object-fit-cover" style="width:40px;height: 40px" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="登録者：{{ getNamefromUserId($notification->register_id,'U') }}">
            </div>

            <div class="card-body p-4 ps-md-4 ps-2 col-md-12 col-6">
              <span class="d-md-none d-inline-block badge text-bg-light fs-2 rounded-4 lh-sm mb-3 py-1 px-2 fw-semibold bottom-0 end-0"><i class="ph ph-calendar text-dark me-2"></i>{{ $notification->created_at->format('Y年n月j日') }}</span>
              <h3 class="d-block mt-md-2 mb-3 fs-5 text-dark fw-semibold lh-sm"><a href="/notification/detail/{{ $notification->id }}">{{ $notification->title }}</a><a href="/notification/edit/{{ $notification->id }}" class="d-inline-block ms-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="編集する"><i class="ph ph-pencil-line fs-5"></i></a></h3>
              <div class="d-flex align-items-center flex-wrap gap-2">
                <div class="d-flex align-items-center fs-2"><i class="ph ph-clock-counter-clockwise text-dark me-2"></i>{{ $notification->updated_at }}
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      @endforeach
      @if($notifications->count() == 0)
      <div class="col-12">
        <div class="alert alert-light-danger bg-danger-subtle text-danger fade show" role="alert">
          <div class="d-flex align-items-center justify-content-center">
            <i class="ph ph-clock-user fs-5 me-2 text-danger"></i>
            公開中のお知らせはありません
          </div>
        </div>
      </div>
      @endif

    </div>

    {{ $notifications->links('common.pager') }}

  </div>
</div>
@endsection

@include('common.footer')