<script>
  $(function locationChange() {
    $('select[aria-label="location_id"]').change(function() {
      part_val = $(this).val();
      $.ajax({
          url: '{{ route('user.ajax') }}',
          type: 'get',
          data: {val : part_val},
          datatype: 'json',
      })
      .done((data) => {
          // 子カテゴリのoptionを一旦削除
          var targetSelect = 'select[aria-label="department_id"]';
          $(targetSelect+' option').remove();
          if(data.length){
            $(targetSelect).prop('disabled', false);
          } else {
            $(targetSelect).prop('disabled', true);
          }
          // DBから受け取ったデータを子カテゴリのoptionにセット
          console.log(data);
          $(targetSelect).append($('<option>').text('選択して下さい').attr('value', ''));
          $.each(data, function(key, value) {
              $(targetSelect).append($('<option>').text(value.name).attr('value', value.id));
          });
      })
      .fail((data) => {
          console.log('失敗');
      });
    });
  });
</script>

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
                <div class="col-md-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                      <div class="d-flex align-items-center gap-3">
                        <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                          <i class="ph ph-identification-card text-dark d-block fs-7" width="22" height="22"></i>
                        </div>
                        <div>
                          <h5 class="fs-4 fw-semibold">{!! $required_badge !!}従業員コード</h5>
                          <input type="text" class="form-control" id="code" name="code" value="{{ old('code',$admin->code) }}">
                        </div>
                      </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                      <div class="d-flex align-items-center gap-3">
                        <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                          <i class="ph ph-toggle-left text-dark d-block fs-7" width="22" height="22"></i>
                        </div>
                        <div>
                          <h5 class="fs-4 fw-semibold">{!! $required_badge !!}有効状態</h5>
                          <input name="status" type="checkbox" value="true" data-toggle="toggle" data-on="有効" data-off="無効" data-onstyle="success" data-off-color="default" {{ $admin->status == 'E' || old('status') ? 'checked' : '' }}>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                      <div class="d-flex align-items-center gap-3">
                        <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                          <i class="ph ph-app-window text-dark d-block fs-7" width="22" height="22"></i>
                        </div>
                        <div>
                          <h5 class="fs-4 fw-semibold">{!! $required_badge !!}エンジニア権限</h5>
                          <input name="engineer_role" type="checkbox" value="true" data-toggle="toggle" data-on="有効" data-off="無効" data-onstyle="success" data-off-color="default" {{ $admin->engineer_role == 'E' || old('engineer_role') ? 'checked' : '' }}>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="col-md-6">
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-briefcase text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}ユーザー雇用形態</h5>
                        <select class="form-select" aria-label="employment_id" name="employment_id">
                          <option value="">選択して下さい</option>
                          @foreach($employments as $employment)
                            <option value="{{ $employment->id }}" {{ $admin ? (old('employment_id',$admin->employment_id) == $employment->id ? 'selected' : '') : '' }}>{{ $employment->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-medal-military text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}ユーザー権限</h5>
                        <select class="form-select" aria-label="role" name="role">
                          <option value="">選択して下さい</option>
                          @foreach($admin_roles as $status => $val)
                            <option value="{{ $status }}" {{ $admin ? (old('role',$admin->role) == $status ? 'selected' : '') : '' }}>{{ $val[0] }}</option>
                          @endforeach
                      </select>
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
                                <h5 class="fw-semibold">{!! $required_badge !!}<i class="ph ph-building-office me-2"></i>ユーザー勤務地</h5>
                            </div>
                            <div class="task-content">
                              <select class="form-select" aria-label="location_id" name="location_id">
                                <option value="">選択して下さい</option>
                                  @foreach(App\Models\Location::all() as $location)
                                    <option value="{{ $location->id }}" {{ $admin->department ? (old('location_id',$admin->department->location->id) == $location->id ? 'selected' : '' ) : (old('location_id') == $location->id ? 'selected' : '' ) }}>{{ $location->corp->name }}｜{{ $location->name }}</option>
                                  @endforeach
                              </select>
                            </div>
                          </div>
                        </div>

                        <div data-draggable="true" class="card img-task ui-sortable-handle">
                          <div class="card-body">
                            <div class="task-header">
                                <h5 class="fw-semibold">{!! $required_badge !!}<i class="ph ph-office-chair me-2"></i>ユーザー部署</h5>
                            </div>
                            <div class="task-content">
                              <select class="form-select" aria-label="department_id" name="department_id" {{ $admin->department_id ? '' : 'disabled' }}>
                                  <option value="">選択して下さい</option>
                                @foreach(App\Models\Department::all() as $department)
                                  <option value="{{ $department->id }}" {{ $admin->department ? (old('department_id',$admin->department_id) == $department->id ? 'selected' : '' ) : (old('department_id') == $department->id ? 'selected' : '' ) }}>{{ $department->name }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                        </div>

                        <div data-draggable="true" class="card img-task ui-sortable-handle">
                          <div class="card-body">
                            <div class="task-header">
                                <h5 class="fw-semibold">{!! $required_badge !!}<i class="ph ph-identification-card me-2"></i>ユーザー肩書</h5>
                            </div>
                            <div class="task-content">
                              <input type="text" class="form-control" id="title" name="title" value="{{ old('title',$admin->title) }}">
                            </div>
                          </div>
                        </div>

                        <div data-draggable="true" class="card img-task ui-sortable-handle mb-0">
                          <div class="card-body">
                            <div class="task-header">
                                <h5 class="fw-semibold"><i class="ph ph-identification-badge me-2"></i>ユーザー役職</h5>
                            </div>
                            <div class="task-content">
                              <input type="text" class="form-control" id="position" name="position" value="{{ old('position',$admin->position) }}">
                            </div>
                          </div>
                        </div>
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
                                <h5 class="fw-semibold">{!! $required_badge !!}<i class="ph ph-calendar me-2"></i>ユーザー入社日</h5>
                            </div>
                            <div class="task-content">
                              <input type="date" class="form-control p-postal-code" value="{{ $admin->employed_at ? old('employed_at',$admin->employed_at->format('Y-m-d')) : old('employed_at') }}" name="employed_at">
                            </div>
                          </div>
                        </div>

                        <div data-draggable="true" class="card img-task ui-sortable-handle">
                          <div class="card-body">
                            <div class="task-header">
                                <h5 class="fw-semibold">{!! $required_badge !!}<i class="ph ph-calendar me-2"></i>ユーザー初回出社日</h5>
                            </div>
                            <div class="task-content">
                              <input type="date" class="form-control p-region p-locality p-street-address p-extended-address" value="{{ $admin->started_at ? old('started_at',$admin->started_at->format('Y-m-d')) : old('started_at') }}" name="started_at">
                            </div>
                          </div>
                        </div>

                        <div data-draggable="true" class="card img-task ui-sortable-handle">
                          <div class="card-body">
                            <div class="task-header">
                                <h5 class="fw-semibold"><i class="ph ph-graduation-cap me-2"></i>ユーザー退職日</h5>
                            </div>
                            <div class="task-content">
                              <input type="date" class="form-control p-postal-code" value="{{ $admin->retiremented_at ? old('retiremented_at',$admin->retiremented_at->format('Y-m-d')) : old('retiremented_at') }}" name="retiremented_at">
                            </div>
                          </div>
                        </div>

                        <div data-draggable="true" class="card img-task ui-sortable-handle mb-0">
                          <div class="card-body">
                            <div class="task-header">
                                <h5 class="fw-semibold"><i class="ph ph-graduation-cap me-2"></i>ユーザー最終出社日</h5>
                            </div>
                            <div class="task-content">
                              <input type="date" class="form-control p-region p-locality p-street-address p-extended-address" value="{{ $admin->ended_at ? old('ended_at',$admin->ended_at->format('Y-m-d')) : old('ended_at') }}" name="ended_at">
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                </div>

            </div>

            <div class="p-4 rounded-2 text-bg-light">
              <label for="note" class="form-label"><i class="ph ph-list-dashes me-2"></i>ユーザーについてのメモ</label>
              <textarea class="form-control bg-white" name="note" rows="8">{{ old('note',$admin->note) }}</textarea>
            </div>

            <div class="d-flex align-items-center justify-content-end mt-4 gap-6">
              <button class="btn btn-primary" onclick="submitButton(this);"><i class="ph ph-check fs-5 me-2"></i>
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