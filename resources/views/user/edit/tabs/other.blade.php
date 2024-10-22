<div class="tab-pane fade @if($tab == Cookie::get('tab'))active show @endif" id="pills-{{ $name }}" role="tabpanel" aria-labelledby="pills-{{ $name }}-tab" tabindex="0">
  <form action="{{ route('user.confirm').'/'.$user->id }}" class="" novalidate="novalidate" method="post">
    @csrf
    <input type="hidden" name="user_id" value="{{ $user->id }}">
    <input type="hidden" name="tab" value="{{ $name }}">

    <div class="row mb-3">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100 position-relative overflow-hidden mb-0">
              <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between">
              <div>
                <h4 class="fw-semibold mb-4 d-flex align-items-center"><i class="{{ App\Models\Admin::ADMIN_MENU_TABS[$name][1] }} me-3 fs-6"></i>{{ App\Models\Admin::ADMIN_MENU_TABS[$name][0] }}データ</h4>
              </div>
              <div>
              </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                      <div class="d-flex align-items-center gap-3">
                        <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                          <i class="ph ph-identification-card text-dark d-block fs-7" width="22" height="22"></i>
                        </div>
                        <div>
                          <h5 class="fs-4 fw-semibold">{!! $required_badge !!}税表区分</h5>
                          <input name="filing_status" type="checkbox" value="true" data-toggle="toggle" data-on="甲" data-off="乙" data-onstyle="success" data-off-color="default" {{ $admin->filing_status == 'E' || old('filing_status') ? 'checked' : '' }}>
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
                          <h5 class="fs-4 fw-semibold">{!! $required_badge !!}社会保険加入</h5>
                          <input name="insurance_social_status" type="checkbox" value="true" data-toggle="toggle" data-on="有り" data-off="無し" data-onstyle="success" data-off-color="default" {{ $admin->insurance_social_status == 'E' || old('insurance_social_status') ? 'checked' : '' }}>
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
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}雇用保険加入</h5>
                        <input name="insurance_employment_status" type="checkbox" value="true" data-toggle="toggle" data-on="有り" data-off="無し" data-onstyle="success" data-off-color="default" {{ $admin->insurance_employment_status == 'E' || old('insurance_employment_status') ? 'checked' : '' }}>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-hospital text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}雇用保険被保険者番号</h5>
                        <input type="text" class="form-control" id="insurance_employment_number" name="insurance_employment_number" value="{{ old('insurance_employment_number',$admin->insurance_employment_number) }}">
                      </div>
                    </div>
                  </div>
                </div>

            </div>

            <div class="d-flex align-items-center justify-content-end gap-6">
              <button onclick="submitButton(this);" class="btn btn-primary"><i class="ph ph-check fs-5 me-2"></i>
                確認する</button>
              <button class="btn bg-danger-subtle text-danger" onclick="history.back()" type="button"><i class="ph ph-arrow-u-up-left fs-5 me-2"></i>
                戻る</button>
            </div>

        </div>

            </div>
        </div>

    </div>
  </form>
</div>