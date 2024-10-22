@extends('common.layout')

@section('title',       'シフトの編集')
@section('description', '')
@section('keywords',    '')

@include('common.head')
@include('common.header')
@include('common.aside')

@section('contents')
<script src="@asset('/js/dualbox/jquery.bootstrap-duallistbox.js')"></script>
<style>
  .bootstrap-duallistbox-container .buttons{
    display: none;
  }
</style>
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
                @isset($shift->id)
                <li class="breadcrumb-item">
                  <a class="text-muted text-decoration-none" href="/shift/detail/{{ $shift->id }}">シフトの詳細</a>
                </li>
                @endisset
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

    <form action="{{ route('shift.confirm') }}" class="h-adr" novalidate="novalidate" method="post">
    @csrf
      <div class="row justify-content-center">
        <div class="col-lg-9">
          <div class="card">
            <div class="card-body p-4">

              <div class="d-flex flex-wrap justify-content-between">
                <div>
                  <p class="mb-4 h5 d-flex">必須項目を全て入力して右下の「確認する」をクリックして下さい</p>
                  <div class="d-flex align-items-center gap-6 flex-wrap mb-4">
                    @if($shift)
                    <a href="/user/detail/{{ $shift->register_id }}"><img src="{{ getUserImage($shift->register_id) }}" alt="modernize-img" class="rounded-circle object-fit-cover" width="40" height="40"></a>
                    <h4 class="fw-semibold d-flex align-items-center mb-0 h6"><a href="/user/detail/{{ $shift->register_id }}">{{ getNamefromUserId($shift->register_id,'A') }}</a></h4>
                    <input type="hidden" name="register_id" value="{{ $shift->register_id }}">
                    @else
                    <a href="/user/detail/{{ Auth::user()->id }}"><img src="{{ getUserImage(Auth::user()->id) }}" alt="modernize-img" class="rounded-circle object-fit-cover" width="40" height="40"></a>
                    <h4 class="fw-semibold d-flex align-items-center mb-0 h6"><a href="/user/detail/{{ Auth::user()->id }}">{{ getNamefromUserId(Auth::user()->id,'A') }}</a></h4>
                    <input type="hidden" name="register_id" value="{{ Auth::user()->id }}">
                    @endif
                  </div>
                </div>

                <div>
                  <div class="d-flex align-items-center">
                    @if($shift)
                    <span class="bg-{{ App\Models\Shift::STATUS[$shift->status][1] }} p-1 rounded-circle"></span>
                    <p class="mb-0 ms-2">{{ App\Models\Shift::STATUS[$shift->status][0] }}</p>
                    @else
                    <span class="bg-{{ App\Models\Shift::STATUS['N'][1] }} p-1 rounded-circle"></span>
                    <p class="mb-0 ms-2">{{ App\Models\Shift::STATUS['N'][0] }}</p>
                    @endif
                  </div>
                  <p class="text-muted mb-2">申請日：{{ $shift ? $shift->created_at->format('Y/n/j') : now()->format('Y/n/j').'（本日）' }}</p>
                  <div class="form-check form-switch py-2">
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="holiday" @if($shift)
                @if(old('holiday'))
                checked
                @else
                {{ $shift->holiday == 'E' ? 'checked' :'' }}
                @endif
              @else
              {{ !old('holiday') ?: 'checked' }}
              @endif>
                    <label class="form-check-label" for="flexSwitchCheckDefault"><i class="ph ph-island me-2"></i>有給として提出する</label>
                  </div>
                </div>
              </div>

              <input type="hidden" name="id" value="{{ $shift ? old('id',$shift->id) : '' }}">

              <div class="row mb-3">

                <div class="col-md-6">
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-calendar text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}シフト希望日</h5>
                        <div class="input-group">
                          <input type="date" id="preferred_date" name="preferred_date" class="form-control form-control-lg" value="@if($preferred_date){{ $preferred_date }}@else{{ $shift ? ($shift->preferred_date ? old('preferred_date',$shift->preferred_date->format('Y-m-d')) : old('preferred_date')) : old('preferred_date') }}@endif">
                          <button class="btn bg-primary-subtle text-primary  rounded-end" type="button" aria-label="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" onclick="inputToday(this);">
                            本日
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-toggle-left text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}シフトステータス</h5>
                        @if($shift)
                        <select class="form-select form-select-lg" aria-label="status" name="status">
                            @foreach($statuses as $index => $status)
                            <option value="{{ $index }}" {{ $shift ? (old('status',$shift->status) == $index ? 'selected' : '') : (old('status') == $index ? 'selected' : '') }}>{{ $status[0] }}</option>
                            @endforeach
                        </select>
                        @else
                        <div class="d-flex align-items-center">
                          <span class="bg-{{ App\Models\Shift::STATUS['N'][1] }} p-1 rounded-circle"></span>
                          <p class="mb-0 ms-2 fs-4">{{ App\Models\Shift::STATUS['N'][0] }}</p>
                        </div>
                        <input type="hidden" name="status" value="N">
                        @endif
                      </div>
                    </div>
                  </div>

                </div>

                <div class="col-12 mb-3">
                  <h5 class="fs-4 fw-semibold"><span class="badge fw-semibold bg-success-new-subtle text-success-new fs-1 me-2">新機能</span>かんたんシフト時刻選択</h5>
                  <div class="btn-toolbar mt-2" role="toolbar">
                    <div class="flex-wrap">
                      @foreach(App\Models\Shift::CHOICES as $choice)
                      <div class="js-programmatic-set-val btn bg-warning-subtle text-danger mb-2 me-2" data-preferred_hr_st="{{ $choice[0] }}" data-preferred_min_st="{{ $choice[1] }}" data-preferred_hr_end="{{ $choice[2] }}" data-preferred_min_end="{{ $choice[3] }}" onclick="inputShiftTime(this);">
                        <i class="ph ph-clock me-2"></i>{{ $choice[0] }}:{{ sprintf('%02d', $choice[1]) }} - {{ $choice[2] }}:{{ sprintf('%02d', $choice[3]) }}
                      </div>
                      @endforeach
                      <div class="js-programmatic-set-val btn bg-light-subtle text-dark mb-2 reset" data-preferred_hr_st="9" data-preferred_min_st="0" data-preferred_hr_end="9" data-preferred_min_end="0" onclick="inputShiftTime(this);">リセット
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-clock-user text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}シフト開始時刻</h5>
                        <div class="d-flex align-items-center">
                          <select class="form-select form-select-lg w-auto" aria-label="preferred_hr_st" name="preferred_hr_st">
                              @foreach($hours as $hour)
                                <option value="{{ $hour }}" {{ $shift ? (old('preferred_hr_st',$shift->preferred_hr_st) == $hour ? 'selected' : '') : (old('preferred_hr_st') == $hour ? 'selected' : '') }}>{{ $hour }}</option>
                              @endforeach
                          </select>
                          <span class="fs-6">：</span>
                          <select class="form-select form-select-lg w-auto" aria-label="preferred_min_st" name="preferred_min_st">
                              @foreach($mins as $min)
                                <option value="{{ $min }}" {{ $shift ? (old('preferred_min_st',$shift->preferred_min_st) == $min ? 'selected' : '') : (old('preferred_min_st') == $min ? 'selected' : '') }}>{{ sprintf('%02d', $min) }}</option>
                              @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-clock-user text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}シフト終了時刻</h5>
                        <div class="d-flex align-items-center">
                          <select class="form-select form-select-lg w-auto" aria-label="preferred_hr_end" name="preferred_hr_end">
                              @foreach($hours as $hour)
                                <option value="{{ $hour }}" {{ $shift ? (old('preferred_hr_end',$shift->preferred_hr_end) == $hour ? 'selected' : '') : (old('preferred_hr_end') == $hour ? 'selected' : '') }}>{{ $hour }}</option>
                              @endforeach
                          </select>
                          <span class="fs-6">：</span>
                          <select class="form-select form-select-lg w-auto" aria-label="preferred_min_end" name="preferred_min_end">
                              @foreach($mins as $min)
                                <option value="{{ $min }}" {{ $shift ? (old('preferred_min_end',$shift->preferred_min_end) == $min ? 'selected' : '') : (old('preferred_min_end') == $min ? 'selected' : '') }}>{{ sprintf('%02d', $min) }}</option>
                              @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <div class="card bg-primary-subtle rounded-2">
                <div class="card-body p-md-2 p-0">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="card mb-0">
                        <div class="card-body">
                          <h5 class="card-title fw-semibold">{!! $required_badge !!}承認者の選択</h5>
                          <p class="card-subtitle mb-4">承認するユーザーを左のボックスから選択して下さい</p>
                          <div class="">
                          <form id="equipments_form" action="#" method="post">
                            @csrf
                            <select size="" name="charger_id">
                              @foreach($admins as $admin)
                              <option value="{{ $admin->id }}"
                                @if($shift)
                                {{ $admin->id == $shift->charger_id ? 'selected' : '' }}
                                @else
                                  @if(Cookie::get('default_charger'))
                                    {{ $admin->id == Cookie::get('default_charger') ? 'selected' : '' }}
                                  @endif
                                @endif
                                >
                              {{ getNamefromUserId($admin->id,'A') }}</option>
                              @endforeach
                            </select>
                          </form>
                          <script>
                            var charger_check = $('select[name="charger_id"]')
                            .bootstrapDualListbox({
                              filterTextClear:      '<i class="ph ph-x fs-2"></i>',
                              filterPlaceHolder:    'ユーザーの検索',
                              moveSelectedLabel:    '選択済みに移動',
                              moveAllLabel:         '選択済みに全て移動',
                              removeSelectedLabel:  '選択を解除',
                              removeAllLabel:       '選択を全て解除',
                              nonSelectedListLabel: 'すべてのユーザー',
                              selectedListLabel:    '選択中の承認ユーザー',
                              infoText:             '（{0}件）',
                              infoTextEmpty:        '（0件）',
                              infoTextFiltered:     '（該当：{0}件 / 全{1}件）',
                            });
                          </script>

                          </div> 
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="p-4 rounded-2 text-bg-light">
                <label for="note" class="form-label"><i class="ph ph-list-dashes me-2"></i>シフトについての連絡事項</label>
                <textarea class="form-control bg-white" name="note" rows="7">{{ $shift ? old('note',$shift->note) : old('note') }}</textarea>
              </div>

              <div class="d-flex align-items-center justify-content-end mt-4 gap-6">
                <button onclick="submitButton(this);" class="btn btn-primary"><i class="ph ph-check fs-5 me-2"></i>
                  確認する</button>
                <button class="btn bg-danger-subtle text-danger" onClick="history.back()" type="button"><i class="ph ph-arrow-u-up-left fs-5 me-2"></i>戻る</button>
              </div>

            </div>
          </div>
        </div>
      </div>
    </form>
    
	</div>
</div>
@endsection

@include('common.footer')