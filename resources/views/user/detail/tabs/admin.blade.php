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
              <div class="col-md-3">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                      <div class="d-flex align-items-center gap-3">
                        <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                          <i class="ph ph-identification-card text-dark d-block fs-7" width="22" height="22"></i>
                        </div>
                        <div>
                          <h5 class="fs-3 fw-semibold">従業員コード</h5>
                          <p class="mb-0">{!! $admin->code ? $admin->code : $yet !!}</p>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                      <div class="d-flex align-items-center gap-3">
                        <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                          <i class="ph ph-briefcase text-dark d-block fs-7" width="22" height="22"></i>
                        </div>
                        <div>
                          <h5 class="fs-3 fw-semibold">ユーザー雇用形態</h5>
                          <p class="mb-0">{!! $admin->employment_id ? App\Models\Employment::find($admin->employment_id)->name : $yet !!}</p>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                      <div class="d-flex align-items-center gap-3">
                        <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                          <i class="ph ph-medal-military text-dark d-block fs-7" width="22" height="22"></i>
                        </div>
                        <div>
                          <h5 class="fs-3 fw-semibold">ユーザー権限</h5>
                          <p class="mb-0">{!! $admin->role ? $admin_roles[$admin->role][0] : $yet !!}</p>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                      <div class="d-flex align-items-center gap-3">
                        <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                          <i class="ph ph-app-window text-dark d-block fs-7" width="22" height="22"></i>
                        </div>
                        <div>
                          <h5 class="fs-3 fw-semibold">エンジニア権限</h5>
                          <div class="d-flex align-items-center">{!! getStatus('有効','無効',$admin->engineer_role) !!}</div>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="connect-sorting connect-sorting-todo">
                      <div class="task-container-header">
                        <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="Todo">勤務地・肩書など</h6>
                      </div>
                      <div class="connect-sorting-content ui-sortable" data-sortable="true">
                        <div data-draggable="true" class="card img-task ui-sortable-handle">
                          <div class="card-body">
                            <div class="task-header">
                                <h5 class="fw-semibold"><i class="ph ph-building-office me-2"></i>ユーザー勤務地</h5>
                            </div>
                            <div class="task-content">
                              <p class="mb-0">
                                {!! $admin->department ? '<a href="/corp">'.getCorpName($admin->department->location->corp->id).'</a>｜<a href="/location/detail/'.$admin->department->location->id.'">'.$admin->department->location->name.'</a>' : $yet !!}
                              </p>
                            </div>
                          </div>
                        </div>

                        <div data-draggable="true" class="card img-task ui-sortable-handle">
                          <div class="card-body">
                            <div class="task-header">
                                <h5 class="fw-semibold"><i class="ph ph-office-chair me-2"></i>ユーザー部署</h5>
                            </div>
                            <div class="task-content">
                              <p class="mb-0">
                                {!! $admin->department_id ? App\Models\Department::find($admin->department_id)->name : $yet !!}
                              </p>
                            </div>
                          </div>
                        </div>

                        <div data-draggable="true" class="card img-task ui-sortable-handle">
                          <div class="card-body">
                            <div class="task-header">
                                <h5 class="fw-semibold"><i class="ph ph-identification-card me-2"></i>ユーザー肩書</h5>
                            </div>
                            <div class="task-content">
                              <p class="mb-0">
                                {!! $admin->title ? $admin->title : $yet !!}
                              </p>
                            </div>
                          </div>
                        </div>

                        @if($admin->position)
                        <div data-draggable="true" class="card img-task ui-sortable-handle">
                          <div class="card-body">
                            <div class="task-header">
                                <h5 class="fw-semibold"><i class="ph ph-identification-badge me-2"></i>ユーザー役職</h5>
                            </div>
                            <div class="task-content">
                              <p class="mb-0">
                                {!! $admin->position ? $admin->position : '' !!}
                              </p>
                            </div>
                          </div>
                        </div>
                        @endif
                      </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="connect-sorting connect-sorting-todo">
                      <div class="task-container-header">
                        <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="Todo">日付・日程など</h6>
                      </div>
                      <div class="connect-sorting-content ui-sortable" data-sortable="true">
                        <div data-draggable="true" class="card img-task ui-sortable-handle">
                          <div class="card-body">
                            <div class="task-header">
                                <h5 class="fw-semibold"><i class="ph ph-calendar me-2"></i>ユーザー入社日</h5>
                            </div>
                            <div class="task-content">
                              <p class="mb-0">
                                {!! $admin->employed_at ? $admin->employed_at->format('Y年n月j日') : $yet !!}
                              </p>
                            </div>
                          </div>
                        </div>

                        <div data-draggable="true" class="card img-task ui-sortable-handle">
                          <div class="card-body">
                            <div class="task-header">
                                <h5 class="fw-semibold"><i class="ph ph-calendar me-2"></i>ユーザー初回出社日</h5>
                            </div>
                            <div class="task-content">
                              <p class="mb-0">
                                {!! $admin->started_at ? $admin->started_at->format('Y年n月j日') : $yet !!}
                              </p>
                            </div>
                          </div>
                        </div>

                        @if($admin->retiremented_at)
                        <div data-draggable="true" class="card img-task ui-sortable-handle">
                          <div class="card-body">
                            <div class="task-header">
                                <h5 class="fw-semibold"><i class="ph ph-graduation-cap me-2"></i>ユーザー退職日</h5>
                            </div>
                            <div class="task-content">
                              <p class="mb-0">
                                {!! $admin->retiremented_at ? $admin->retiremented_at->format('Y年n月j日') : '' !!}
                              </p>
                            </div>
                          </div>
                        </div>
                        @endif

                        @if($admin->ended_at)
                        <div data-draggable="true" class="card img-task ui-sortable-handle">
                          <div class="card-body">
                            <div class="task-header">
                                <h5 class="fw-semibold"><i class="ph ph-graduation-cap me-2"></i>ユーザー最終出社日</h5>
                            </div>
                            <div class="task-content">
                              <p class="mb-0">
                                {!! $admin->ended_at ? $admin->ended_at->format('Y年n月j日') : '' !!}
                              </p>
                            </div>
                          </div>
                        </div>
                        @endif
                      </div>
                    </div>
                </div>

            </div>

            <div class="p-4 rounded-2 text-bg-light d-flex">
              <i class="ph ph-list-dashes me-2 pt-1"></i><p class="mb-0 fs-3">{!! $admin->note ? nl2br($admin->note) : '<span class="text-muted">管理者用メモ</span>'.$yet !!}</p>
            </div>

        </div>
    </div>
</div>