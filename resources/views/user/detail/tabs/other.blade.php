<div class="tab-pane fade show @if($tab == Cookie::get('tab'))active show @endif" id="pills-{{$name}}" role="tabpanel" aria-labelledby="pills-{{$name}}-tab" tabindex="0">
    <div class="card">
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
                          <h5 class="fs-4 fw-semibold">税表区分</h5>
                          <p class="mb-0">{!! $admin->filing_status ? '<span class="p-1 me-2 '.$admin_status[$admin->filing_status][1].' rounded-circle d-inline-block"></span>'.$admin_status[$admin->filing_status][2] : $yet !!}</p>
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
                          <h5 class="fs-4 fw-semibold">社会保険加入</h5>
                          <p class="mb-0">{!! $admin->insurance_social_status ? '<span class="p-1 me-2 '.$admin_status[$admin->insurance_social_status][1].' rounded-circle d-inline-block"></span>'.$admin_status[$admin->insurance_social_status][3] : $yet !!}</p>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-between">
                      <div class="d-flex align-items-center gap-3">
                        <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                          <i class="ph ph-toggle-left text-dark d-block fs-7" width="22" height="22"></i>
                        </div>
                        <div>
                          <h5 class="fs-4 fw-semibold">雇用保険加入</h5>
                          <p class="mb-0">{!! $admin->insurance_employment_status ? '<span class="p-1 me-2 '.$admin_status[$admin->insurance_employment_status][1].' rounded-circle d-inline-block"></span>'.$admin_status[$admin->insurance_employment_status][3] : $yet !!}</p>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-between">
                      <div class="d-flex align-items-center gap-3">
                        <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                          <i class="ph ph-hospital text-dark d-block fs-7" width="22" height="22"></i>
                        </div>
                        <div>
                          <h5 class="fs-4 fw-semibold">雇用保険被保険者番号 </h5>
                          <p class="mb-0">{!! $admin->insurance_employment_number ? getInsuranceNumber($admin->insurance_employment_number) : $yet !!}</p>
                        </div>
                      </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>