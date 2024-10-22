@extends('common.layout')

@section('title',       'シフトカレンダー')
@section('description', '')
@section('keywords',    '')

@include('common.head')
@include('common.header')
@include('common.aside')

@section('contents')

<script>
function getShiftList(el) {
  part_val = $(el).attr('aria-label');
  modal    = $('#shiftmodal');
  result   = $('#shiftmodal .modal-body .shifts');
  label    = $(el).find('.getLabel').text();
  depart   = $(el).data('department');

  $('#shiftmodal').on('show.bs.modal', function (e) {
    $('#shiftmodal .modal-body .shifts').empty();
    modal.find('a.shiftTurnIn').attr('href','');
  });
  
  $.ajax({
      url: '{{ route('getshiftdata') }}',
      type: 'get',
      data: {val : part_val,dep : depart},
      datatype: 'json',
  })
  .done((data) => {
      modal.modal('show');
      result
      .append(
         '<h2 class="fs-6 mb-3">'
        +'<span class="fw-semibold">'+part_val.slice(0, 4)+'年'+Number(part_val.slice(5, 7))+'月'+Number(part_val.slice(8, 10))+'日</span>'
        +'<span class="fs-4 ps-1">のシフト一覧</span>'
        +'<span class="badge text-bg-secondary fs-2 rounded-4 py-1 px-2 ms-3"><i class="ph ph-user me-1"></i>'+data.length+'</span>'
        +'</h2>'
      );

      @can('isMasterOrAdmin')
      modal.find('a.shiftTurnIn').attr('href','{{ route('shift.admin.edit') }}?preferred_date='+part_val);
      @else
      modal.find('a.shiftTurnIn').attr('href','{{ route('shift.edit') }}?preferred_date='+part_val);
      @endcan

      if(data.length > 0) {
        $.each(data, function(index, value) {
          result
          .append(
             '<div class="col-12">'
            +'<a href="'+value.href+'" class="alert align-items-center d-flex justify-content-between customize-alert text-'+value.color+' alert-light-'+value.color+' bg-'+value.color+'-subtle" role="alert" target="_blank">'
            +'<div class="d-flex align-items-center"><img class="rounded-circle me-3 card-hover border border-1 bg-white border-white object-fit-cover" width="36" height="36" src="'+value.image+'">'
            +'<div><p class="d-flex align-items-center mb-0 fw-semibold">'+value.holiday+'<i class="ph ph-clock fs-5 me-1"></i>'+value.time+'</p>'
            +value.name
            +'</div></div>'
            +value.note
            +'</a>'
            +'</div>'
          );
        });
      } else {
        result
        .append(
           '<div class="col-12"><p class="text-center">'+label+'</p>'
          +'</div>'
        );
      }
  })
  .fail((data) => {
      console.log('失敗');
  });
};
</script>

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

    <div class="row justify-content-center app-calendar">
      <div class="col-lg-10">
        <div class="card">
          <div class="card-body p-md-4 p-2">

            <div class="row mb-3">
              <div class="col-md-4 col-6 d-flex align-items-center order-md-1 order-1 back-this-month">
                @if(now()->format('Y-n') != $thisMonth->format('Y-n'))
                <a href="/shift/calendar?depart={{ $requests->depart }}" type="button" class="justify-content-center btn mb-1 btn-rounded btn-light text-dark  d-flex text-dark align-items-center">
                  <i class="ph ph-calendar fs-4 me-2"></i>
                  今月に戻る
                </a>
                @endif
              </div>

              <div class="col-md-4 d-flex align-items-center justify-content-center order-md-2 order-3 d-month">
                <div class="text-center fs-6 text-primary d-flex align-items-center">
                    <i class="ph ph-calendar me-2 fs-6"></i>{{ $thisMonth->format('Y年 n月') }}
                </div>
              </div>
              <div class="col-md-4 col-6 justify-content-end d-flex align-items-center order-md-3 order-2 shift-calendar-switch-month">
                <div class="btn-group mb-2" role="group" aria-label="Basic example">
                  <a type="button" class="btn bg-secondary-subtle text-secondary " href="{{url()->current().'?year='.$previousMonth->format('Y').'&month='.$previousMonth->format('m').'&depart='.$requests->depart}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="前月へ">
                    <i class="ph ph-caret-left fw-semibold"></i>
                  </a>
                  <a type="button" class="btn bg-secondary-subtle text-secondary ms-2" href="{{url()->current().'?year='.$nextMonth->format('Y').'&month='.$nextMonth->format('m').'&depart='.$requests->depart}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="次月へ">
                    <i class="ph ph-caret-right fw-semibold"></i>
                  </a>
                </div>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-8 d-flex align-items-end flex-wrap mb-md-0 mb-3 shift-calendar-text">
                @can('isMasterOrAdmin')
                <p class="mb-2 fw-semibold d-flex align-items-center text-dark w-100"><i class="ph ph-medal-military me-2 fs-5"></i>管理者・マスター権限の方へ</p>
                <p class="mb-0 card-subtitle">
                  全てのユーザーの<span class="text-primary badge bg-primary-subtle mx-2">新規</span><span class="text-success-new badge bg-success-new-subtle me-2">承認済</span>ステータスのシフトが表示されます。
                </p>
                @endcan

                @can('isBasic')
                <p class="mb-2 fw-semibold d-flex align-items-center text-dark"><i class="ph ph-medal-military me-2 fs-5"></i>一般権限の方へ</p>
                <p class="mb-0 card-subtitle">
                  自分以外のユーザーのシフトは<span class="text-success-new badge bg-success-new-subtle mx-2">承認済</span>ステータスの場合のみ表示されます。<br /><span class="text-primary badge bg-primary-subtle me-2">新規</span>ステータスのシフトはあなたが提出したシフトのみ表示されます。
                </p>
                @endcan
              </div>

              <div class="col-md-4 shift-calendar-switch">
                <form class="d-flex justify-content-end">
                  <div class=" w-100">
                    <label for="exampleInputEmail1" class="form-label"><i class="ph ph-bird me-2"></i>表示切り替え</label>
                    <select class="form-select" name="depart" onChange="search(this);">
                      <option value="">すべて表示</option>
                      <option value="self" @if($requests->depart == 'self')selected @endif>{{ Auth::user()->name }}（あなた）だけ</option>
                      @foreach(App\Models\Department::all() as $department)
                      <option value="{{ $department->id }}" @if($department->id == $requests->depart)selected @endif>{{ $department->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <input type="hidden" name="year" value="{{ $requests->year }}">
                  <input type="hidden" name="month" value="{{ $requests->month }}">
                </form>
              </div>
            </div>

            <div class="calendar-grid text-center">
              @foreach($weekNames as $weekName)
              <div class="calendar-grid-weeks">
                  <div class="fs-3">{{$weekName}}</div>
              </div>
              @endforeach
            </div>

            <div class="calendar-grid border-top">
                @foreach($calendarDays as $in => $calendarDay)
                <div class="day-block border-bottom border-start p-1 @if(($in+1) % 7 == 0) saturday @endif @if($in % 7 == 0) sunday  @endif @if($calendarDay['holidayName']) holiday @endif @if($calendarDay['status']) otherMonth @endif" onclick="getShiftList(this);" aria-label="{{$calendarDay['date']->format('Y-m-d')}}" role="button" data-department="{{ $requests->depart }}">
                    @if($calendarDay['show'])
                    <div class="d-flex justify-content-end mb-1 fw-semibold">
                      <span class=" @if($thisMonth->format('Y-n-').$calendarDay['date']->format('d') == \Carbon\Carbon::now()->format('Y-n-d'))bg-primary rounded-circle text-white px-1 fw-normal @endif">{{$calendarDay['date']->format('j')}}</span>
                    </div>

                      @if($calendarDay['holidayName'])
                        <p class="lh-sm holidayName getLabel">{{ $calendarDay['holidayName'] }}</p>
                      @else
                        @if(count($calendarDay['schedules']) == 0)
                          @if(($in+1) % 7 == 0 || $in % 7 == 0)
                            <p class="lh-sm d-md-block d-none text-dark getLabel">お休み</p>
                            <p class="lh-sm d-md-none d-block text-dark">休</p>
                          @else
                          <p class="opacity-50 lh-sm d-md-block d-none getLabel">シフトは<br class="d-none d-md-block" />ありません</p>
                          <span class="badge text-bg-light fs-2 rounded-4 py-1 px-2 w-100 d-md-none d-inline"><i class="ph ph-user me-1"></i>0</span>
                          @endif
                        @endif
                      @endif

                      <div class="d-md-block d-none">
                      @if(count($calendarDay['schedules']) <= 3)
                        @foreach($calendarDay['schedules'] as $schedule)
                          <div class="@if($schedule->status == 'N')bg-primary-subtle text-primary @elseif($schedule->status == 'E') bg-success-new-subtle text-success-new @endif px-2 py-1 text-nowrap name mb-1 d-block rounded rounded-1"><span class="fw-semibold fs-2 me-2">@if($schedule->holiday == 'E')<i class="ph ph-island me-2 text-dark"></i> @endif{{ $schedule->preferred_hr_st }}:{{ sprintf('%02d', $schedule->preferred_min_st) }}〜</span>{{ getNamefromUserId($schedule->register_id,'F') }}</div>
                        @endforeach
                      @else
                        @foreach($calendarDay['schedules'] as $schedule)
                          @if($loop->iteration <= 3)
                          <div class="@if($schedule->status == 'N')bg-primary-subtle text-primary @elseif($schedule->status == 'E') bg-success-new-subtle text-success-new @endif px-2 py-1 text-nowrap name mb-1 d-block rounded rounded-1"><span class="fw-semibold fs-2 me-2">@if($schedule->holiday == 'E')<i class="ph ph-island me-2 text-dark"></i> @endif{{ $schedule->preferred_hr_st }}:{{ sprintf('%02d', $schedule->preferred_min_st) }}〜</span>{{ getNamefromUserId($schedule->register_id,'F') }}</div>
                          @else

                          <div class="@if($schedule->status == 'N')bg-primary-subtle text-primary @elseif($schedule->status == 'E') bg-success-new-subtle text-success-new @endif px-2 py-1 text-nowrap name mb-1 d-block rounded rounded-1 d-none for-print-label"><span class="fw-semibold fs-2 me-2">@if($schedule->holiday == 'E')<i class="ph ph-island me-2 text-dark"></i> @endif{{ $schedule->preferred_hr_st }}:{{ sprintf('%02d', $schedule->preferred_min_st) }}〜</span>{{ getNamefromUserId($schedule->register_id,'F') }}</div>

                            @if($loop->last)
                            <div class="d-flex justify-content-end for-notprint-label">
                              <div class="mb-1 badge rounded-pill text-bg-light"><i class="ph ph-user"></i>+{{ count($calendarDay['schedules'])-3 }}</div>
                            </div>
                            @endif
                          @endif
                        @endforeach
                      @endif
                      </div>
                      <div class="d-md-none d-block">
                        @if(count($calendarDay['schedules']) > 0)
                        <span class="badge text-bg-secondary fs-2 rounded-4 py-1 px-2 w-100"><i class="ph ph-user me-1"></i>{{ count($calendarDay['schedules']) }}</span>
                        @endif
                      </div>

                    @endif
                </div>
                @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
    
	</div>
</div>

<div class="modal fade" id="shiftmodal" tabindex="-1" aria-labelledby="shiftmodalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0">
      <div class="modal-header bg-info-subtle rounded-top">
        <h6 class="modal-title text-dark d-flex fw-semibold"><i class="ph ph-clock-user fs-6 me-2"></i><span class="font-weight-medium fs-3">当日のシフト一覧</span></h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-break">
        <div class="row mb-3">
          <div class="col-md-8 offset-md-2 col-12">
            <a class="shiftTurnIn d-flex align-items-center btn justify-content-center text-dark"><img src="@asset('/thumb/smile.svg')" style="max-width: 30px;" class="me-2">この日にシフトを提出する</a>
          </div>
        </div>
        <div class="row shifts">
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@include('common.footer')