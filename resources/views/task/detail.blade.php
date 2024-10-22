@extends('common.layout')

@section('title',       'タスクの詳細')
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
                  <a class="text-muted text-decoration-none" href="/task">タスク一覧</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">@yield('title')</li>
              </ol>
            </nav>
          </div>
          <div class="col-3">
            <div class="text-center mb-n5">
              <img src="@asset('/image/titleBg.svg')" alt="" class="img-fluid mb-n3">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-9">
        <div class="card position-relative">
          <a href="/task/edit/{{ $task->id }}" class="text-bg-primary fs-6 rounded-circle p-2 text-white d-inline-flex position-absolute top-0 end-0 mt-n3 me-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="編集する"><i class="ph ph-pencil-line fs-6"></i></a>
          <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between">
              <div>
                <div class="d-flex align-items-center gap-6 flex-wrap mb-3">
                  <a href="/user/detail/{{ $task->register_id }}"><img src="{{ getUserImage($task->register_id) }}" alt="modernize-img" class="rounded-circle object-fit-cover" width="40" height="40"></a>
                  <h4 class="fw-semibold d-flex align-items-center mb-0 h6"><a href="/user/detail/{{ $task->register_id }}">{{ getNamefromUserId($task->register_id,'A') }}</a></h4>
                  <div class="text-center px-1">
                    <i class="ph ph-caret-right fs-6 fw-semibold text-muted"></i>
                  </div>
                  <a href="/user/detail/{{ $task->charger_id }}"><img src="{{ getUserImage($task->charger_id) }}" alt="modernize-img" class="rounded-circle object-fit-cover" width="40" height="40"></a>
                  <h4 class="fw-semibold d-flex align-items-center mb-0 h6"><a href="/user/detail/{{ $task->charger_id }}">{{ getNamefromUserId($task->charger_id,'A') }}</a></h4>
                </div>
              </div>
              <div>
                <div class="d-flex align-items-center">
                  <span class="bg-{{ App\Models\task::STATUS[$task->status][1] }} p-1 rounded-circle"></span>
                  <p class="mb-0 ms-2">{{ App\Models\task::STATUS[$task->status][0] }}</p>
                </div>
                <p class="text-muted mb-0">申請日：{{ $task->created_at->format('Y/n/j') }}</p>
                <p class="text-muted">更新日：{!! $task->updated_at ? $task->updated_at->format('Y/n/j') : $task->created_at->format('Y/n/j') !!}</p>
              </div>
            </div>

            <div class="p-4 rounded-2 text-bg-light d-flex">
              <i class="ph ph-list-dashes me-2 pt-1"></i><p class="mb-0 fs-3">{!! $task->note ? nl2br($task->note) : '<span class="text-muted">申請者メモなし</span>' !!}</p>
            </div>

          </div>
        </div>
      </div>
    </div>
    
	</div>
</div>
@endsection

@include('common.footer')