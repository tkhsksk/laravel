@extends('common.layout')

@section('title',       'マニュアルの詳細')
@section('description', '')
@section('keywords',    '')

@include('common.head')
@include('common.header')
@include('common.aside')

@section('contents')

<div class="body-wrapper">
	<div class="container-fluid">

    @include('common.alert')

    <div class="card overflow-hidden">
      <div class="position-relative">
        @if(getFirstImage($manual->note))
        <img src="@asset({{getFirstImage($manual->note)}})" class="card-img-top rounded-0 object-fit-cover" alt="modernize-img" height="100">
        @else
        <img src="@asset('/thumb/no-bg.svg')" class="card-img-top rounded-0 object-fit-cover" alt="modernize-img" height="100">
        @endif
        <div class="position-absolute w-100 h-100 bg-dark opacity-25 top-0"></div>
        <span class="badge text-bg-light mb-9 me-9 position-absolute bottom-0 end-0"><i class="ph ph-clock-clockwise text-dark me-2"></i>およそ{{ getReadTime($manual->note) }}で読めます</span>
        <img src="{{ getUserImage($manual->register_id) }}" alt="modernize-img" class="img-fluid rounded-circle position-absolute bottom-0 start-0 mb-n9 ms-9 object-fit-cover" style="width: 40px;height: 40px;">
        <a href="/manual/edit/{{ $manual->id }}" class="text-bg-primary fs-6 rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n9 me-9" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="編集する"><i class="ph ph-pencil-line fs-6"></i></a>
      </div>
      <div class="card-body p-4 pb-3">
        <div class="d-flex flex-wrap justify-content-between mt-md-0 mt-2">
          <span class="badge text-bg-light text-break text-wrap text-start lh-base">投稿者：{{ getNamefromUserId($manual->register_id,'U') }}</span>
          <div class="d-flex align-items-center col-md-auto col-12 justify-content-end mt-md-0 mt-2">{!! getStatus('公開','非公開',$manual->status) !!}</div>
        </div>
        <div class="d-flex flex-wrap justify-content-between">
          <h2 class="fs-7 fw-semibold my-4">{{ $manual->id }}｜{{ $manual->title }}</h2>
          <div class="d-flex align-items-center gap-4 ms-md-2">
            <div class="d-flex align-items-center flex-wrap fs-2 ms-auto">
              <div class="d-flex align-items-center w-100 justify-content-end"><i class="ph ph-pencil-line text-dark me-2"></i>登録日　{{ $manual->created_at->format('Y/n/j') }}</div>
              <div class="d-flex align-items-center w-100 justify-content-end flex-wrap"><i class="ph ph-clock-counter-clockwise text-dark me-2"></i>最終更新　{!! $manual->updated_at ? $manual->updated_at->format('Y/n/j｜H:i:s') : 'なし' !!}</div>
              <div class="d-flex align-items-center w-100 justify-content-end flex-wrap"><i class="ph ph-user text-dark me-2"></i>最終更新ユーザー　{!! $manual->updater_id ? getNamefromUserId($manual->updater_id,'U') : 'なし' !!}</div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body border-top p-4 fs-4 notification-body">
        {!! $manual->note !!}
      </div>
    </div>
    
	</div>
</div>
@endsection

@include('common.footer')