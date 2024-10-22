@extends('common.layout')

@section('title',       'シフト集計')
@section('description', '')
@section('keywords',    '')

@include('common.head')
@include('common.header')
@include('common.aside')

@section('contents')
@php 
  $users = [];
  $days  = [];
@endphp

<script src="@asset('/js/chart.js')"></script>

<style>
  .total-table,
  .total-table th,
  .total-table td{
    border: solid 1px #595959;
    border-collapse: collapse;
  }

  .total-table th,
  .total-table td{
    padding: 3px;
  }

  .total-table thead{
    background: #c5c5c5;
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

    <div class="location-list">
      <div class="card p-0">
        <div class="card-body p-3">
          <form method="get">
            <div class="mb-3">
            @foreach($admins as $admin)
            <div class="form-check form-check-inline">
              <input class="form-check-input success check-light-success" type="checkbox" id="success-light-check{{ $admin->id }}" value="{{ $admin->id }}" name="register_id[]" @if($registers && in_array($admin->id, $registers)) checked @endif>
              <label class="form-check-label" for="success-light-check{{ $admin->id }}">{{ getNamefromUserId($admin->id,'A') }}</label>
            </div>
            @endforeach
            </div>
            <div class="d-flex justify-content-between flex-wrap align-items-end">
              <div class="input-group w-auto mb-md-0 mb-3">
                <div class="input-group-text">
                  集計期間
                </div>
                <input class="form-control" type="month" name="month" value="{{ $request->month ? $request->month : now()->format('Y-m') }}">
                <button class="btn bg-primary-subtle text-primary" type="submit">
                  <i class="ph ph-chart-line me-2"></i>集計する
                </button>
              </div>

              <div>
                <label class="form-label">並び替え</label>
                <select class="form-select" name="status" onChange="search(this);">
                  @foreach(App\Models\Shift::SORT as $in => $sort)
                  <option value="{{ $in }}" {{ $request->status == $in ? 'selected' : '' }}>{{ $sort[0] }}</option>
                  @endforeach
                </select>
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>

    @if($totals)
    <p><span class="h4 me-2">{{ $request->month ? sprintf('%02d', substr($request->month, 0, 4)).'年'.sprintf('%02d', substr($request->month, 5, 2)).'月' : sprintf('%02d', substr(now()->format('Y-m'), 0, 4)).'年'.sprintf('%02d', substr(now()->format('Y-m'), 5, 2)).'月' }}</span>の集計結果</p>
    <div class="row">
      <div class="col-auto mb-3">
        <table class="total-table text-dark" border="1">
          <thead>
            <tr>
              <th>ユーザー名</th>
              <th>出勤日数</th>
              <th>月合計勤務時間</th>
            </tr>
          </thead>
          <tbody>
          @foreach($totals as $total)
          <tr>
            <td class="user_id">{{ getNamefromUserId($total['user_id']) }}</td>
            <td class="days text-end font-monospace">{{ $total['days'] }}</td>
            <td class="secs text-end font-monospace">{{ getHourMinute($total['secs']) }}</td>
          </tr>

          @php 
            $users[] = '"'.getNamefromUserId($total['user_id']).'"';
            $days[]  = '"'.$total['days'].'"';
          @endphp

          @endforeach
          </tbody>
        </table>
      </div>
      <div class="col-auto">
        <canvas id="barChart"></canvas>
      </div>
      @endif
    </div>

  </div>
</div>

<script>
// 出勤日数グラフの設定
let barCtx = document.getElementById("barChart");
let barConfig = {
  type: 'bar',
  data: {
    labels: [{!! implode(",", $users) !!}],
    datasets: [{
      data: [{!! implode(",", $days) !!}],
      label: '出勤日数',
      backgroundColor: ['#FF6384'],
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: {
        ticks: {
          stepSize: 1,
        }
      }
    }
  }
};
let barChart = new Chart(barCtx, barConfig);
</script>
@endsection

@include('common.footer')