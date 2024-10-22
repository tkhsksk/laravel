@extends('common.layout')

@section('title',       'トップ')
@section('description', '')
@section('keywords',    '')

@include('common.head')
@include('common.header')
@include('common.aside')

@section('contents')
<div class="body-wrapper">
	<div class="container-fluid">
    
    @include('common.alert')

		<div class="row">
      <!-- Weekly Stats -->
      <div class="col-lg-4 d-flex align-items-strech order-md-1 order-2">
        <div class="card w-100">
          <div class="card-body">
            <div class="d-flex justify-content-between mb-7 align-items-start">
              <div>
                <h5 class="card-title fw-semibold"><i class="ph ph-bell fs-5 me-2"></i>最新のお知らせ</h5>
                <p class="card-subtitle">会社に関するお知らせを通知します</p>
              </div>
              <a type="button" href="/notification/list" class="ms-3 d-flex" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="すべて見る">
                  <i class="ph ph-list-dashes fs-7" style="display: flex;"></i>
              </a>
            </div>
            @if($notifications->count() == 0)
            <div class="alert alert-light-danger bg-light-subtle fade show" role="alert">
              <div class="d-flex align-items-center justify-content-center flex-wrap">
                <div class="w-100">
                  <img src="@asset('/thumb/cry.svg')" style="max-width: 58px;" class="mx-auto d-block mb-2 pt-1">
                </div>
                <i class="ph ph-bell fs-5 me-2"></i>
                公開中のお知らせはありません
              </div>
            </div>
            @endif
            @foreach($notifications as $notification)
            <a class="d-flex align-items-center mb-3 pb-2" href="/notification/detail/{{ $notification->id }}">
              <div class="me-3 pe-1">
                @if(getFirstImage($notification->note))
                <img src="@asset({{getFirstImage($notification->note)}})" class="shadow-warning rounded-2 object-fit-cover" alt="" width="57" height="57">
                @else
                <img src="@asset('/thumb/no-bg.svg')" class="shadow-warning rounded-2 object-fit-cover" alt="" width="57" height="57">
                @endif
              </div>
              <div>
                <h5 class="fw-semibold fs-4 mb-2 lh-sm">
                  {{ $notification->title }}
                </h5>
                <p class="fs-3 mb-0"><i class="ph ph-calendar me-2"></i>{{ $notification->created_at->format('Y年n月j日') }}</p>
              </div>
            </a>
            @endforeach
            {{ $notifications->links('common.pager') }}
          </div>
        </div>
      </div>

      <div class="col-lg-8 d-flex align-items-strech order-md-2 order-1">
        <div class="card w-100">
          <div class="card-body">
            <div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
              <div class="mb-3 mb-sm-0">
                <h5 class="card-title fw-semibold"><i class="ph ph-clock-user fs-5 me-2"></i>{{ $shift ? ($shift == date('Y-m-d') ? '本日' : $shift) : '本日' }}のシフト（<span class="fw-normal px-2">{{ $depart_disp }}</span>）</h5>
                @if($shifts->count() != 0)
                <p class="card-subtitle mb-0">{{ $shift ? ($shift == date('Y-m-d') ? '本日' : $shift) : '本日' }}は<span class="badge text-bg-secondary fs-2 rounded-4 py-1 px-2 mx-2"><i class="ph ph-user me-1"></i><span class="fw-semibold me-1">{{ $shifts->count() }}</span>人</span>で頑張りましょう！</p>
                @else
                <p class="card-subtitle mb-0">確定シフトはありません</p>
                @endif
              </div>
              <div class="d-flex align-items-center">
                <form>
                  <div class="input-group">
                    <input class="form-control" name="shift" type="date" value="{{ $shift ?? date('Y-m-d') }}" onChange="search(this);">
                  </div>
                </form>
                <a type="button" href="/shift/calendar" class="ms-3 d-flex" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="カレンダーで見る">
                    <i class="ph ph-calendar fs-7" style="display: flex;"></i>
                </a>
              </div>
            </div>
            @if($shifts->count() == 0)
              <div class="alert alert-light-danger bg-light-subtle fade show" role="alert">
                <div class="d-flex align-items-center justify-content-center flex-wrap">
                  <div class="w-100">
                    <img src="@asset('/thumb/cry.svg')" style="max-width: 58px;" class="mx-auto d-block mb-2 pt-1">
                  </div>
                  <i class="ph ph-clock-user fs-5 me-2"></i>
                  {{ $shift ? ($shift == date('Y-m-d') ? '本日' : $shift) : '本日' }}の確定シフトはありません
                </div>
              </div>
            @endif
            <div class="table-responsive">
              <table class="table align-middle text-nowrap mb-0">
                @if($shifts->count() != 0)
                <thead>
                  <tr class="text-muted fw-semibold">
                    <th scope="col" class="ps-0">ユーザー名</th>
                    <th scope="col">勤務時間</th>
                    <th scope="col">承認状態</th>
                    <th scope="col">申請日</th>
                  </tr>
                </thead>
                @endif
                <tbody class="border-top">
                  @foreach($shifts as $shift)
                  <tr>
                    <td class="ps-0">
                      <div class="d-flex align-items-center">
                        <div class="me-2 pe-1">
                          <a href="/shift/detail/{{ $shift->id }}"><img src="{{ getUserImage($shift->register_id) }}" class="rounded-circle object-fit-cover" width="40" height="40" alt=""></a>
                        </div>
                        <div>
                          <h6 class="fw-semibold mb-1">{{ getNamefromUserId($shift->register_id,'A') }}</h6>
                          <p class="fs-2 mb-0 text-muted">
                            {{ App\Models\Admin::find($shift->register_id)->title }}
                          </p>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="mb-0 fs-3">{{ getShiftTime($shift->id) }}</p>
                    </td>
                    <td>
                      <span class="badge py-1 bg-{{ App\Models\Shift::STATUS[$shift->status][1] }}-subtle text-{{ App\Models\Shift::STATUS[$shift->status][1] }}">{{ App\Models\Shift::STATUS[$shift->status][0] }}</span>
                    </td>
                    <td>
                      <p class="fs-3 text-dark mb-0">{{ $shift->created_at->isoFormat('Y年M月D日(ddd)') }}</p>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
	</div>
</div>
@endsection

@include('common.footer')