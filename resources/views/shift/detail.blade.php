@extends('common.layout')

@section('title',       'シフトの詳細')
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
                  <a class="text-muted text-decoration-none" href="/shift">シフト一覧</a>
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
          <a href="/shift/edit/{{ $shift->id }}" class="text-bg-primary fs-6 rounded-circle p-2 text-white d-inline-flex position-absolute top-0 end-0 mt-n3 me-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="編集する"><i class="ph ph-pencil-line fs-6"></i></a>
          <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between">
              <div>
                <p class="mb-1">@if($shift->holiday == 'E') <i class="ph ph-island me-2"></i>有給@else シフト@endifのリクエスト</p>
                <h3 class="fw-semibold mb-4 d-flex align-items-end"><i class="ph ph-calendar me-2 fs-6"></i><span style="letter-spacing:.05rem" class="fs-8">{{ $shift->preferred_date->isoFormat('Y年M月D日 (ddd)') }}</span><i class="ph ph-clock-user me-2 ms-4 fs-6"></i><span class="fs-6">{{ getShiftTime($shift->id) }}</span></h3>

                <div class="d-flex align-items-center gap-6 flex-wrap mb-3">
                  <a href="/user/detail/{{ $shift->register_id }}"><img src="{{ getUserImage($shift->register_id) }}" alt="modernize-img" class="rounded-circle object-fit-cover" width="40" height="40"></a>
                  <h4 class="fw-semibold d-flex align-items-center mb-0 h6"><a href="/user/detail/{{ $shift->register_id }}">{{ getNamefromUserId($shift->register_id,'A') }}</a></h4>
                  <div class="text-center px-1">
                    <i class="ph ph-caret-right fs-6 fw-semibold text-muted"></i>
                  </div>
                  <a href="/user/detail/{{ $shift->charger_id }}"><img src="{{ getUserImage($shift->charger_id) }}" alt="modernize-img" class="rounded-circle object-fit-cover" width="40" height="40"></a>
                  <h4 class="fw-semibold d-flex align-items-center mb-0 h6"><a href="/user/detail/{{ $shift->charger_id }}">{{ getNamefromUserId($shift->charger_id,'A') }}</a></h4>
                </div>

              </div>
              <div>
                <div class="d-flex align-items-center">
                  <span class="bg-{{ App\Models\Shift::STATUS[$shift->status][1] }} p-1 rounded-circle"></span>
                  <p class="mb-0 ms-2">{{ App\Models\Shift::STATUS[$shift->status][0] }}</p>
                </div>
                <p class="text-muted mb-0">申請日：{{ $shift->created_at->format('Y/n/j') }}</p>
                <p class="text-muted">更新日：{!! $shift->updated_at ? $shift->updated_at->format('Y/n/j') : $shift->created_at->format('Y/n/j') !!}</p>
              </div>
            </div>

            <div class="p-4 rounded-2 text-bg-light d-flex">
              <i class="ph ph-list-dashes me-2 pt-1"></i><p class="mb-0 fs-3">{!! $shift->note ? nl2br($shift->note) : '<span class="text-muted">申請者メモなし</span>' !!}</p>
            </div>

            @if($shift->status == 'N')
            <div class="card bg-primary-subtle rounded-2 mt-4">
              <div class="card-body text-center">
                @if($shift->holiday == 'E')<h3 class="fw-semibold h4 d-flex align-items-center justify-content-center text-danger"><i class="ph ph-island fs-7 me-2"></i>これは有給の申請です</h3>@endif
                <div class="d-flex align-items-center justify-content-center mb-4 pt-8">
                  <a href="/user/detail/{{ $shift->charger_id }}">
                    <img src="{{ getUserImage($shift->charger_id) }}" class="rounded-circle me-n2 card-hover border border-2 border-white object-fit-cover" width="44" height="44">
                  </a>
                </div>
                <h3 class="fw-semibold h4 d-flex align-items-center justify-content-center"><i class="ph ph-check-circle fs-7 me-2 text-primary"></i><a class="text-primary" href="/user/detail/{{ $shift->charger_id }}">{{ getNamefromUserId($shift->charger_id,'A') }}</a> が承認者として指名されています</h3>
                <p class="fw-normal mb-4 fs-4">承認者の場合は、下のボタンをクリックするとそのまま承認できます</p>
                <a href="/shift/approval/{{ $shift->id }}" class="btn btn-primary mb-8"><span class="d-flex align-items-center"><i class="ph ph-check-circle me-1 text-white fs-5"></i>いますぐ承認する</span></a>
              </div>
            </div>
            @endif

          </div>
        </div>
      </div>
    </div>
    
	</div>
</div>
@endsection

@include('common.footer')