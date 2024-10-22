@extends('common.layout')

@section('title',       'マニュアルの編集')
@section('description', '')
@section('keywords',    '')

@include('common.head')
@include('common.header')
@include('common.aside')

@section('contents')
<link href="@asset('/css/bootstrap4-toggle.min.css')" rel="stylesheet">
<script src="@asset('/js/bootstrap4-toggle.min.js')"></script>
<script src="@asset('/js/dualbox/jquery.bootstrap-duallistbox.js')"></script>

<script>
  tinyMce('manual');
</script>

<div class="body-wrapper">
	<div class="container-fluid">

    @include('common.alert')

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
                  <a class="text-muted text-decoration-none" href="/manual">マニュアル一覧</a>
                </li>
                @isset($manual->id)
                <li class="breadcrumb-item">
                  <a class="text-muted text-decoration-none" href="/manual/detail/{{ $manual->id }}">マニュアルの詳細</a>
                </li>
                @endisset
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

    <form action="{{ route('manual.confirm') }}" class="h-adr" novalidate="novalidate" method="post">
    @csrf
      <div class="row justify-content-center">
        <div class="col-12">
          <div class="card">
            <div class="card-body p-4">

              <h4 class="card-title fw-semibold mb-3">@yield('title')項目</h4>
              <p class="card-subtitle mb-5 lh-base">必須項目を全て入力して左下の「確認する」をクリックして下さい</p>

              <input type="hidden" name="id" value="{{ $manual ? old('id',$manual->id) : '' }}">
              @if($manual)
              <input type="hidden" name="register_id" value="{{ old('id',$manual->register_id) }}">
              <input type="hidden" name="updater_id" value="{{ Auth::user()->id }}">
              @else
              <input type="hidden" name="register_id" value="{{ Auth::user()->id }}">
              <input type="hidden" name="updater_id" value="">
              @endif

              <div class="row mb-3">

                <div class="col-12">
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3 w-100">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-text-h-one text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div class=" w-100">
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}マニュアルタイトル</h5>
                        <input type="text" class="form-control form-control-lg" id="title" name="title" value="{{ $manual ? old('title',$manual->title) : old('title') }}">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-7">
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3 w-100">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-medal-military text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div class="w-100">
                        <div class="row w-100">
                        <div class="col-12">
                          <h5 class="fs-4 fw-semibold">{!! $required_badge !!}公開状態と閲覧権限</h5>
                        </div>
                        <div class="col-auto gap-2 d-flex flex-wrap">
                          <div class="col-auto">
                            <input name="status" type="checkbox" value="true" data-toggle="toggle" data-on="公開" data-off="非公開" data-onstyle="success" data-off-color="default"
                            @if($manual)
                              @if(old('status'))
                              checked
                              @else
                              {{ $manual->status == 'E' ? 'checked' :'' }}
                              @endif
                            @else
                            {{ !old('status') ?: 'checked' }}
                            @endif>
                          </div>
                          <div>
                            <select class="form-select form-select-lg" aria-label="role" name="role">
                                @foreach(getSelectableRole() as $in => $val)
                                  <option value="{{ $in }}"
                                  @if($manual)
                                  {{ old('role',$manual->role) != $in ?: 'selected' }}
                                  @else
                                  {{ old('role') != $in ?: 'selected' }}
                                  @endif>{{ $val['label'] }}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-5">
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3 w-100">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-office-chair text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div class="w-100">
                        <div class="row w-100">
                        <div class="col-12">
                          <h5 class="fs-4 fw-semibold">{!! $required_badge !!}対象部署</h5>
                        </div>
                        <div class="col-auto gap-2 d-flex flex-wrap">
                          <div>
                            <select class="form-select form-select-lg" aria-label="department_id" name="department_id">
                                <option value="">すべての部署</option>
                                @foreach(App\Models\Department::all() as $department)
                                <option value="{{ $department->id }}"
                                  @if($manual)
                                  {{ old('department_id',$manual->department_id) != $department->id ?: 'selected' }}
                                  @else
                                  {{ old('department_id') != $department->id ?: 'selected' }}
                                  @endif>{{ $department->name }}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="accordion accordion-flush card position-relative overflow-hidden shadow-none" id="accordionFlushExample">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                      <button class="accordion-button fs-3 shadow-none collapsed bg-primary-subtle rounded-1 py-3" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOneUpdateble" aria-expanded="false" aria-controls="flush-collapseOne">
                        <i class="ph ph-question me-2"></i>あなた以外もマニュアルを編集可能にしたい場合
                      </button>
                    </h2>
                    <div id="flush-collapseOneUpdateble" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" style="">
                      <div class="fw-normal">
                        <div class="row">
                          <div class="col-lg-12">
                                <p class="card-subtitle mb-4 pt-3">登録者である、あなた以外のユーザーを編集可能にしたい場合は、左のボックスから選択して下さい<br />未選択の場合は、<code>あなただけが</code>マニュアルを編集できます</p>
                                <div class="">
                                <form id="equipments_form" action="#" method="post">
                                  @csrf
                                  <select name="updatable_ids[]" multiple>
                                    @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}" role="button" @if($manual)@if(in_array($admin->id, explode(', ',$manual->updatable_ids)))selected @endif @endif>{{ getNamefromUserId($admin->id,'U') }}</option>
                                    @endforeach
                                  </select>
                                </form>
                                <script>
                                  var charger_check = $('select[name="updatable_ids[]"]')
                                  .bootstrapDualListbox({
                                    filterTextClear:      '<i class="ph ph-x fs-2"></i>',
                                    filterPlaceHolder:    'ユーザーの検索',
                                    moveSelectedLabel:    '選択済みに移動',
                                    moveAllLabel:         '選択済みに全て移動',
                                    removeSelectedLabel:  '選択を解除',
                                    removeAllLabel:       '選択を全て解除',
                                    nonSelectedListLabel: '編集不可ユーザー',
                                    selectedListLabel:    '編集可能ユーザー',
                                    infoText:             '（{0}件）',
                                    infoTextEmpty:        '（0件）',
                                    infoTextFiltered:     '（該当：{0}件 / 全{1}件）',
                                  });
                                </script>

                                </div> 
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <h5 class="fs-4 fw-semibold"><i class="ph ph-pencil-line me-2"></i>マニュアル本文</h5>
              <p class="mb-3 card-subtitle">本文に埋め込める画像ファイルの最大サイズは <code>500KB</code> です</p>
              <textarea class="form-control bg-white tinymce" name="note">{{ $manual ? old('note',$manual->note) : old('note') }}</textarea>

              <div class="d-flex align-items-center justify-content-end mt-4 gap-6">
                <button onclick="submitButton(this);" class="btn btn-primary"><i class="ph ph-check fs-5 me-2"></i>
                  確認する</button>
                <button class="btn bg-danger-subtle text-danger" onClick="history.back()" type="button"><i class="ph ph-arrow-u-up-left fs-5 me-2"></i>
                  戻る</button>
              </div>

            </div>
          </div>
        </div>
      </div>
    </form>
    
	</div>
</div>
@endsection

@include('common.footer')