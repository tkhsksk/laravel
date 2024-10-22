@extends('common.layout')

@section('title',       'プロフィールの編集')
@section('description', '')
@section('keywords',    '')

@include('common.head')
@include('common.header')
@include('common.aside')

@section('contents')

<div class="body-wrapper">
	<div class="container-fluid">

		<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
      <div class="card-body px-4 py-3">
        <div class="row align-items-center">
          <div class="col-9">
            <h4 class="fw-semibold mb-8">@yield('title')</h4>
            <nav aria-label="breadcrumb">
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

    <link rel="stylesheet" href="@asset('/css/normalize.css')">
    <link rel="stylesheet" href="@asset('/css/jquery-steps/main.css')">
    <script src="@asset('/js/jquery-steps/jquery-1.9.1.min.js')"></script>
    <script src="@asset('/js/jquery-steps/jquery.validate.min.js')"></script>
    <script src="@asset('/js/jquery-steps/jquery.steps.js')"></script>
    <script>
        $(function ()
        {
          $(".validation-wizard").validate({
              ignore: "input[type=hidden]",
              errorClass: "text-danger",
              successClass: "text-success",
              highlight: function (element, errorClass) {
                  $(element).removeClass(errorClass);
              },
              unhighlight: function (element, errorClass) {
                  $(element).removeClass(errorClass);
              },
              errorPlacement: function (error, element) {
                  if (element.is(':radio')) {
                    error.appendTo(element.parent().parent().parent());
                  } else if ({!! App\Models\User::getRequiredPlacementJs() !!}) {
                    error.insertAfter(element.parent());
                  } else {
                    error.insertAfter(element);
                  }
              },
              rules: {
                  email: {
                      email: !0,
                  },
                  {{ App\Models\User::getRequiredJs() }}
              },
          });

          var form = $(".validation-wizard");

          $(form).steps({
              headerTag: "h6",
              bodyTag: "section",
              transitionEffect: "fade",
              titleTemplate: '<span class="step">#index#</span><span class="title">#title#</span>',
              labels: {
                  finish: "確認する",
                  previous: "前の入力へ",
                  next: "次の入力へ"
              },
              onStepChanging: function (event, currentIndex, newIndex)
              {
                  $(form).validate().settings.ignore = ":disabled,:hidden";
                  return $(form).valid();
              },
              onFinished: function (event, currentIndex) {
                $("form.validation-wizard").submit();
              }
          });
        });
    </script>
    <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>

    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card">
        <div class="card-body wizard-content">

          @include('common.alert')

          <h4 class="card-title fw-semibold mb-3">必要事項の登録</h4>
          <p class="card-subtitle mb-3 lh-base">4つのステップに従って必要項目を入力してください</p>
          <form action="{{ route('profile.confirm') }}" class="validation-wizard wizard-circle h-adr" enctype="multipart/form-data" role="application" id="steps-uid-7" novalidate="novalidate" method="post">
            @csrf
            <h6>個人情報の入力</h6>
            <section id="steps-uid-7-p-0" role="tabpanel" aria-labelledby="steps-uid-7-h-0" class="body current" aria-hidden="false">

              <div class="row">
                <div class="col-md-6 mb-2">
                  <div class="mb-3">
                  <label class="form-label fs-3" for="names"><span class="badge fw-semibold bg-danger-subtle text-danger fs-1 me-2">必須</span>氏名</label>
                    <div class="row">
                      <div class="col-6">
                        <input type="text" class="form-control mb-1" id="first_name" name="first_name" value="{{ old('first_name',$user->first_name) }}">
                      </div>
                      <div class="col-6">
                        <input type="text" class="form-control mb-1" id="second_name" name="second_name" value="{{ old('second_name',$user->second_name) }}">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-2">
                  <div class="mb-3">
                  <label class="form-label fs-3" for="names"><span class="badge fw-semibold bg-danger-subtle text-danger fs-1 me-2">必須</span>氏名カナ</label>
                    <div class="row">
                      <div class="col-6">
                        <input type="text" class="form-control mb-1" id="first_kana" name="first_kana" value="{{ old('first_kana',$user->first_kana) }}">
                      </div>
                      <div class="col-6">
                        <input type="text" class="form-control mb-1" id="second_kana" name="second_kana" value="{{ old('second_kana',$user->second_kana) }}">
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-2">
                  <div class="mb-3">
                    <label class="form-label fs-3" for="wemailAddress2"><span class="badge fw-semibold bg-danger-subtle text-danger fs-1 me-2">必須</span>お住まいの住所</label>
                    <div class="row">
                      <div class="col-md-4 mb-1">
                        <div class="input-group border rounded-1">
                          <span class="input-group-text bg-transparent px-6 border-0" id="post">
                            〒
                          </span>
                          <input type="hidden" class="p-country-name" value="Japan">
                          <input type="text" id="post" name="post" class="form-control border-0 ps-2 p-postal-code" value="{{ old('post',$user->post) }}">
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="input-group border rounded-1">
                          <span class="input-group-text bg-transparent px-6 border-0" id="address">
                            <i class="ph ph-map-pin-line fs-5"></i>
                          </span>
                          <input type="text" id="address" name="address" class="form-control border-0 ps-2 p-region p-locality p-street-address p-extended-address" value="{{ old('address',$user->address) }}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-2">
                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label class="form-label fs-3" for="gender"><span class="badge fw-semibold bg-danger-subtle text-danger fs-1 me-2">必須</span>性別</label>
                      <div class="row py-2">
                        <div class="col-12 mb-2">
                          @foreach(App\Models\User::GENDER_STATUS as $i => $genderStatus)
                          <div class="form-check form-check-inline">
                            <input class="form-check-input primary check-outline outline-primary" type="radio" id="gender{{ $i }}" name="gender" value="{{ $i }}" @if(old('gender',$user->gender) == $i) checked @endif>
                            <label class="form-check-label" for="gender{{ $i }}">{{ $genderStatus }}</label>
                          </div>
                          @endforeach
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                    <label class="form-label fs-3" for="birthday"><span class="badge fw-semibold bg-danger-subtle text-danger fs-1 me-2">必須</span>お誕生日</label>
                      <div class="input-group border rounded-1">
                        <span class="input-group-text bg-transparent px-6 border-0" id="birthday">
                          <i class="ph ph-cake fs-5"></i>
                        </span>
                        <input type="date" id="birthday" name="birthday" class="form-control border-0 ps-2" value="{{ $user->birthday ? old('birthday',$user->birthday->format('Y-m-d')) : '' }}">
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-2">
                  <div class="mb-3">
                    <label class="form-label fs-3" for="phone"><span class="badge fw-semibold bg-danger-subtle text-danger fs-1 me-2">必須</span>あなたにつながる電話番号</label>
                    <div class="input-group border rounded-1">
                      <span class="input-group-text bg-transparent px-6 border-0" id="phone">
                        <i class="ph ph-device-mobile fs-5"></i>
                      </span>
                      <input type="tel" id="phone" name="phone" class="form-control border-0 ps-2" value="{{ old('phone',$user->phone) }}">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <div class="row">
                      <div class="col-md-6">
                        <label class="form-label fs-3" for="spouse_status"><span class="badge fw-semibold bg-danger-subtle text-danger fs-1 me-2">必須</span>配偶者</label>
                        <div class="row py-2">
                          <div class="col-12 mb-2">
                            @foreach(App\Models\User::SPOUSE_STATUS as $i => $spouseStatus)
                            <div class="form-check form-check-inline">
                              <input class="form-check-input primary check-outline outline-primary" type="radio" id="spouse_status{{ $i }}" name="spouse_status" value="{{ $i }}" @if(old('spouse_status',$user->spouse_status) == $i) checked @endif>
                              <label class="form-check-label" for="spouse_status{{ $i }}">{{ $spouseStatus }}</label>
                            </div>
                            @endforeach
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label fs-3" for="dependent">扶養人数（配偶者を除く）</label>
                        <div class="input-group border rounded-1">
                          <span class="input-group-text bg-transparent px-6 border-0" id="dependent">
                            <i class="ph ph-baby fs-5"></i>
                          </span>
                          <input type="text" id="dependent" name="dependent" class="form-control border-0 ps-2" value="{{ old('dependent',$user->dependent) }}">
                          <span class="input-group-text bg-transparent px-6 border-0" id="dependent">人</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </section>
            
            <h6>ユーザー情報</h6>
            <section>
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-md-0 mb-3">
                    <input class="form-control d-none" type="file" id="image" onchange="previewFile(this);" name="image">
                    <input type="hidden" name="reset_image" value="">
                    <label class="form-label" for="name">ユーザー画像</label>
                    <p>許可されている拡張子は JPG, GIF or PNG<br>最大サイズは 500Kです<br />マイルドな画像にしましょう</p>
                    <div class="text-center">
                      <img src="{{ getUserImage(Auth::user()->id) }}" id="preview" alt="" class="rounded-circle ratio-1x1 object-fit-cover mb-3" style="height:120px;width:120px;">
                      <ul class="px-2 pt-2 list-unstyled d-flex align-items-center justify-content-center gap-6 flex-wrap">
                        <a class="btn btn-primary inputImage"><i class="ph ph-file-arrow-up me-2"></i>アップロード</a>
                        <a class="btn bg-danger-subtle text-danger ms-1 undo"><i class="ph ph-trash me-2"></i>リセット</a>
                      </ul>
                    </div>

                  </div>
                </div>

                <div class="col-md-6">
                  <label class="form-label" for="name"><span class="badge fw-semibold bg-danger-subtle text-danger fs-1 me-2">必須</span>ユーザー名</label>
                  <p>シフトの提出や商品購入の際に<br />こちらのユーザー名が表示されます<br />わかりやすいものにしましょう</p>
                  <input type="text" class="form-control form-control-lg" id="name" name="name" value="{{ old('name',$user->name) }}">
                </div>
              </div>
            </section>

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

            <h6>通勤方法の入力</h6>
            <section>

              <div class="row">
                <div class="offset-md-3 col-md-6">
                  <div class="mb-4">
                    <label class="form-label" for="how_to_commute"><span class="badge fw-semibold bg-danger-subtle text-danger fs-1 me-2">必須</span>通勤手段</label>
                    <select class="form-select" id="how_to_commute" name="how_to_commute">
                      @foreach(App\Models\User::HOW_TO_COMMUTE as $i => $commute)
                      <option value="{{ $i }}" @if(old('how_to_commute',$user->how_to_commute) == $i) selected @endif>{{ $commute }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="mb-4">
                    <label class="form-label fs-3" for="nearest_station"><span class="badge fw-semibold bg-danger-subtle text-danger fs-1 me-2">必須</span>お住まいに最寄の駅</label>
                    <div class="input-group border rounded-1">
                      <span class="input-group-text bg-transparent px-6 border-0" id="nearest_station">
                        <i class="ph ph-train fs-5"></i>
                      </span>
                      <input type="text" id="nearest_station" name="nearest_station" class="form-control border-0 ps-2" value="{{ old('nearest_station',$user->nearest_station) }}">
                      <span class="input-group-text bg-transparent px-6 border-0" id="dependent">駅</span>
                    </div>
                  </div>

                  <div class="mb-4">
                    <label class="form-label fs-3" for="nearest_station_corp"><span class="badge fw-semibold bg-danger-subtle text-danger fs-1 me-2">必須</span>勤務地で降車する駅</label>
                    <div class="input-group border rounded-1">
                      <span class="input-group-text bg-transparent px-6 border-0" id="nearest_station_corp">
                        <i class="ph ph-train fs-5"></i>
                      </span>
                      <input type="text" id="nearest_station_corp" name="nearest_station_corp" class="form-control border-0 ps-2" value="{{ old('nearest_station_corp',$user->nearest_station_corp) }}">
                      <span class="input-group-text bg-transparent px-6 border-0" id="dependent">駅</span>
                    </div>
                  </div>
                </div>
              </div>

            </section>

            <h6>銀行口座</h6>
            <section>
              <div class="row">
                <div class="col-md-6">
                  <div class="row mb-4">
                    <div class="col-md-8">
                      <label class="form-label" for="bank_name">{!! $required_badge !!}銀行名</label>
                      <div class="input-group border rounded-1">
                        <span class="input-group-text bg-transparent px-6 border-0" id="address">
                          <i class="ph ph-bank fs-5"></i>
                        </span>
                        <input type="text" class="form-control border-0 ps-2" id="bank_name" list="bank_name_list" name="bank_name" value="{{ old('bank_name',$user->bank_name) }}">
                        <datalist id="bank_name_list">
                          @foreach(App\Models\User::BANK_LIST as $bank)
                          <option value="{{ $bank }}">
                          @endforeach
                        </datalist>
                        <span class="input-group-text bg-transparent px-6 border-0" id="dependent">銀行</span>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <label class="form-label" for="bank_number">{!! $required_badge !!}銀行番号</label>
                      <input type="text" class="form-control" id="bank_number" name="bank_number" value="{{ old('bank_number',$user->bank_number) }}">
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="row mb-4">
                    <div class="col-md-8">
                      <label class="form-label" for="bank_branch_name">{!! $required_badge !!}支店名</label>
                      <div class="input-group border rounded-1">
                        <input type="text" class="form-control border-0" id="bank_branch_name" name="bank_branch_name" value="{{ old('bank_branch_name',$user->bank_branch_name) }}">
                        <span class="input-group-text bg-transparent px-6 border-0" id="dependent">支店</span>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <label class="form-label" for="bank_branch_number">{!! $required_badge !!}支店番号</label>
                      <input type="text" class="form-control" id="bank_branch_number" name="bank_branch_number" value="{{ old('bank_branch_number',$user->bank_branch_number) }}">
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="mb-3">
                    <div class="row py-2">
                      <div class="col-12">
                        <label class="form-label fs-3" for="spouse_status">{!! $required_badge !!}口座種類</label>
                        <div class="row py-2">
                          <div class="col-12">
                          @foreach(App\Models\User::BANK_STATUS as $i => $bankStatus)
                          <div class="form-check form-check-inline">
                            <input class="form-check-input primary check-outline outline-primary" type="radio" id="bank_account_status{{ $i }}" name="bank_account_status" value="{{ $i }}" @if(old('bank_account_status',$user->bank_account_status) == $i) checked @endif>
                            <label class="form-check-label" for="bank_account_status{{ $i }}">{{ $bankStatus }}</label>
                          </div>
                          @endforeach
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label" for="bank_account">{!! $required_badge !!}銀行口座番号</label>
                    <div class="input-group border rounded-1">
                      <span class="input-group-text bg-transparent px-6 border-0" id="address">
                        <i class="ph ph-numpad fs-5"></i>
                      </span>
                      <input type="text" class="form-control border-0 ps-2" id="bank_account" name="bank_account" value="{{ old('bank_account',$user->bank_account) }}">
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label" for="bank_account_name">{!! $required_badge !!}口座名義人（漢字）</label>
                    <div class="input-group border rounded-1">
                      <span class="input-group-text bg-transparent px-6 border-0" id="address">
                        <i class="ph ph-user fs-5"></i>
                      </span>
                      <input type="text" class="form-control border-0 ps-2" id="bank_account_name" name="bank_account_name" value="{{ old('bank_account_name',$user->bank_account_name) }}">
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  

                  <div class="mb-3">
                    <label class="form-label" for="bank_account_name_kana">{!! $required_badge !!}口座名義人（カナ）</label>
                    <div class="input-group border rounded-1">
                      <span class="input-group-text bg-transparent px-6 border-0" id="address">
                        <i class="ph ph-user fs-5"></i>
                      </span>
                      <input type="text" class="form-control border-0 ps-2" id="bank_account_name_kana" name="bank_account_name_kana" value="{{ old('bank_account_name_kana',$user->bank_account_name_kana) }}">
                    </div>
                  </div>
                </div>
              </div>
            </section>
            
            <h6>その他情報</h6>
            <section>

              <div class="row">
                <div class="offset-md-3 col-md-6">
                  <div class="mb-3">
                    <label class="form-label" for="emoji_mm">mattermostで使う絵文字</label>
                    <div class="input-group border rounded-1">
                      <span class="input-group-text bg-transparent px-6 border-0" id="nearest_station">
                        <i class="ph ph-smiley fs-5"></i>
                      </span>
                      <input type="text" class="form-control border-0 ps-2" id="emoji_mm" name="emoji_mm" value="{{ old('emoji_mm',$user->emoji_mm) }}">
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="form-label" for="adobe_account">アドビCCアカウント</label>
                    <input type="text" class="form-control" id="adobe_account" name="adobe_account" value="{{ old('adobe_account',$user->adobe_account) }}">
                  </div>

                  <div class="mb-3">
                    <label class="form-label" for="adobe_pass">アドビCCパスワード</label>
                    <input type="text" class="form-control" id="adobe_pass" name="adobe_pass" value="{{ old('adobe_pass') ? old('adobe_pass') : '' }}{{ !old('adobe_pass') && $user->adobe_pass ? \Crypt::decrypt($user->adobe_pass) : '' }}">
                  </div>
                </div>
              </div>

            </section>

          </form>
        </div>
      </div>
      </div>
    </div>

</div>
@endsection

@include('common.footer')