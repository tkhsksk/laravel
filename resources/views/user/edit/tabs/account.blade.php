<div class="tab-pane fade @if($tab == Cookie::get('tab'))active show @endif" id="pills-{{$name}}" role="tabpanel" aria-labelledby="pills-{{$name}}-tab" tabindex="0">
  <form action="{{ route('user.confirm').'/'.$user->id }}" class="" novalidate="novalidate" method="post">
    <input type="hidden" name="tab" value="{{ $name }}">
    @csrf
    <div class="row mb-3">
        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100 position-relative overflow-hidden">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold"><i class="ph ph-chat me-2"></i>Mattermost</h5>
                    <p class="card-subtitle mb-4">各種項目を入力してください</p>
                    <div class="mb-3">
                        <label for="employment_id" class="form-label">{!! $required_badge !!}ユーザー名</label>
                        <div class="input-group border rounded-1">
                          <span class="input-group-text bg-transparent px-6 border-0" id="mm_name">
                            <i class="ph ph-user fs-5"></i>
                          </span>
                          <input type="text" name="mm_name" class="form-control border-0 ps-2 p-region p-locality p-street-address p-extended-address" value="{{ old('mm_name',$admin->mm_name) }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="employment_id" class="form-label">{!! $required_badge !!}パスワード</label>
                        <div class="input-group border rounded-1">
                          <span class="input-group-text bg-transparent px-6 border-0" id="mm_pass">
                            <i class="ph ph-password fs-5"></i>
                          </span>
                          <input type="text" name="mm_pass" class="form-control border-0 ps-2 p-region p-locality p-street-address p-extended-address" value="{{ $admin->mm_pass ? old('mm_pass',\Crypt::decrypt($admin->mm_pass)) : old('mm_pass') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100 position-relative overflow-hidden">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold"><i class="ph ph-google-logo me-2"></i>Google</h5>
                    <p class="card-subtitle mb-4">各種項目を入力してください</p>
                    <div class="mb-3">
                        <label for="employment_id" class="form-label">{!! $required_badge !!}アカウント名</label>
                        <div class="input-group border rounded-1">
                          <span class="input-group-text bg-transparent px-6 border-0" id="google_account">
                            <i class="ph ph-user fs-5"></i>
                          </span>
                          <input type="text" name="google_account" class="form-control border-0 ps-2 p-region p-locality p-street-address p-extended-address" value="{{ old('google_account',$admin->google_account) }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="employment_id" class="form-label">{!! $required_badge !!}パスワード</label>
                        <div class="input-group border rounded-1">
                          <span class="input-group-text bg-transparent px-6 border-0" id="google_account_pass">
                            <i class="ph ph-password fs-5"></i>
                          </span>
                          <input type="text" name="google_account_pass" class="form-control border-0 ps-2 p-region p-locality p-street-address p-extended-address" value="{{ $admin->google_account_pass ? old('google_account_pass',\Crypt::decrypt($admin->google_account_pass)) : old('google_account_pass') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
          <div class="card w-100 position-relative overflow-hidden mb-0">
            <div class="card-body p-4">
              <h5 class="card-title fw-semibold"><i class="ph ph ph-laptop me-2"></i>PCアカウント</h5>
              <p class="card-subtitle mb-4">社員・パートの使用OSに準じて登録して下さい</p>
                <div class="row">
                  <div class="col-lg-6">
                    <h5 class="card-title fw-semibold mb-3"><i class="ph ph-windows-logo me-2"></i>Windowsの場合</h5>
                    <div class="mb-3">
                        <label for="employment_id" class="form-label">デバイス名</label>
                        <div class="input-group border rounded-1">
                          <span class="input-group-text bg-transparent px-6 border-0" id="win_device_name">
                            <i class="ph ph-user fs-5"></i>
                          </span>
                          <input type="text" name="win_device_name" class="form-control border-0 ps-2 p-region p-locality p-street-address p-extended-address" value="{{ old('win_device_name',$admin->win_device_name) }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="employment_id" class="form-label">microsoftアカウント</label>
                        <div class="input-group border rounded-1">
                          <span class="input-group-text bg-transparent px-6 border-0" id="ms_account">
                            <i class="ph ph-user fs-5"></i>
                          </span>
                          <input type="text" name="ms_account" class="form-control border-0 ps-2 p-region p-locality p-street-address p-extended-address" value="{{ old('ms_account',$admin->ms_account) }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="employment_id" class="form-label">microsoftパスワード</label>
                        <div class="input-group border rounded-1">
                          <span class="input-group-text bg-transparent px-6 border-0" id="ms_account_password">
                            <i class="ph ph-password fs-5"></i>
                          </span>
                          <input type="text" name="ms_account_password" class="form-control border-0 ps-2 p-region p-locality p-street-address p-extended-address" value="{{ $admin->ms_account_password ? old('ms_account_password',\Crypt::decrypt($admin->ms_account_password)) : old('ms_account_password') }}">
                        </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <h5 class="card-title fw-semibold mb-3"><i class="ph ph-apple-logo me-2"></i>Macの場合</h5>
                    <div class="mb-3">
                        <label for="employment_id" class="form-label">macフルネーム</label>
                        <div class="input-group border rounded-1">
                          <span class="input-group-text bg-transparent px-6 border-0" id="mac_name">
                            <i class="ph ph-user fs-5"></i>
                          </span>
                          <input type="text" name="mac_name" class="form-control border-0 ps-2 p-region p-locality p-street-address p-extended-address" value="{{ old('mac_name',$admin->mac_name) }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="employment_id" class="form-label">macアカウント名</label>
                        <div class="input-group border rounded-1">
                          <span class="input-group-text bg-transparent px-6 border-0" id="mac_account_name">
                            <i class="ph ph-user fs-5"></i>
                          </span>
                          <input type="text" name="mac_account_name" class="form-control border-0 ps-2 p-region p-locality p-street-address p-extended-address" value="{{ old('mac_account_name',$admin->mac_account_name) }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="employment_id" class="form-label">macアカウントパスワード</label>
                        <div class="input-group border rounded-1">
                          <span class="input-group-text bg-transparent px-6 border-0" id="mac_account_pass">
                            <i class="ph ph-password fs-5"></i>
                          </span>
                          <input type="text" name="mac_account_pass" class="form-control border-0 ps-2 p-region p-locality p-street-address p-extended-address" value="{{ $admin->mac_account_pass ? old('mac_account_pass',\Crypt::decrypt($admin->mac_account_pass)) : old('mac_account_pass') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="employment_id" class="form-label">AppleID</label>
                        <div class="input-group border rounded-1">
                          <span class="input-group-text bg-transparent px-6 border-0" id="apple_id">
                            <i class="ph ph-user fs-5"></i>
                          </span>
                          <input type="text" name="apple_id" class="form-control border-0 ps-2 p-region p-locality p-street-address p-extended-address" value="{{ old('apple_id',$admin->apple_id) }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="employment_id" class="form-label">AppleIDパスワード</label>
                        <div class="input-group border rounded-1">
                          <span class="input-group-text bg-transparent px-6 border-0" id="apple_pass">
                            <i class="ph ph-password fs-5"></i>
                          </span>
                          <input type="text" name="apple_pass" class="form-control border-0 ps-2 p-region p-locality p-street-address p-extended-address" value="{{ $admin->apple_pass ? old('apple_pass',\Crypt::decrypt($admin->apple_pass)) : old('apple_pass') }}">
                        </div>
                    </div>
                  </div>
                  <div class="offset-md-4 col-md-4">
                    <div>
                      <label for="exampleInputtext4" class="form-label">{!! $required_badge !!}PINコード</label>
                      <input type="text" class="form-control" id="exampleInputtext4" name="pin" value="{{ old('pin',$admin->pin) }}">
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>

    </div>
    <button class="btn btn-primary" onclick="submitButton(this);"><i class="fa-solid fa-check fs-5 me-2"></i>確認</button>
  </form>
</div>