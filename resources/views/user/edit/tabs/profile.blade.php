<div class="tab-pane fade @if($tab == Cookie::get('tab'))active show @endif" id="pills-{{$name}}" role="tabpanel" aria-labelledby="pills-{{$name}}-tab" tabindex="2">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex flex-wrap justify-content-between">
            <div>
              <h4 class="fw-semibold mb-4 d-flex align-items-center"><i class="{{ App\Models\Admin::ADMIN_MENU_TABS[$name][1] }} me-3 fs-6"></i>{{ App\Models\Admin::ADMIN_MENU_TABS[$name][0] }}に関するデータ</h4>
            </div>
            <div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <div class="card bg-info-subtle rounded-2 shadow-none">
                  <div class="card-body text-center p-2">
                    <div class="d-flex align-items-center justify-content-center mb-4 pt-8">
                      <img src="{{ getUserImage($user->id) }}" alt="" class="img-fluid rounded-circle object-fit-cover" style="height:45px;width:45px;">
                    </div>
                    <div class="d-flex justify-content-center align-items-center mb-2">
                      @if($user->gender)
                      <img src="/icon/{{ $user->gender=='M' ? 'male.svg' : 'female.svg' }}" alt="" class="img-fluid me-2" style="height: 24px;width: 24px;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $user->gender=='M' ? '男性' : '女性' }}" role="button">
                      @endif
                      @if(!$user->first_kana)
                      <h3 class="fw-semibold text-info fs-6 mb-0">
                        {{ getNamefromUserId($user->id) }}
                      </h3>
                      @else
                      <h3 class="fw-semibold text-info fs-6 mt-n2 mb-0">
                        <ruby><rb>{{ $user->first_name }}</rb><rt>{{ $user->first_kana }}</rt></ruby>
                        <ruby><rb>{{ $user->second_name }}</rb><rt>{{ $user->second_kana }}</rt></ruby>
                      </h3>
                      @endif
                    </div>
                    <p class="fw-normal fs-3 mb-2 d-flex align-items-center justify-content-center"><i class="ph ph-identification-badge fs-6 me-2"></i>ユーザー名：{{ $user->name }}</p>
                  </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card bg-info-subtle rounded-2 shadow-none">
                  <div class="card-body text-center p-2">
                    <div class="d-flex align-items-center justify-content-center mb-4 pt-8 fs-8">
                      🎂
                    </div>
                    <h3 class="fw-semibold text-info fs-6">{!! $user->birthday ? $user->birthday->format('Y年n月j日') : $yet !!}</h3>
                    <p class="fw-normal fs-3 mb-2 d-flex align-items-center justify-content-center"><i class="ph ph-baby fs-6 me-2"></i>現在のご年齢：{!! $user->birthday ? getAgefromBirthday($user->birthday).'歳' : $yet !!}</p>
                  </div>
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <li class="d-flex align-items-center gap-6 mb-3">
                <i class="ph ph-map-pin-line fs-5"></i><h6 class="fs-3 fw-semibold mb-0">〒 {{ getPost($user->post) }}<br>{{ $user->address }}</h6>
              </li>
              <iframe src="https://www.google.com/maps?q={{ $user->address }}&output=embed&z=15" width="100%" height="300px" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
            <div class="col-md-6">
              <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center gap-3">
                  <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                    <i class="ph ph-device-mobile text-dark d-block fs-7" width="22" height="22"></i>
                  </div>
                  <div>
                    <h5 class="fs-4 fw-semibold">ユーザーにつながる電話番号</h5>
                    <p class="mb-0">{{ $user->phone }}</p>
                  </div>
                </div>
              </div>

              <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center gap-3">
                  <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                    <i class="ph ph-train text-dark d-block fs-7" width="22" height="22"></i>
                  </div>
                  <div>
                    <h5 class="fs-4 fw-semibold">ユーザーの通勤手段</h5>
                    <p class="mb-0">{!! $user->how_to_commute ? App\Models\User::HOW_TO_COMMUTE[$user->how_to_commute] : $yet !!}</p>
                  </div>
                </div>
              </div>

              <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center gap-3">
                  <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                    <i class="ph ph-train text-dark d-block fs-7" width="22" height="22"></i>
                  </div>
                  <div>
                    <h5 class="fs-4 fw-semibold">ユーザー最寄駅</h5>
                    <p class="mb-0">{{ $user->nearest_station }}駅</p>
                  </div>
                </div>
              </div>

              <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center gap-3">
                  <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                    <i class="ph ph-train text-dark d-block fs-7" width="22" height="22"></i>
                  </div>
                  <div>
                    <h5 class="fs-4 fw-semibold">オフィス降車駅</h5>
                    <p class="mb-0">{{ $user->nearest_station_corp }}駅</p>
                  </div>
                </div>
              </div>

              <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center gap-3">
                  <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                    <i class="ph ph-baby text-dark d-block fs-7" width="22" height="22"></i>
                  </div>
                  <div>
                    <h5 class="fs-4 fw-semibold">配偶者・扶養人数</h5>
                    <p class="mb-0">{!! $user->spouse_status ? App\Models\User::SPOUSE_STATUS[$user->spouse_status] : $yet !!}（{!! $user->dependent ? $user->dependent.'人' : $yet !!}）</p>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <div class="row justify-content-center">
            <div class="col-md-6">
              <div class="connect-sorting connect-sorting-todo">
                <div class="task-container-header">
                  <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="Todo">銀行口座情報</h6>
                </div>
                <div class="connect-sorting-content ui-sortable" data-sortable="true">
                  <div data-draggable="true" class="card img-task ui-sortable-handle">
                    <div class="card-body">
                      <div class="task-header">
                          <h5 class="fw-semibold"><i class="ph ph-bank me-2"></i>銀行名と支店名</h5>
                      </div>
                      <div class="task-content">
                        <p class="mb-0">{!! $user->bank_name ? $user->bank_name : $yet !!}銀行（銀行番号：<span class="font-monospace">{!! $user->bank_number ? $user->bank_number : $yet !!}</span>）</p>
                        <p class="mb-0">{!! $user->bank_branch_name ? $user->bank_branch_name.'支店' : $yet !!}（支店番号：<span class="font-monospace">{!! $user->bank_branch_number ? $user->bank_branch_number : $yet !!}</span>）</p>
                      </div>
                    </div>
                  </div>

                  <div data-draggable="true" class="card img-task ui-sortable-handle">
                    <div class="card-body">
                      <div class="task-header">
                          <h5 class="fw-semibold"><i class="ph ph-numpad me-2"></i>口座番号
