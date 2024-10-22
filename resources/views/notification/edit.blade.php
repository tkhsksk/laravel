@extends('common.layout')

@section('title',       'お知らせの編集')
@section('description', '')
@section('keywords',    '')

@include('common.head')
@include('common.header')
@include('common.aside')

@section('contents')
<link href="@asset('/css/bootstrap4-toggle.min.css')" rel="stylesheet">
<script src="@asset('/js/bootstrap4-toggle.min.js')"></script>
<script src="@asset('/js/dualbox/jquery.bootstrap-duallistbox.js')"></script>

<script>
  tinyMce('notification');
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
                <li class="breadcrumb-item">
                  <a class="text-muted text-decoration-none" href="/notification">お知らせ一覧</a>
                </li>
                @isset($notice->id)
                <li class="breadcrumb-item">
                  <a class="text-muted text-decoration-none" href="/notification/detail/{{ $notice->id }}">お知らせの詳細</a>
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

    <form action="{{ route('notification.confirm') }}" class="h-adr" novalidate="novalidate" method="post">
    @csrf
      <div class="row justify-content-center">
        <div class="col-lg-9">
          <div class="card">
            <div class="card-body p-4">

              <h4 class="card-title fw-semibold mb-3">@yield('title')項目</h4>
              <p class="card-subtitle mb-5 lh-base">必須項目を全て入力して左下の「確認する」をクリックして下さい</p>

              <input type="hidden" name="id" value="{{ $notice ? old('id',$notice->id) : '' }}">
              <input type="hidden" name="register_id" value="{{ Auth::user()->id }}">

              <div class="row mb-3">
                <div class="col-12">
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3 w-100">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-text-h-one text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div class=" w-100">
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}お知らせタイトル</h5>
                        <input type="text" class="form-control form-control-lg" id="title" name="title" value="{{ $notice ? old('title',$notice->title) : old('title') }}">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3 w-100">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-medal-military text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div class="row w-100">
                        <div class="col-12">
                          <h5 class="fs-4 fw-semibold">{!! $required_badge !!}公開状態と閲覧権限</h5>
                        </div>
                        <div class="col-auto gap-2 d-flex flex-wrap">
                          <div class="col-auto">
                            <input name="status" type="checkbox" value="true" data-toggle="toggle" data-on="公開" data-off="非公開" data-onstyle="success" data-off-color="default"
                            @if($notice)
                              @if(old('status'))
                              checked
                              @else
                              {{ $notice->status == 'E' ? 'checked' : '' }}
                              @endif
                            @else
                            {{ !old('status') ?: 'checked' }}
                            @endif>
                          </div>
                          <div>
                            <select class="form-select form-select-lg" aria-label="role" name="role">
                                @foreach(getSelectableRole() as $in => $val)
                                  <option value="{{ $in }}"
                                  @if($notice)
                                  {{ old('role',$notice->role) != $in ?: 'selected' }}
                                  @else
                                  {{ old('role') != $in ?: 'selected' }}
                                  @endif>{{ $val['label'] }}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3 w-100">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-calendar text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div class="w-100">
                        <h5 class="fs-4 fw-semibold">表示開始日</h5>
                        <div class="input-group mb-2">
                          <input type="date" id="started_at" name="started_at" class="form-control form-control-lg" value="{{ $notice ? old('started_at',formatYmd($notice->started_at)) : old('started_at') }}">
                          <button class="btn bg-primary-subtle text-primary" type="button" aria-label="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" onclick="inputToday(this);">
                            本日
                          </button>
                          <button class="btn bg-warning-subtle text-warning rounded-end" type="button" aria-label="" onclick="delInput(this);">
                            <i class="ph ph-x"></i>
                          </button>
                        </div>
                        <div class="d-flex align-items-center">
                          <select class="form-select form-select-lg" aria-label="started_hr_at" name="started_hr_at">
                              <option value="">未選択</option>
                              @foreach($hours as $hour)
                                <option value="{{ $hour }}" {{ $notice ? (old('started_hr_at',$notice->started_hr_at) == $hour ? 'selected' : '') : (old('started_hr_at') == $hour ? 'selected' : '') }}>{{ $hour }}</option>
                              @endforeach
                          </select>
                          <span class="fs-6">：</span>
                          <select class="form-select form-select-lg" aria-label="started_min_at" name="started_min_at">
                              <option value="">未選択</option>
                              @foreach($mins as $min)
                                <option value="{{ sprintf('%02d',$min) }}" {{ $notice ? (old('started_min_at',$notice->started_min_at) == sprintf('%02d',$min) ? 'selected' : '') : (old('started_min_at') == $min ? 'selected' : '') }}>{{ sprintf('%02d', $min) }}</option>
                              @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>

                <div class="col-md-6">
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3 w-100">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-calendar text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div class="w-100">
                        <h5 class="fs-4 fw-semibold">表示終了日</h5>
                        <div class="input-group mb-2">
                          <input type="date" id="ended_at" name="ended_at" class="form-control form-control-lg" value="{{ $notice ? old('ended_at',formatYmd($notice->ended_at)) : old('ended_at') }}">
                          <button class="btn bg-primary-subtle text-primary" type="button" aria-label="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" onclick="inputToday(this);">
                            本日
                          </button>
                          <button class="btn bg-warning-subtle text-warning rounded-end" type="button" aria-label="" onclick="delInput(this);">
                            <i class="ph ph-x"></i>
                          </button>
                        </div>
                        <div class="d-flex align-items-center">
                          <select class="form-select form-select-lg" aria-label="ended_hr_at" name="ended_hr_at">
                              <option value="">未選択</option>
                              @foreach($hours as $hour)
                                <option value="{{ $hour }}" {{ $notice ? (old('ended_hr_at',$notice->ended_hr_at) == $hour ? 'selected' : '') : (old('ended_hr_at') == $hour ? 'selected' : '') }}>{{ $hour }}</option>
                              @endforeach
                          </select>
                          <span class="fs-6">：</span>
                          <select class="form-select form-select-lg" aria-label="ended_min_at" name="ended_min_at">
                              <option value="">未選択</option>
                              @foreach($mins as $min)
                                <option value="{{ sprintf('%02d',$min) }}" {{ $notice ? (old('ended_min_at',$notice->ended_min_at) == sprintf('%02d',$min) ? 'selected' : '') : (old('ended_min_at') == $min ? 'selected' : '') }}>{{ sprintf('%02d', $min) }}</option>
                              @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <h5 class="fs-4 fw-semibold"><i class="ph ph-pencil-line me-2"></i>お知らせ本文</h5>
              <p class="mb-3 card-subtitle">本文に埋め込める画像ファイルの最大サイズは <code>500KB</code> です</p>
              <textarea class="form-control bg-white tinymce" name="note">{{ $notice ? old('note',$notice->note) : old('note') }}</textarea>

              <div class="d-flex align-items-center justify-content-end mt-4 gap-6">
                <button onclick="submitButton(this);" class="btn btn-primary"><i class="ph ph-check fs-5 me-2"></i>
                  確認する</button>
                <button class="btn bg-danger-subtle text-danger" onClick="history.back()" type="button"><i class="ph ph-arrow-u-up-left fs-5 me-2"></i>
                  戻る</button>
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