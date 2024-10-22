<div class="tab-pane fade @if($name == Cookie::get('tab'))active show @endif" id="pills-{{$name}}" role="tabpanel" aria-labelledby="pills-{{$name}}-tab" tabindex="0">
    <div class="card">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between">
              <div>
                <h4 class="fw-semibold mb-4 d-flex align-items-center"><i class="{{ App\Models\Admin::ADMIN_MENU_TABS[$name][1] }} me-3 fs-6"></i>{{ App\Models\Admin::ADMIN_MENU_TABS[$name][0] }}に関するデータ</h4>
              </div>
              <div>
              </div>
            </div>

            <div class="card bg-primary-subtle rounded-2 shadow-none">
                <div class="card-body text-center p-2">
                  <div class="d-flex align-items-center justify-content-center mb-4 pt-8">
                    <div class="btn text-bg-light round rounded-circle d-flex align-items-center justify-content-center">
                      <i class="ph ph-user fs-6"></i>
                    </div>
                  </div>
                  <h3 class="fw-semibold text-primary">{!! $admin->pin ? $admin->pin : $yet !!}</h3>
                  <p class="fw-normal fs-4 mb-2 d-flex align-items-center justify-content-center"><i class="ph ph-password fs-6 me-2"></i>4桁のPINコード</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                      <div class="d-flex align-items-center gap-3">
                        <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                            <img src="/icon/mattermost.svg" alt="" class="img-fluid" width="24" height="24">
                        </div>
                        <div>
                          <h5 class="fs-4 fw-semibold">ユーザーのMattermostアカウント</h5>
                          <p class="mb-0">ユーザー名：{!! $admin->mm_name ? $admin->mm_name : $yet !!}</p>
                          <p class="mb-0">パスワード：{!! $admin->mm_pass ? \Crypt::decrypt($admin->mm_pass) : $yet !!}</p>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                      <div class="d-flex align-items-center gap-3">
                        <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                            <img src="/icon/google.svg" alt="" class="img-fluid" width="24" height="24">
                        </div>
                        <div>
                          <h5 class="fs-4 fw-semibold">ユーザーのGoogleアカウント</h5>
                          <p class="mb-0">アカウント名：{!! $admin->google_account ? $admin->google_account : $yet !!}</p>
                          <p class="mb-0">パスワード：{!! $admin->google_account_pass ? \Crypt::decrypt($admin->google_account_pass) : $yet !!}</p>
                        </div>
                      </div>
                    </div>
                </div>

            </div>
            <div class="row justify-content-center mb-3">

                @if($admin->win_device_name)
                <div class="col-md-6">
                    <div class="d-flex mb-n3 align-items-center justify-content-center mb-4">
                        <div class="btn text-white round rounded-circle d-flex align-items-center justify-content-center" style="background-color: #0378d4 !important;">
                          <i class="ph ph-windows-logo fs-6"></i>
                        </div>
                    </div>
                    <div class="connect-sorting connect-sorting-todo bg-info-subtle">
                      <div class="task-container-header">
                        <h6 class="item-head mb-0 fs-4 fw-semibold d-flex align-items-center" data-item-title="Todo">ユーザーのWindows関連アカウント</h6>
                      </div>
                      <div class="connect-sorting-content ui-sortable" data-sortable="true">
                        <div data-draggable="true" class="card img-task ui-sortable-handle">
                          <div class="card-body">
                            <div class="task-header">
                                <h5 class="fw-semibold"><i class="ph ph-buildings me-2"></i>デバイス名</h5>
                            </div>
                            <div class="task-content">
                              <p class="mb-0">
                                {!! $admin->win_device_name ? $admin->win_device_name : $yet !!}
                              </p>
                            </div>
                          </div>
                        </div>

                        @if($admin->ms_account)
                        <div data-draggable="true" class="card img-task ui-sortable-handle">
                          <div class="card-body">
                            <div class="task-header">
                                <h5 class="fw-semibold"><i class="ph ph-office-chair me-2"></i>microsoftアカウント</h5>
                            </div>
                            <div class="task-content">
                              <p class="mb-0">
                                {{ $admin->ms_account }}
                              </p>
                            </div>
                          </div>
                        </div>
                        @endif

                        @if($admin->ms_account)
                        <div data-draggable="true" class="card img-task ui-sortable-handle">
                          <div class="card-body">
                            <div class="task-header">
                                <h5 class="fw-semibold"><i class="ph ph-briefcase me-2"></i>microsoftパスワード</h5>
                            </div>
                            <div class="task-content">
                              <p class="mb-0">
                                {{ \Crypt::decrypt($admin->ms_account_password) }}
                              </p>
                            </div>
                          </div>
                        </div>
                        @endif

                      </div>
                    </div>
                </div>
                @endif

                @if($admin->mac_name)
                <div class="col-md-6">
                    <div class="d-flex mb-n3 align-items-center justify-content-center mb-4">
                        <div class="btn bg-dark round rounded-circle d-flex align-items-center justify-content-center">
                          <i class="ph ph-apple-logo fs-6 text-white"></i>
                        </div>
                    </div>
                    <div class="connect-sorting connect-sorting-todo bg-primary-subtle">
                      <div class="task-container-header">
                        <h6 class="item-head mb-0 fs-4 fw-semibold d-flex align-items-center" data-item-title="Todo">
                            ユーザーのMac関連アカウント</h6>
                      </div>
                      <div class="connect-sorting-content ui-sortable" data-sortable="true">
                        <div data-draggable="true" class="card img-task ui-sortable-handle">
                          <div class="card-body">
                            <div class="task-header">
                                <h5 class="fw-semibold"><i class="ph ph-calendar me-2"></i>macフルネーム</h5>
                            </div>
                            <div class="task-content">
                              <p class="mb-0">
                                {{ $admin->mac_name }}
                              </p>
                            </div>
                          </div>
                        </div>

                        @if($admin->mac_account_name)
                        <div data-draggable="true" class="card img-task ui-sortable-handle">
                          <div class="card-body">
                            <div class="task-header">
                                <h5 class="fw-semibold"><i class="ph ph-calendar me-2"></i>macアカウント名</h5>
                            </div>
                            <div class="task-content">
                              <p class="mb-0">
                                {{ $admin->mac_account_name }}
                              </p>
                            </div>
                          </div>
                        </div>
                        @endif

                        @if($admin->mac_account_pass)
                        <div data-draggable="true" class="card img-task ui-sortable-handle">
                          <div class="card-body">
                            <div class="task-header">
                                <h5 class="fw-semibold"><i class="ph ph-graduation-cap me-2"></i>macアカウントパスワード</h5>
                            </div>
                            <div class="task-content">
                              <p class="mb-0">
                                {{ \Crypt::decrypt($admin->mac_account_pass) }}
                              </p>
                            </div>
                          </div>
                        </div>
                        @endif

                        @if($admin->apple_id)
                        <div data-draggable="true" class="card img-task ui-sortable-handle">
                          <div class="card-body">
                            <div class="task-header">
                                <h5 class="fw-semibold"><i class="ph ph-graduation-cap me-2"></i>AppleID</h5>
                            </div>
                            <div class="task-content">
                              <p class="mb-0">
                                {{ $admin->apple_id }}
                              </p>
                            </div>
                          </div>
                        </div>
                        @endif

                        @if($admin->apple_pass)
                        <div data-draggable="true" class="card img-task ui-sortable-handle">
                          <div class="card-body">
                            <div class="task-header">
                                <h5 class="fw-semibold"><i class="ph ph-graduation-cap me-2"></i>AppleIDパスワード</h5>
                            </div>
                            <div class="task-content">
                              <p class="mb-0">
                                {{ \Crypt::decrypt($admin->apple_pass) }}
                              </p>
                            </div>
                          </div>
                        </div>
                        @endif
                      </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>

</div>