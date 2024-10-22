@extends('common.layout')

@section('title',       'お知らせの詳細')
@section('description', '')
@section('keywords',    '')

@include('common.head')
@include('common.header')
@include('common.aside')

@section('contents')

<div class="body-wrapper">
	<div class="container-fluid">

    @include('common.alert')

    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card overflow-hidden">
          <div class="position-relative">
            @if(getFirstImage($notice->note))
            <img src="@asset({{getFirstImage($notice->note)}})" class="card-img-top rounded-0 object-fit-cover" alt="modernize-img" height="100">
            @else
            <img src="@asset('/thumb/no-bg.svg')" class="card-img-top rounded-0 object-fit-cover" alt="modernize-img" height="100">
            @endif
            <div class="position-absolute w-100 h-100 bg-dark opacity-25 top-0"></div>
            <span class="badge text-bg-light mb-9 me-9 position-absolute bottom-0 end-0">@if($notice->updated_at)<i class="ph ph-clock-clockwise text-dark me-2"></i>{{ $notice->updated_at->format('Y/n/j') }}に更新されています @else 更新はありません@endif</span>
            <img src="{{ getUserImage($notice->register_id) }}" alt="modernize-img" class="object-fit-cover img-fluid rounded-circle position-absolute bottom-0 start-0 mb-n9 ms-9" style="width: 40px;height: 40px;">
            @if($role)<a href="/notification/edit/{{ $notice->id }}" class="text-bg-primary fs-6 rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n9 me-9" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="編集する"><i class="ph ph-pencil-line fs-6"></i></a>@endif
          </div>
          <div class="card-body p-4">
            <span class="badge text-bg-light mt-3">投稿者：{{ getNamefromUserId($notice->register_id,'U') }}</span>
            <h2 class="fs-7 fw-semibold mt-4 mb-2">{{ $notice->title }}</h2>
            <div class="d-flex align-items-center gap-4 justify-content-between flex-wrap">
              <div class="d-flex align-items-center d-md-br-none">
                @if($notice->started_at || $notice->ended_at)
                  表示期間｜{!! App\Models\Notification::getPeriod($notice) !!}
                @else
                  <span class="text-muted">設定なし</span>
                @endif
              </div>
              <div class="d-flex align-items-center fs-2 ms-auto">
                <i class="ph ph-pencil-line text-dark"></i>　{{ $notice->created_at->format('Y/n/j') }}　{!! getStatus('公開','非公開',$notice->status) !!}
              </div>
            </div>
          </div>
          <div class="card-body border-top p-4 fs-4 notification-body">
            {!! $notice->note !!}
          </div>
        </div>
      </div>
    </div>
    
	</div>
</div>
@endsection

@include('common.footer')