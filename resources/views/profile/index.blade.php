@extends('common.layout')

@section('title',       'あなたのプロフィール')
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
      @if($user->birthday && \Carbon\Carbon::now()->format('m-d') == $user->birthday->format('m-d'))
        @include('profile.birthday')
      @endif
            <div class="card-body p-0">
              @if($timer >= 6 && $timer <= 10)
              <img src="@asset('/image/profBgMorn.svg')" alt="" class="img-fluid w-100" style="max-height: 150px;object-fit: cover;">
              @elseif($timer > 10 && $timer <= 17)
              <img src="@asset('/image/profBgEve.svg')" alt="" class="img-fluid w-100" style="max-height: 150px;object-fit: cover;">
              @elseif($timer > 17 || $timer < 6)
              <img src="@asset('/image/profBgMid.svg')" alt="" class="img-fluid w-100" style="max-height: 150px;object-fit: cover;">
              @endif
              <div class="row align-items-center">
                <div class="col-lg-4 order-lg-1 order-2">
                  <div class="d-flex align-items-center justify-content-around m-4">
                    <div class="text-center">
                      <i class="ph ph-briefcase fs-6 d-block mb-2"></i>
                      <h5 class="mb-1 fw-semibold lh-1">{!! $admin->employed_at ? $admin->employed_at->format('Y年n月j日') : $yet !!}</h5>
                      <p class="mb-0 fs-3">入社日</p>
                    </div>
                    <div class="text-center">
                      <i class="ph ph-calendar fs-6 d-block mb-2"></i>
                      <h5 class="mb-1 fw-semibold lh-1">{!! now()->isoFormat('YYYY年M月D日(ddd)') !!}</h5>
                      <p class="mb-0 fs-3">本日の日付</p>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4 mt-n3 order-lg-2 order-1">
                  <div class="mt-n5">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                      <div class="d-flex align-items-center justify-content-center round-110 prof-image position-relative" style="z-index:2">
                        <div class="border border-4 border-white d-flex align-items-center justify-content-center rounded-circle overflow-hidden round-100 bg-white">
                          <img src="{{ getUserImage(Auth::user()->id) }}" alt="" class="w-100 h-100 object-fit-cover">
                        </div>
                      </div>
                    </div>
                    <div class="text-center">
                      <h5 class="fs-5 mb-1 fw-semibold d-flex align-items-center justify-content-center">{{ $user->name }}<a href="/profile/edit" class="d-block ms-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="むずかし編集する"><i class="ph ph-pencil-line fs-5"></i></a><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#easyProfModal" data-bs-dismiss="modal" class="d-block ms-1"><i class="ph ph-baby fs-5"></i></a></h5>
                      <p class="mb-0 d-flex align-items-center gap-2 fs-3 justify-content-center"><i class="ph ph-identification-card fs-5"></i>{!! $admin->title ? $admin->title : $yet !!}</p>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4 order-last d-flex flex-wrap align-items-center">
                  <ul class="list-unstyled d-flex align-items-center justify-content-center justify-content-lg-end my-3 mx-4 pe-md-4 gap-3">
                    <li class="position-relative">
                      <a class="d-flex align-items-center justify-content-center text-bg-primary p-2 fs-4 rounded-circle" href="https://portia.co.jp/" width="30" height="30" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="コーポレートサイト" target="_blank">
                        <i class="ph ph-building-office"></i>
                      </a>
                    </li>
                    <li class="position-relative">
                      <a class="text-bg-secondary d-flex align-items-center justify-content-center p-2 fs-4 rounded-circle" href="https://portiapay.jp/" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="サービスサイト" target="_blank">
                        <i class="ph ph-browser"></i>
                      </a>
                    </li>
                    <li class="position-relative">
                      <a class="text-bg-danger d-flex align-items-center justify-content-center p-2 fs-4 rounded-circle" href="https://admin.portia.co.jp/top" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="PortiaPAY管理画面" target="_blank">
                        <i class="ph ph-headset"></i>
                      </a>
                    </li>
                  </ul>

                  <a style="max-width: 58px;" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCorp" aria-controls="offcanvasCorp">
                    <img src="@if($timer >= 6 && $timer <= 15)@asset('/thumb/smile.svg') @else @asset('/thumb/sleep.svg') @endif" class="mx-auto d-block w-100" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="ようこそ！">
                  </a>
                </div>
                
              </div>

              <ul class="nav nav-pills user-profile-tab justify-content-end mt-2 bg-primary-subtle rounded-2 rounded-top-0" id="pills-tab" role="tablist">
                @foreach(App\Models\User::TABS as $tab => $i)
                  <li class="nav-item" role="presentation">
                    <button class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-6  
                    @if($tab == Cookie::get('tab'))
                    active
                    @endif" id="pills-{{$tab}}-tab" data-bs-toggle="pill" data-bs-target="#pills-{{$tab}}" type="button" role="{{$tab}}" aria-controls="pills-{{$tab}}" aria-selected="true" onclick="setTabCookie(this);">
                      <i class="{{$i[1]}} me-2 fs-4"></i>
                      <span class="d-none d-md-block">{{$i[0]}}</span>
                    </button>
                  </li>
                @endforeach
              </ul>

            </div>
          </div>

          <div class="tab-content" id="pills-tabContent">
            @foreach(App\Models\User::TABS as $tab => $i)
              @include('profile.tabs.'.$tab, ['name' => $tab,'data' => $i])
            @endforeach
          </div>

          <div class="offcanvas customizer offcanvas-end text-start" tabindex="-1" id="offcanvasCorp" aria-labelledby="offcanvasCorpLabel">
          <div class="d-flex align-items-center justify-content-between p-3 border-bottom">

            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            <div class="d-flex align-items-center gap-7">
              <h4 class="offcanvas-title fw-semibold fs-4" id="offcanvasCorpLabel">
                <i class="ph ph-confetti fw-semibold me-2"></i>ようこそ
              </h4>
            </div>
          </div>
          <div class="offcanvas-body h-n80 simplebar-scrollable-y" data-simplebar="init">
            <div class="simplebar-wrapper">
              <div class="simplebar-height-auto-observer-wrapper">
                <div class="simplebar-height-auto-observer"></div>
              </div>
              <div class="simplebar-mask">
                <div class="simplebar-offset">
                  <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content">
                    <div class="simplebar-content">

                      <p>ようこそ、{{ App\Models\Config::find(1)->site_name }}へ。<br />業務に必要なマニュアルを登録したり、シフトの申請を申請したり、あなたの登録した情報をいつでも閲覧することができます。</p>

                      <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-center gap-6 mb-4">
                          <i class="ph ph-building-office fs-5"></i>
                          <div>
                            <p class="mb-1 text-muted small">あなたの勤め先</p>
                            <h6 class="fs-3 fw-semibold mb-0">{!! $user->admin->department ? getCorpName($user->admin->department->location->corp->id) : $yet !!}（{!! $corp ? $corp->name : $yet !!}）</h6>
                          </div>
                        </li>

                        <li class="d-flex align-items-center gap-6 mb-4">
                          <i class="ph ph-map-pin-line fs-5"></i>
                          <div>
                            <p class="mb-1 text-muted small">勤め先の住所</p>
                            <h6 class="fs-3 fw-semibold mb-0">〒 {!! $corp ? getPost($corp->post) : $yet !!}<br />{!! $corp ? $corp->address : $yet !!}</h6>
                          </div>
                        </li>

                        <li class="d-flex align-items-center gap-6 mb-4">
                          <i class="ph ph-device-mobile fs-5"></i>
                          <div>
                            <p class="mb-1 text-muted small">勤め先の電話番号</p>
                            <h6 class="fs-3 fw-semibold mb-0">{!! $corp ? $corp->phone : $yet !!}</h6>
                          </div>
                        </li>
                        @if($corp)
                        <iframe src="https://www.google.com/maps?q={{ $corp->address }}&output=embed&z=14" width="100%" height="250px" frameborder="0" style="border:0" allowfullscreen class="mb-3"></iframe>
                        @endif
                        <li class="d-flex align-items-center gap-6 mb-2">
                          <i class="ph ph-envelope-open fs-5"></i>
                          <div>
                            <p class="mb-0 text-muted small">あなたのメールアドレス</p>
                            <h6 class="fs-3 fw-semibold mb-0">{{ $user->email }}</h6>
                          </div>
                        </li>
                      </ul>

                    </div>
                  </div>
                </div>
              </div>
              <div class="simplebar-placeholder"></div>
            </div>
            <div class="simplebar-track simplebar-horizontal">
              <div class="simplebar-scrollbar"></div>
            </div>
            <div class="simplebar-track simplebar-vertical">
              <div class="simplebar-scrollbar"></div>
            </div>
          </div>
        </div>

	</div>
