@extends('common.layout')

@section('title',       'みんなのタスク一覧')
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
              <img src="@asset('/image/titleBg.svg')" alt="" class="img-fluid mb-n3">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-between align-items-center gap-6 mb-9">
      <form class="position-relative">
        <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh" placeholder="Search Product">
        <i class="ph ph-magnifying-glass position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
      </form>
      <a class="fs-6 text-muted" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Filter list"><i class="ti ti-filter"></i></a>
      <div class="d-flex gap-6">
        <a href="/task/edit" class="btn btn-primary d-flex align-items-center px-3 gap-6">
          <i class="ph ph-kanban fs-5"></i>
          <span class="d-none d-md-block font-weight-medium fs-3">タスクを追加する</span>
        </a>
      </div>
    </div>

    <div class="col-xl-10 offset-xl-1">
      <div class="scrumboard" id="cancel-row">
        <div class="layout-spacing pb-3">
            <div data-simplebar="init" class="">
                <div class="simplebar-wrapper" style="margin: 0px;">
                    <div class="simplebar-height-auto-observer-wrapper">
                        <div class="simplebar-height-auto-observer"></div>
                    </div>
                    <div class="simplebar-mask">
                        <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                            <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden;">
                                <div class="simplebar-content" style="padding: 0px;">
                                    <div class="task-list-section">
                                        <div data-item="item-todo" class="task-list-container" data-action="sorting">
                                            <div class="connect-sorting connect-sorting-inprogress">
                                                <div class="task-container-header">
                                                    <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="Todo">すべての{{ App\Models\Task::STATUS['N'][0] }}タスク</h6>
                                                    <div class="hstack gap-2">
                                                        <div class="add-kanban-title">
                                                            <a class="addTask d-flex align-items-center justify-content-center gap-1 lh-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add Task">
                                                                <i class="ti ti-plus text-dark"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="connect-sorting-content ui-sortable" data-sortable="true">
                                                    
                                                  @foreach($tasksNew as $task)
                                                  <div data-draggable="true" class="card img-task ui-sortable-handle">
                                                    <div class="card-body">
                                                      <div class="task-header">
                                                        <div class="tb-section-2">
                                                            <span class="badge text-bg-primary fs-1">{{ $task->taskCategory->name }}</span>
                                                        </div>
                                                        <div class="dropdown">
                                                          <a class="dropdown-toggle" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="ph ph-dots-three-vertical text-dark"></i>
                                                          </a>
                                                          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1" style="">
                                                            <a class="dropdown-item kanban-item-delete cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);">
                                                              <i class="ph ph-check fs-5 me-2"></i>確認する
                                                            </a>
                                                            <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);">
                                                              <i class="ph ph-pencil-line fs-5 me-2"></i>編集する
                                                            </a>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class="task-header pt-0 px-3">
                                                        <h4 class="fs-4"><a href="/task/detail/{{ $task->id }}">{{ Str::limit($task->note, 40) }}</a></h4>
                                                      </div>

                                                      <div class="task-header pt-0 px-3">
                                                      @if($task->preferred_date)
                                                        <span class="mb-1 badge rounded-pill text-bg-warning fs-2">{{ getDateLimit($task->preferred_date, $task->preferred_hr, $task->preferred_min) }}</span>
                                                      @else
                                                        <span class="mb-1 badge rounded-pill text-bg-light fs-2">期限なし</span>
                                                      @endif
                                                      </div>

                                                      <div class="d-flex align-items-center width py-1 px-3">

                                                        <div class="text-center">
                                                          <a href="/user/detail/{{ $task->register_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ getNamefromUserId($task->register_id,'U') }}"><img src="{{ getUserImage($task->register_id) }}" class="rounded-circle object-fit-cover card-hover" width="34" height="34"></a>
                                                        </div>

                                                        <div class="text-center px-1">
                                                          <i class="ph ph-caret-right fs-6 fw-semibold text-muted"></i>
                                                        </div>

                                                        <div class="text-center">
                                                          <a href="/user/detail/{{ $task->charger_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ getNamefromUserId($task->charger_id,'U') }}"><img src="{{ getUserImage($task->charger_id) }}" class="rounded-circle object-fit-cover card-hover" width="34" height="34"></a>
                                                        </div>

                                                      </div>

                                                      <div class="task-body">
                                                        <div class="task-bottom d-block">
                                                          <span class="hstack gap-2 fs-2 justify-content-end">
                                                            <i class="ph ph-calendar fs-5"></i> {{ $task->created_at->isoFormat('YYYY年M月D日(ddd)　H:mm') }}
                                                          </span>
                                                          <span class="hstack gap-2 fs-2 justify-content-end">
                                                            <i class="ph ph-clock-counter-clockwise fs-5"></i> {{ $task->updated_at ? $task->updated_at->isoFormat('YYYY年M月D日(ddd)　H:m:ss') : $task->created_at->isoFormat('YYYY年M月D日(ddd)　H:mm') }}
                                                          </span>
                                                        </div>
                                                      </div>

                                                    </div>
                                                  </div>
                                                  @endforeach

                                                  <ul class="pagination pagination-sm mb-0 justify-content-end">
                                                    <li class="page-item active" aria-current="page">
                                                      <span class="page-link">1</span>
                                                    </li>
                                                    <li class="page-item">
                                                      <a class="page-link" href="javascript:void(0)">2</a>
                                                    </li>
                                                    <li class="page-item">
                                                      <a class="page-link" href="javascript:void(0)">3</a>
                                                    </li>
                                                  </ul>

                                                </div>
                                            </div>
                                        </div>

                                        <div data-item="item-inprogress" class="task-list-container" data-action="sorting">
                                            <div class="connect-sorting connect-sorting-todo">
                                                <div class="task-container-header">
                                                    <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="In Progress">すべての{{ App\Models\Task::STATUS['P'][0] }}タスク</h6>
                                                </div>
                                                @foreach($tasksPro as $task)
                                                  <div data-draggable="true" class="card img-task ui-sortable-handle">
                                                    <div class="card-body">
                                                      <div class="task-header">
                                                        <div class="tb-section-2">
                                                            <span class="badge text-bg-primary fs-1">{{ $task->taskCategory->name }}</span>
                                                        </div>
                                                        <div class="dropdown">
                                                          <a class="dropdown-toggle" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="ph ph-dots-three-vertical text-dark"></i>
                                                          </a>
                                                          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1" style="">
                                                            <a class="dropdown-item kanban-item-delete cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);">
                                                              <i class="ph ph-check fs-5 me-2"></i>確認する
                                                            </a>
                                                            <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);">
                                                              <i class="ph ph-pencil-line fs-5 me-2"></i>編集する
                                                            </a>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class="task-header pt-0 px-3">
                                                        <h4 class="fs-4"><a href="/task/detail/{{ $task->id }}">{{ Str::limit($task->note, 40) }}</a></h4>
                                                      </div>

                                                      <div class="task-header pt-0 px-3">
                                                      @if($task->preferred_date)
                                                        <span class="mb-1 badge rounded-pill text-bg-warning fs-2">{{ getDateLimit($task->preferred_date, $task->preferred_hr, $task->preferred_min) }}</span>
                                                      @else
                                                        <span class="mb-1 badge rounded-pill text-bg-light fs-2">期限なし</span>
                                                      @endif
                                                      </div>

                                                      <div class="d-flex align-items-center width py-1 px-3">

                                                        <div class="text-center">
                                                          <a href="/user/detail/{{ $task->register_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ getNamefromUserId($task->register_id,'U') }}"><img src="{{ getUserImage($task->register_id) }}" class="rounded-circle object-fit-cover card-hover" width="34" height="34"></a>
                                                        </div>

                                                        <div class="text-center px-1">
                                                          <i class="ph ph-caret-right fs-6 fw-semibold text-muted"></i>
                                                        </div>

                                                        <div class="text-center">
                                                          <a href="/user/detail/{{ $task->charger_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ getNamefromUserId($task->charger_id,'U') }}"><img src="{{ getUserImage($task->charger_id) }}" class="rounded-circle object-fit-cover card-hover" width="34" height="34"></a>
                                                        </div>

                                                      </div>

                                                      <div class="task-body">
                                                        <div class="task-bottom d-block">
                                                          <span class="hstack gap-2 fs-2 justify-content-end">
                                                            <i class="ph ph-calendar fs-5"></i> {{ $task->created_at->isoFormat('YYYY年M月D日(ddd)　H:mm') }}
                                                          </span>
                                                          <span class="hstack gap-2 fs-2 justify-content-end">
                                                            <i class="ph ph-clock-counter-clockwise fs-5"></i> {{ $task->updated_at ? $task->updated_at->isoFormat('YYYY年M月D日(ddd)　H:m:ss') : $task->created_at->isoFormat('YYYY年M月D日(ddd)　H:mm') }}
                                                          </span>
                                                        </div>
                                                      </div>

                                                    </div>
                                                  </div>
                                                  @endforeach

                                                  <ul class="pagination pagination-sm mb-0 justify-content-end">
                                                    <li class="page-item active" aria-current="page">
                                                      <span class="page-link">1</span>
                                                    </li>
                                                    <li class="page-item">
                                                      <a class="page-link" href="javascript:void(0)">2</a>
                                                    </li>
                                                    <li class="page-item">
                                                      <a class="page-link" href="javascript:void(0)">3</a>
                                                    </li>
                                                  </ul>

                                            </div>
                                        </div>

                                        <div data-item="item-pending" class="task-list-container" data-action="sorting">
                                            <div class="connect-sorting connect-sorting-done">
                                                <div class="task-container-header">
                                                    <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="Pending">すべての{{ App\Models\Task::STATUS['E'][0] }}タスク</h6>
                                                </div>
                                                @foreach($tasksEnd as $task)
                                                  <div data-draggable="true" class="card img-task ui-sortable-handle">
                                                    <div class="card-body">
                                                      <div class="task-header">
                                                        <div class="tb-section-2">
                                                            <span class="badge text-bg-primary fs-1">{{ $task->taskCategory->name }}</span>
                                                        </div>
                                                        <div class="dropdown">
                                                          <a class="dropdown-toggle" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="ph ph-dots-three-vertical text-dark"></i>
                                                          </a>
                                                          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1" style="">
                                                            <a class="dropdown-item kanban-item-delete cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);">
                                                              <i class="ph ph-check fs-5 me-2"></i>確認する
                                                            </a>
                                                            <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);">
                                                              <i class="ph ph-pencil-line fs-5 me-2"></i>編集する
                                                            </a>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class="task-header pt-0 px-3">
                                                        <h4 class="fs-4"><a href="/task/detail/{{ $task->id }}">{{ Str::limit($task->note, 40) }}</a></h4>
                                                      </div>

                                                      <div class="task-header pt-0 px-3">
                                                      @if($task->preferred_date)
                                                        <span class="mb-1 badge rounded-pill text-bg-warning fs-2">{{ getDateLimit($task->preferred_date, $task->preferred_hr, $task->preferred_min) }}</span>
                                                      @else
                                                        <span class="mb-1 badge rounded-pill text-bg-light fs-2">期限なし</span>
                                                      @endif
                                                      </div>

                                                      <div class="d-flex align-items-center width py-1 px-3">

                                                        <div class="text-center">
                                                          <a href="/user/detail/{{ $task->register_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ getNamefromUserId($task->register_id,'U') }}"><img src="{{ getUserImage($task->register_id) }}" class="rounded-circle object-fit-cover card-hover" width="34" height="34"></a>
                                                        </div>

                                                        <div class="text-center px-1">
                                                          <i class="ph ph-caret-right fs-6 fw-semibold text-muted"></i>
                                                        </div>

                                                        <div class="text-center">
                                                          <a href="/user/detail/{{ $task->charger_id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ getNamefromUserId($task->charger_id,'U') }}"><img src="{{ getUserImage($task->charger_id) }}" class="rounded-circle object-fit-cover card-hover" width="34" height="34"></a>
                                                        </div>

                                                      </div>

                                                      <div class="task-body">
                                                        <div class="task-bottom d-block">
                                                          <span class="hstack gap-2 fs-2 justify-content-end">
                                                            <i class="ph ph-calendar fs-5"></i> {{ $task->created_at->isoFormat('YYYY年M月D日(ddd)　H:mm') }}
                                                          </span>
                                                          <span class="hstack gap-2 fs-2 justify-content-end">
                                                            <i class="ph ph-clock-counter-clockwise fs-5"></i> {{ $task->updated_at ? $task->updated_at->isoFormat('YYYY年M月D日(ddd)　H:m:ss') : $task->created_at->isoFormat('YYYY年M月D日(ddd)　H:mm') }}
                                                          </span>
                                                        </div>
                                                      </div>

                                                    </div>
                                                  </div>
                                                  @endforeach

                                                  <ul class="pagination pagination-sm mb-0 justify-content-end">
                                                    <li class="page-item active" aria-current="page">
                                                      <span class="page-link">1</span>
                                                    </li>
                                                    <li class="page-item">
                                                      <a class="page-link" href="javascript:void(0)">2</a>
                                                    </li>
                                                    <li class="page-item">
                                                      <a class="page-link" href="javascript:void(0)">3</a>
                                                    </li>
                                                  </ul>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="simplebar-placeholder" style="width: 1170px; height: 737px;"></div>
                </div>
                <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                    <div class="simplebar-scrollbar" style="width: 0px; display: none; transform: translate3d(136px, 0px, 0px);"></div>
                </div>
                <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                    <div class="simplebar-scrollbar" style="height: 0px; display: none;"></div>
                </div>
            </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@include('common.footer')