</h5>
                      </div>
                      <div class="task-content">
                        <p class="mb-0"><span class="font-monospace">{!! $user->bank_account ? $user->bank_account : $yet !!}</span>（{!! $user->bank_account_status ? App\Models\User::BANK_STATUS[$user->bank_account_status] : $yet !!}）</p>
                      </div>
                    </div>
                  </div>

                  <div data-draggable="true" class="card img-task ui-sortable-handle mb-2">
                    <div class="card-body">
                      <div class="task-header">
                          <h5 class="fw-semibold"><i class="ph ph-user me-2"></i>口座名義人</h5>
                      </div>
                      <div class="task-content">
                        <p class="mb-0">{!! $user->bank_account_name ? $user->bank_account_name : $yet !!}（{!! $user->bank_account_name_kana ? $user->bank_account_name_kana : $yet !!}）</p>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="connect-sorting connect-sorting-todo">
                <div class="task-container-header">
                  <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="Todo">その他ユーザー情報</h6>
                </div>
                <div class="connect-sorting-content ui-sortable" data-sortable="true">
                  <div data-draggable="true" class="card img-task ui-sortable-handle">
                    <div class="card-body">
                      <div class="task-header">
                          <h5 class="fw-semibold"><i class="ph ph-chat-text me-2"></i>Mattermostで使う絵文字</h5>
                      </div>
                      <div class="task-content">
                        <p class="mb-0">{!! $user->emoji_mm ? $user->emoji_mm : $yet !!}</p>
                      </div>
                    </div>
                  </div>

                  <div data-draggable="true" class="card img-task ui-sortable-handle">
                    <div class="card-body">
                      <div class="task-header">
                          <h5 class="fw-semibold"><i class="ph ph-user me-2"></i>Adobe Creative Cloudアカウント</h5>
                      </div>
                      <div class="task-content">
                        <p class="mb-0">{!! $user->adobe_account ? $user->adobe_account : $yet !!}</p>
                      </div>
                    </div>
                  </div>

                  <div data-draggable="true" class="card img-task ui-sortable-handle mb-2">
                    <div class="card-body">
                      <div class="task-header">
                          <h5 class="fw-semibold"><i class="ph ph-password me-2"></i>Adobe Creative Cloudパスワード</h5>
                      </div>
                      <div class="task-content">
                        <p class="mb-0">{!! $user->adobe_pass ? \Crypt::decrypt($user->adobe_pass) : $yet !!}</p>
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

  </div>
</div>