</div>

<div class="modal fade" id="easyProfModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content rounded-1">
      <form action="{{ route('profile.easy') }}" enctype="multipart/form-data" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ Auth::user()->id }}">
        <input type="hidden" name="email" value="{{ old('email',$user->email) }}">
        <div class="bg-tinymce modal-header border-bottom">
          <h5 class="mb-0 text-white mt-1"><i class="ph ph-baby fs-5 me-2"></i>プロフィールかんたん修正</h5>
        </div>
        <div class="modal-body fs-4">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fs-3" for="birthday"><span class="badge fw-semibold bg-danger-subtle text-danger fs-1 me-2">必須</span>ユーザー名</label>
              <div class="input-group border rounded-1">
                <span class="input-group-text bg-transparent px-6 border-0" id="name">
                  <i class="ph ph-lego-smiley fs-5"></i>
                </span>
                <input type="text" id="name" name="name" class="form-control form-control-lg border-0 ps-2" value="{{ old('name',$user->name) }}">
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label fs-3" for="birthday"><span class="badge fw-semibold bg-danger-subtle text-danger fs-1 me-2">必須</span>お誕生日</label>
              <div class="input-group border rounded-1">
                <span class="input-group-text bg-transparent px-6 border-0" id="birthday">
                  <i class="ph ph-cake fs-5"></i>
                </span>
                <input type="date" id="birthday" name="birthday" class="form-control form-control-lg border-0 ps-2" value="{{ $user->birthday ? old('birthday',$user->birthday->format('Y-m-d')) : '' }}">
              </div>
            </div>

            <div class="col-md-12">
              <div class="mb-md-0">
                <input class="form-control d-none" type="file" id="image" onchange="previewFile(this);" name="image">
                <input type="hidden" name="reset_image" value="">
                <label class="form-label fs-3" for="name">ユーザー画像</label>
                <p class="small text-center">許可されている拡張子はJPG or PNG<br>最大サイズは500Kです マイルドな画像にしましょう</p>
                <div class="text-center">
                  <img src="{{ getUserImage(Auth::user()->id) }}" id="preview" alt="" class="rounded-circle ratio-1x1 object-fit-cover mb-3" style="height:120px;width:120px;">
                  <ul class="px-2 pt-2 list-unstyled mb-0 d-flex align-items-center justify-content-center gap-6 flex-wrap">
                    <a class="btn btn-primary inputImage"><i class="ph ph-file-arrow-up me-2"></i>アップロード</a>
                    <a class="btn bg-light text-dark ms-1 undo"><i class="ph ph-trash me-2"></i>リセット</a>
                  </ul>
                </div>

              </div>
            </div>

            <script>
            function previewFile(imgprev){
              var fileData = new FileReader();
              fileData.onload = (function() {
                document.getElementById('preview').src = fileData.result;
              });
              fileData.readAsDataURL(imgprev.files[0]);
              $('input[name=reset_image]').val('');
            }

            $(".inputImage").on('click', function(){
              $("input[type='file']").on('click', function(e){
                e.stopPropagation();
              });
              $("input[type='file']").click();
            });

            const img = "@asset('/thumb/no-user.jpeg')";
            
            $(".undo").on('click', function(){
              $('input[type=file]').val('');
              $('#preview').attr("src",img);
              $('input[name=reset_image]').val(1);
            });
            </script>

          </div>
        </div>
        <div class="modal-footer gap-1">
          <button class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal" type="button">閉じる</button>
          <button class="btn btn-rounded bg-secondary-subtle text-secondary" onclick="submitButton(this);"><i class="ph ph-pencil-simple-line me-2"></i>登録する</button>
        </div>
      </form>
    </div>
  </div>
</div>

@if(!Cookie::get('tab'))
<script>
$(function() {
  $('#pills-profile-tab').tab('show');
});
</script>
@endif

@endsection

@include('common.footer')