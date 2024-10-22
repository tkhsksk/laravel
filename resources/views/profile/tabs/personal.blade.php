<div class="tab-pane container-fluid fade @if($name == Cookie::get('tab'))active show @endif" id="pills-{{$name}}" role="tabpanel" aria-labelledby="pills-{{$name}}-tab" tabindex="0">

  <div class="row justify-content-center">
    <div class="col-md-9">
        <div class="d-flex flex-wrap justify-content-between">
          <div>
            <h4 class="fw-semibold mb-4 d-flex align-items-center"><i class="ph ph-user me-3 fs-6"></i><p><span class="fw-normal fs-2">フリガナ：{{ $user->first_kana ? $user->first_kana.' '.$user->second_kana : '' }}</span><br />{{ $user->first_name ? $user->first_name.' '.$user->second_name : '' }}<span class="fw-normal fs-2">（{{ $user->gender ? App\Models\User::GENDER_STATUS[$user->gender] : '' }}）</span></p></h4>
          </div>
          <div>
          </div>
        </div>

        <div class="row mb-4">
          <div class="col-md-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="d-flex align-items-center gap-3">
                    <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                      <i class="ph ph-baby text-dark d-block fs-7" width="22" height="22"></i>
                    </div>
                    <div>
                      <h5 class="fs-3 fw-semibold">生年月日</h5>
                      <p class="mb-0">{{ $user->birthday ? $user->birthday->isoFormat('YYYY年 M月 D日'):'' }}生<br /> (満{{$age}}歳)</p>
                    </div>
                  </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="d-flex align-items-center gap-3">
                    <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                      <i class="ph ph-device-mobile-speaker text-dark d-block fs-7" width="22" height="22"></i>
                    </div>
                    <div>
                      <h5 class="fs-3 fw-semibold">あなたにつながる電話番号</h5>
                      <p class="mb-0">{{ $user->phone ?? '' }}</p>
                    </div>
                  </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="d-flex align-items-center gap-3">
                    <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                      <i class="ph ph-baby-carriage text-dark d-block fs-7" width="22" height="22"></i>
                    </div>
                    <div>
                      <h5 class="fs-3 fw-semibold">ご家族について</h5>
                      <p class="mb-0">扶養家族数（配偶者を除く）<br />{{$user->dependent}}人、配偶者：<span style="@if($user->spouse_status == 'F')opacity:.3 @endif">有</span>・<span style="@if($user->spouse_status == 'T')opacity:.3 @endif">無</span></p>
                    </div>
                  </div>
                </div>
            </div>

            <div class="col-md-6 mb-md-0 mb-3">
                <div class="connect-sorting connect-sorting-todo">
                  <div class="task-container-header">
                    <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="Todo">あなたの住所・出勤について</h6>
                  </div>
                  <div class="connect-sorting-content ui-sortable" data-sortable="true">
                    <div data-draggable="true" class="card img-task ui-sortable-handle">
                      <div class="card-body">
                        @if($user->address)
                        <iframe src="https://www.google.com/maps?q={{ $user->address }}&output=embed&z=14" width="100%" height="250px" frameborder="0" style="border:0" allowfullscreen class="mb-3"></iframe>
                        @endif
                        <div class="task-header">
                            <h5 class="fw-semibold"><i class="ph ph-house-line me-2"></i>あなたの住所</h5>
                        </div>
                        <div class="task-content">
                          <p class="mb-0">
                            ( 〒 {{ $user->post ? getPost($user->post) : '' }} )<br />{{ $user->address ?? '' }}
                          </p>
                        </div>
                      </div>
                    </div>

                    <div data-draggable="true" class="card img-task ui-sortable-handle">
                      <div class="card-body">
                        <div class="task-header">
                            <h5 class="fw-semibold"><i class="ph ph-train me-2"></i>あなたの出勤手段</h5>
                        </div>
                        <div class="task-content">
                          <p class="mb-0">
                            {{ $user->how_to_commute ? App\Models\User::HOW_TO_COMMUTE[$user->how_to_commute] : ''}}<br />{{$user->nearest_station}}駅から{{$user->nearest_station_corp}}駅
                          </p>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="connect-sorting connect-sorting-todo">
                  <div class="task-container-header">
                    <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="Todo">あなたの給与振込口座について・他</h6>
                  </div>
                  <div class="connect-sorting-content ui-sortable" data-sortable="true">
                    <div data-draggable="true" class="card img-task ui-sortable-handle">
                      <div class="card-body">
                        <div class="task-header">
                            <h5 class="fw-semibold"><i class="ph ph-bank me-2"></i>口座情報</h5>
                        </div>
                        <div class="task-content">
                          <p class="mb-0">銀行口座に関する情報<br />{{$user->bank_name}}銀行（銀行番号：{{$user->bank_number}}）（{{ $user->bank_account_status ? App\Models\User::BANK_STATUS[$user->bank_account_status] : ''}}）<br />{{$user->bank_branch_name}}支店（支店番号：{{$user->bank_branch_number}}）<br />口座番号：{{$user->bank_account}}<br />口座名義人：{{$user->bank_account_name}}（{{$user->bank_account_name_kana}}）</p>
                        </div>
                      </div>
                    </div>

                    <div data-draggable="true" class="card img-task ui-sortable-handle">
                      <div class="card-body">
                        <div class="task-header">
                            <h5 class="fw-semibold"><i class="ph ph-palette me-2"></i>他重要情報</h5>
                        </div>
                        <div class="task-content">
                          <p class="mb-0">mattermostで使う絵文字：{{$user->emoji_mm}}<br />アドビCCアカウント:{{ $user->adobe_account }}<br />アドビCCパスワード:{!! $user->adobe_pass ? \Crypt::decrypt($user->adobe_pass) : '' !!}</p>
                        </div>
                      </div>
                    </div>

                    
                  </div>
                </div>
            </div>

        </div>
    </div>
  </div>

</div>