@extends('common.layout')

@section('title',       'ユーザー情報の確認')
@section('description', '')
@section('keywords',    '')

@include('common.head')
@include('common.header')
@include('common.aside')

@section('contents')
<div class="body-wrapper">
	<div class="container-fluid">

    @if(session('flash.failed') or $errors->any())
    <div class="alert customize-alert alert-dismissible alert-light-danger bg-danger-subtle text-danger fade show remove-close-icon" role="alert">
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        {{ session('flash.failed') }}
        @foreach ($errors->all() as $error)
        <div class="d-flex align-items-center me-3 me-md-0 fs-4"><i class="fa-solid fa-check fs-3 me-2 text-danger"></i>{{ $error }}</div>
        @endforeach
    </div>
    @endif

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
                  <a class="text-muted text-decoration-none" href="/admin">社員・パート一覧</a>
                </li>
                <li class="breadcrumb-item">
                  <a class="text-muted text-decoration-none" href="/user/detail/{{ $user->id }}">ユーザー情報の詳細</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">@yield('title')</li>
              </ol>
            </nav>
          </div>
          <div class="col-3">
            <div class="text-center mb-n5">
              <img src="@asset('/image/ChatBc.png')" alt="" class="img-fluid mb-n4">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-9">
        <div class="card">
          <div class="card-header bg-attention-3">
            <p class="mb-0 d-flex h4 text-white align-items-center flex-wrap justify-content-center"><img src="@asset('/thumb/cry.svg')" style="max-width: 58px;" class="d-block me-2 mb-1">まだ登録は完了していません！右下の登録ボタンをクリックしてください！</p>
          </div>
          <div class="card-body p-4 d-flex align-items-center gap-3">
            <img src="{{ getUserImage($user->id) }}" alt="" class="img-fluid rounded-circle object-fit-cover" style="height:40px;width: 40px;">
            <div>
              <h5 class="fw-semibold mb-0">{{ getNamefromUserId($user->id) }}</h5>
              <span class="fs-2 d-flex align-items-center"><i class="ph ph-envelope-open text-dark fs-3 me-1"></i>{{ $user->email }}</span>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <h4 class="card-title fw-semibold mb-3">{{ App\Models\Admin::ADMIN_MENU_TABS[$tab][0] }}データの確認</h4>
            <p class="card-subtitle mb-5 lh-base">入力内容を確認して右下の「登録する」をクリックして下さい</p>
            <form class="form-horizontal r-separator" action="{{ route('user.store') }}" novalidate="novalidate" method="post">
              @csrf
              <input type="hidden" name="tab" value="{{ $inputs['tab'] }}">
              <input type="hidden" name="user_id" value="{{ $user->id }}">

              @if($tab == 'admin')
              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-3 text-end control-label col-form-label">雇用形態</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ App\Models\Employment::find($inputs['employment_id'])->name }}</p>
                    <input type="hidden" name="employment_id" value="{{ $inputs['employment_id'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText2" class="col-3 text-end control-label col-form-label">有効状態</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">@isset($inputs['status']) 有効 @else 無効 @endisset</p>
                    <input type="hidden" name="status" value="@isset($inputs['status']) E @else D @endisset">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputEmail1" class="col-3 text-end control-label col-form-label">権限</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ App\Models\Admin::ADMIN_ROLES[$inputs['role']][0] }}</p>
                    <input type="hidden" name="role" value="{{ $inputs['role'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText2" class="col-3 text-end control-label col-form-label">エンジニア権限</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">@isset($inputs['engineer_role']) 有効 @else 無効 @endisset</p>
                    <input type="hidden" name="engineer_role" value="@isset($inputs['engineer_role']) E @else D @endisset">
                  </div>
                </div>
              </div>

              <div class="form-group mb-5">
                <div class="row align-items-center">
                  <label for="inputText3" class="col-3 text-end control-label col-form-label">従業員コード</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['code'] }}</p>
                    <input type="hidden" name="code" value="{{ $inputs['code'] }}">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-5">
                  <h4 class="card-title fw-semibold mb-3">勤務地・肩書など</h4>
                  <div class="form-group mb-0">
                    <div class="row align-items-center">
                      <label for="inputText3" class="col-3 text-end control-label col-form-label">勤務地</label>
                      <div class="col-9 border-start pb-2 pt-2">
                        <p class="mb-0">{{ App\Models\Location::find($inputs['location_id'])->name }}</p>
                        <input type="hidden" name="location_id" value="{{ $inputs['location_id'] }}">
                      </div>
                    </div>
                  </div>

                  <div class="form-group mb-0">
                    <div class="row align-items-center">
                      <label for="inputText3" class="col-3 text-end control-label col-form-label">部署</label>
                      <div class="col-9 border-start pb-2 pt-2">
                        <p class="mb-0">{{ App\Models\Department::find($inputs['department_id'])->name }}</p>
                        <input type="hidden" name="department_id" value="{{ $inputs['department_id'] }}">
                      </div>
                    </div>
                  </div>

                  <div class="form-group mb-0">
                    <div class="row align-items-center">
                      <label for="inputText3" class="col-3 text-end control-label col-form-label">肩書</label>
                      <div class="col-9 border-start pb-2 pt-2">
                        <p class="mb-0">{{ $inputs['title'] }}</p>
                        <input type="hidden" name="title" value="{{ $inputs['title'] }}">
                      </div>
                    </div>
                  </div>

                  <div class="form-group mb-0">
                    <div class="row align-items-center">
                      <label for="inputText3" class="col-3 text-end control-label col-form-label">役職</label>
                      <div class="col-9 border-start pb-2 pt-2">
                        <p class="mb-0">{{ $inputs['position'] }}</p>
                        <input type="hidden" name="position" value="{{ $inputs['position'] }}">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 mb-5">
                  <h4 class="card-title fw-semibold mb-3">日付・日程など</h4>
                  <div class="form-group mb-0">
                    <div class="row align-items-center">
                      <label for="inputText3" class="col-3 text-end control-label col-form-label">入社日</label>
                      <div class="col-9 border-start pb-2 pt-2">
                        <p class="mb-0">{{ date('Y年n月j日',strtotime($inputs['employed_at'])) }}</p>
                        <input type="hidden" name="employed_at" value="{{ $inputs['employed_at'] }}">
                      </div>
                    </div>
                  </div>

                  <div class="form-group mb-0">
                    <div class="row align-items-center">
                      <label for="inputText3" class="col-3 text-end control-label col-form-label">初回出社日</label>
                      <div class="col-9 border-start pb-2 pt-2">
                        <p class="mb-0">{{ date('Y年n月j日',strtotime($inputs['started_at'])) }}</p>
                        <input type="hidden" name="started_at" value="{{ $inputs['started_at'] }}">
                      </div>
                    </div>
                  </div>

                  <div class="form-group mb-0">
                    <div class="row align-items-center">
                      <label for="inputText3" class="col-3 text-end control-label col-form-label">退職日</label>
                      <div class="col-9 border-start pb-2 pt-2">
                        <p class="mb-0">{!! $inputs['retiremented_at'] ? date('Y年n月j日',strtotime($inputs['retiremented_at'])) : '&nbsp;' !!}</p>
                        <input type="hidden" name="retiremented_at" value="{{ $inputs['retiremented_at'] }}">
                      </div>
                    </div>
                  </div>

                  <div class="form-group mb-0">
                    <div class="row align-items-center">
                      <label for="inputText3" class="col-3 text-end control-label col-form-label">最終出社日</label>
                      <div class="col-9 border-start pb-2 pt-2">
                        <p class="mb-0">{!! $inputs['ended_at'] ? date('Y年n月j日',strtotime($inputs['ended_at'])) : '&nbsp;' !!}</p>
                        <input type="hidden" name="ended_at" value="{{ $inputs['ended_at'] }}">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-12 mb-5">
                  <h4 class="card-title fw-semibold mb-3">ユーザーについての管理者用メモ</h4>

                  <div class="form-group mb-0">
                    <p class="mb-0">{!! nl2br($inputs['note']) !!}</p>
                        <input type="hidden" name="note" value="{{ $inputs['note'] }}">
                  </div>
                </div>
              </div>

              @endif

              @if($tab == 'other')

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText2" class="col-3 text-end control-label col-form-label">税表区分</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">@isset($inputs['filing_status']) 甲 @else 乙 @endisset</p>
                    <input type="hidden" name="filing_status" value="@isset($inputs['filing_status']) E @else D @endisset">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText2" class="col-3 text-end control-label col-form-label">社会保険加入</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">@isset($inputs['insurance_social_status']) 有り @else 無し @endisset</p>
                    <input type="hidden" name="insurance_social_status" value="@isset($inputs['insurance_social_status']) E @else D @endisset">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText2" class="col-3 text-end control-label col-form-label">雇用保険加入</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">@isset($inputs['insurance_employment_status']) 有り @else 無し @endisset</p>
                    <input type="hidden" name="insurance_employment_status" value="@isset($inputs['insurance_employment_status']) E @else D @endisset">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText3" class="col-3 text-end control-label col-form-label">雇用保険被保険者番号</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ getInsuranceNumber($inputs['insurance_employment_number']) }}</p>
                    <input type="hidden" name="insurance_employment_number" value="{{ $inputs['insurance_employment_number'] }}">
                  </div>
                </div>
              </div>

              @endif

              @if($tab == 'account')
              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText1" class="col-3 text-end control-label col-form-label">Mattermostユーザー名</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['mm_name'] }}</p>
                    <input type="hidden" name="mm_name" value="{{ $inputs['mm_name'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputEmail1" class="col-3 text-end control-label col-form-label">Mattermostパスワード</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['mm_pass'] }}</p>
                    <input type="hidden" name="mm_pass" value="{{ $inputs['mm_pass'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText3" class="col-3 text-end control-label col-form-label">googleアカウント</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['google_account'] }}</p>
                    <input type="hidden" name="google_account" value="{{ $inputs['google_account'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText3" class="col-3 text-end control-label col-form-label">googleアカウントパスワード</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['google_account_pass'] }}</p>
                    <input type="hidden" name="google_account_pass" value="{{ $inputs['google_account_pass'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText3" class="col-3 text-end control-label col-form-label">デバイス名</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['win_device_name'] }}</p>
                    <input type="hidden" name="win_device_name" value="{{ $inputs['win_device_name'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText3" class="col-3 text-end control-label col-form-label">microsoftアカウント</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['ms_account'] }}</p>
                    <input type="hidden" name="ms_account" value="{{ $inputs['ms_account'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText3" class="col-3 text-end control-label col-form-label">microsoftパスワード</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['ms_account_password'] }}</p>
                    <input type="hidden" name="ms_account_password" value="{{ $inputs['ms_account_password'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText3" class="col-3 text-end control-label col-form-label">macフルネーム</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['mac_name'] }}</p>
                    <input type="hidden" name="mac_name" value="{{ $inputs['mac_name'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText3" class="col-3 text-end control-label col-form-label">macアカウント名</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['mac_account_name'] }}</p>
                    <input type="hidden" name="mac_account_name" value="{{ $inputs['mac_account_name'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText3" class="col-3 text-end control-label col-form-label">macアカウントパスワード</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['mac_account_pass'] }}</p>
                    <input type="hidden" name="mac_account_pass" value="{{ $inputs['mac_account_pass'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText3" class="col-3 text-end control-label col-form-label">AppleID</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['apple_id'] }}</p>
                    <input type="hidden" name="apple_id" value="{{ $inputs['apple_id'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText3" class="col-3 text-end control-label col-form-label">AppleIDパスワード</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['apple_pass'] }}</p>
                    <input type="hidden" name="apple_pass" value="{{ $inputs['apple_pass'] }}">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="row align-items-center">
                  <label for="inputText3" class="col-3 text-end control-label col-form-label">PINコード</label>
                  <div class="col-9 border-start pb-2 pt-2">
                    <p class="mb-0">{{ $inputs['pin'] }}</p>
                    <input type="hidden" name="pin" value="{{ $inputs['pin'] }}">
                  </div>
                </div>
              </div>
              @endif

              <div class="d-flex align-items-center justify-content-end mt-4 gap-6">
                <button class="btn btn-primary" onclick="submitButton(this);">
                  <i class="fa-solid fa-check fs-5 me-2"></i>
                  登録する
                </button>
                <button class="btn bg-danger-subtle text-danger" onclick="history.back()" type="button"><i class="ph ph-arrow-u-up-left fs-5 me-2"></i>戻る</button>
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