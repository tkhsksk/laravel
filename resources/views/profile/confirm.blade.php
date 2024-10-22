@extends('common.layout')

@section('title',       'プロフィールの編集の確認')
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
            <h4 class="fw-semibold mb-9">@yield('title')</h4>
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

    <div class="row justify-content-center">
      <div class="col-md-9">
        <div class="card">
            <div class="form-body">
              <div class="card-header bg-attention-3">
                <p class="mb-0 d-flex h4 text-white align-items-center flex-wrap justify-content-center"><img src="@asset('/thumb/cry.svg')" style="max-width: 58px;" class="d-block me-2 mb-1">まだ登録は完了していません！右下の登録ボタンをクリックしてください！</p>
              </div>
              <div class="card-body">
                <h4 class="card-title fw-semibold mb-3">入力内容の確認</h4>
                <p class="card-subtitle mb-5 lh-base">入力内容を確認して右下の「登録する」をクリックして下さい</p>

                <form class="form-horizontal r-separator" action="{{ route('profile.store') }}" enctype="multipart/form-data" novalidate="novalidate" method="post">
                  @csrf
                  <div class="row">

                    <div class="col-md-6 mb-5">
                      <h4 class="card-title fw-semibold mb-3"><i class="ph ph-number-one me-1 fw-semibold fs-6"></i>. 個人情報の入力</h4>
                      <div class="form-group mb-0">
                        <div class="row align-items-center">
                          <label for="inputText1" class="col-4 text-end control-label col-form-label">氏名</label>
                          <div class="col-8 border-start pb-2 pt-2">
                            <p class="mb-0">
                              <ruby>
                                <rb>{{ $profile['first_name'] }}</rb>
                                <rt>{{ $profile['first_kana'] }}</rt>
                              </ruby>
                              <ruby>
                                <rb>{{ $profile['second_name'] }}</rb>
                                <rt>{{ $profile['second_kana'] }}</rt>
                              </ruby>
                              （{{ App\Models\User::GENDER_STATUS[$profile['gender']] }}）
                              <input type="hidden" name="gender" value="{{ $profile['gender'] }}">
                            </p>
                            <input type="hidden" name="first_name" value="{{ $profile['first_name'] }}">
                            <input type="hidden" name="second_name" value="{{ $profile['second_name'] }}">
                            <input type="hidden" name="first_kana" value="{{ $profile['first_kana'] }}">
                            <input type="hidden" name="second_kana" value="{{ $profile['second_kana'] }}">
                          </div>
                        </div>
                      </div>

                      <div class="form-group mb-0">
                        <div class="row align-items-center">
                          <label for="inputText2" class="col-4 text-end control-label col-form-label">住所</label>
                          <div class="col-8 border-start pb-2 pt-2">
                            <p class="mb-0">〒{{ getPost($profile['post']) }}<br />{{ $profile['address'] }}</p>
                            <input type="hidden" name="post" value="{{ $profile['post'] }}">
                            <input type="hidden" name="address" value="{{ $profile['address'] }}">
                          </div>
                        </div>
                      </div>

                      <div class="form-group mb-0">
                        <div class="row align-items-center">
                          <label for="inputText2" class="col-4 text-end control-label col-form-label">電話番号</label>
                          <div class="col-8 border-start pb-2 pt-2">
                            <p class="mb-0">{{ $profile['phone'] }}</p>
                            <input type="hidden" name="phone" value="{{ $profile['phone'] }}">
                          </div>
                        </div>
                      </div>

                      <div class="form-group mb-0">
                        <div class="row align-items-center">
                          <label for="inputText2" class="col-4 text-end control-label col-form-label">お誕生日</label>
                          <div class="col-8 border-start pb-2 pt-2">
                            <p class="mb-0">{{ date('Y年n月j日',strtotime($profile['birthday'])) }}</p>
                            <input type="hidden" name="birthday" value="{{ $profile['birthday'] }}">
                          </div>
                        </div>
                      </div>

                      <div class="form-group mb-0">
                        <div class="row align-items-center">
                          <label for="inputText2" class="col-4 text-end control-label col-form-label">配偶者</label>
                          <div class="col-8 border-start pb-2 pt-2">
                            <p class="mb-0">{{ App\Models\User::SPOUSE_STATUS[$profile['spouse_status']] }}@if($profile['spouse_status'] == 'T')（{{ $profile['dependent'] }}人）@endif</p>
                            <input type="hidden" name="spouse_status" value="{{ $profile['spouse_status'] }}">
                            <input type="hidden" name="dependent" value="{{ $profile['dependent'] }}">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6 mb-5">
                      <h4 class="card-title fw-semibold mb-3"><i class="ph ph-number-two me-1 fw-semibold fs-6"></i>. ユーザー情報</h4>

                      <div class="form-group mb-0">
                        <div class="row align-items-center">
                          <label for="inputText2" class="col-4 text-end control-label col-form-label">ユーザー名</label>
                          <div class="col-8 border-start pb-2 pt-2">
                            <p class="mb-0">{{ $profile['name'] }}</p>
                            <input type="hidden" name="name" value="{{ $profile['name'] }}">
                          </div>
                        </div>
                      </div>

                      <div class="form-group mb-0">
                        <div class="row align-items-center">
                          <label for="inputText2" class="col-4 text-end control-label col-form-label">ユーザー画像</label>
                          <div class="col-8 border-start pb-2 pt-2">
                            <p class="mb-0 text-center">
                              <img src="
                              @if($profile['reset_image'])
                                @asset('/thumb/no-user.jpeg')
                              @elseif($imagePath)
                                {{ $imagePath }}
                              @else
                                @if($user->image)
                                  {{ $user->image }}
                                @else
                                  @asset('/thumb/no-user.jpeg')
                                @endif
                              @endif
                              " alt="" style="width:180px;max-width:100%">
                            </p>
                            <input type="hidden" name="image" value="{{ $imagePath }}">
                            <input type="hidden" name="extension" value="{{ $extension }}">
                            <input type="hidden" name="image_name" value="{{ $imageName }}">
                            <input type="hidden" name="reset_image" value="{{ $profile['reset_image'] }}">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 mb-5">
                      <h4 class="card-title fw-semibold mb-3"><i class="ph ph-number-three me-1 fw-semibold fs-6"></i>. 通勤方法の入力</h4>

                      <div class="form-group mb-0">
                        <div class="row align-items-center">
                          <label for="inputText2" class="col-4 text-end control-label col-form-label">通勤手段</label>
                          <div class="col-8 border-start pb-2 pt-2">
                            <p class="mb-0">{{ App\Models\User::HOW_TO_COMMUTE[$profile['how_to_commute']] }}</p>
                            <input type="hidden" name="how_to_commute" value="{{ $profile['how_to_commute'] }}">
                          </div>
                        </div>
                      </div>

                      <div class="form-group mb-0">
                        <div class="row align-items-center">
                          <label for="inputText2" class="col-4 text-end control-label col-form-label lh-1">お住まいに<br />最寄の駅</label>
                          <div class="col-8 border-start pb-2 pt-2">
                            <p class="mb-0">{{ $profile['nearest_station'] }}駅</p>
                            <input type="hidden" name="nearest_station" value="{{ $profile['nearest_station'] }}">
                          </div>
                        </div>
                      </div>

                      <div class="form-group mb-0">
                        <div class="row align-items-center">
                          <label for="inputText2" class="col-4 text-end control-label col-form-label lh-1">会社で<br />降車する駅</label>
                          <div class="col-8 border-start pb-2 pt-2">
                            <p class="mb-0">{{ $profile['nearest_station_corp'] }}駅</p>
                            <input type="hidden" name="nearest_station_corp" value="{{ $profile['nearest_station_corp'] }}">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6 mb-5">
                      <h4 class="card-title fw-semibold mb-3"><i class="ph ph-number-four me-1 fw-semibold fs-6"></i>. 銀行口座</h4>
                        <div class="form-group mb-0">
                          <div class="row align-items-center">
                            <label for="inputText2" class="col-4 text-end control-label col-form-label">銀行名</label>
                            <div class="col-8 border-start pb-2 pt-2">
                              <p class="mb-0">{{ $profile['bank_name'] }}銀行（銀行番号：{{ $profile['bank_number'] }}）</p>
                              <input type="hidden" name="bank_name" value="{{ $profile['bank_name'] }}">
                              <input type="hidden" name="bank_number" value="{{ $profile['bank_number'] }}">
                            </div>
                          </div>
                        </div>

                        <div class="form-group mb-0">
                          <div class="row align-items-center">
                            <label for="inputText2" class="col-4 text-end control-label col-form-label">支店名</label>
                            <div class="col-8 border-start pb-2 pt-2">
                              <p class="mb-0">{{ $profile['bank_branch_name'] }}支店（支店番号：{{ $profile['bank_branch_number'] }}）</p>
                              <input type="hidden" name="bank_branch_name" value="{{ $profile['bank_branch_name'] }}">
                              <input type="hidden" name="bank_branch_number" value="{{ $profile['bank_branch_number'] }}">
                            </div>
                          </div>
                        </div>

                        <div class="form-group mb-0">
                          <div class="row align-items-center">
                            <label for="inputText2" class="col-4 text-end control-label col-form-label">口座番号</label>
                            <div class="col-8 border-start pb-2 pt-2">
                              <p class="mb-0">{{ $profile['bank_account'] }}（{{ App\Models\User::BANK_STATUS[$profile['bank_account_status']] }}）</p>
                              <input type="hidden" name="bank_account_status" value="{{ $profile['bank_account_status'] }}">
                              <input type="hidden" name="bank_account" value="{{ $profile['bank_account'] }}">
                            </div>
                          </div>
                        </div>

                        <div class="form-group mb-0">
                          <div class="row align-items-center">
                            <label for="inputText2" class="col-4 text-end control-label col-form-label">口座名義人</label>
                            <div class="col-8 border-start pb-2 pt-2">
                              <p class="mb-0">{{ $profile['bank_account_name'] }}（{{ $profile['bank_account_name_kana'] }}）</p>
                              <input type="hidden" name="bank_account_name" value="{{ $profile['bank_account_name'] }}">
                              <input type="hidden" name="bank_account_name_kana" value="{{ $profile['bank_account_name_kana'] }}">
                            </div>
                          </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                      <h4 class="card-title fw-semibold mb-3"><i class="ph ph-number-five me-1 fw-semibold fs-6"></i>. その他情報</h4>

                      <div class="form-group mb-0">
                        <div class="row align-items-center">
                          <label for="inputText2" class="col-4 text-end control-label col-form-label">絵文字</label>
                          <div class="col-8 border-start pb-2 pt-2">
                            <p class="mb-0">{{ $profile['emoji_mm'] }}</p>
                            <input type="hidden" name="emoji_mm" value="{{ $profile['emoji_mm'] }}">
                          </div>
                        </div>
                      </div>

                      <div class="form-group mb-0">
                        <div class="row align-items-center">
                          <label for="inputText2" class="col-4 text-end control-label col-form-label lh-1">アドビCC<br />アカウント</label>
                          <div class="col-8 border-start pb-2 pt-2">
                            <p class="form-control-static">{{ $profile['adobe_account'] }}</p>
                            <input type="hidden" name="adobe_account" value="{{ $profile['adobe_account'] }}">
                          </div>
                        </div>
                      </div>

                      <div class="form-group mb-0">
                        <div class="row align-items-center">
                          <label for="inputText2" class="col-4 text-end control-label col-form-label lh-1">アドビCC<br />パスワード</label>
                          <div class="col-8 border-start pb-2 pt-2">
                            <p class="form-control-static mb-0">{{ $profile['adobe_pass'] }}</p>
                            <input type="hidden" name="adobe_pass" value="{{ $profile['adobe_pass'] }}">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-end mt-4 gap-6">
                    <button onclick="submitButton(this);" class="btn btn-primary">
                      <i class="ph ph-check fs-5 me-2"></i>
                      登録
                    </button>
                    <button type="button" class="btn bg-danger-subtle text-danger" onClick="history.back()">
                      <i class="ph ph-arrow-u-up-left fs-5 me-2"></i>
                      戻る
                    </button>
                  </div>

              </div>
            </form>

          </div>
        </div>
      </div>
    </div>

	</div>
</div>
@endsection

@include('common.footer')