@extends('common.layout')

@section('title',       '機材の編集')
@section('description', '')
@section('keywords',    '')

@include('common.head')
@include('common.header')
@include('common.aside')

@section('contents')

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
                  <a class="text-muted text-decoration-none" href="/equipment">機材一覧</a>
                </li>
                @isset($equipment->id)
                <li class="breadcrumb-item">
                  <a class="text-muted text-decoration-none" href="/equipment/detail/{{ $equipment->id }}">機材の詳細</a>
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

    <script>
      $(function locationChange() {
        $('select[aria-label="location_id"]').change(function() {
          part_val = $(this).val();
          $.ajax({
              url: '{{ route('equipment.ajax') }}',
              type: 'get',
              data: {val : part_val},
              datatype: 'json',
          })
          .done((data) => {
              // 子カテゴリのoptionを一旦削除
              var targetSelect = 'select[aria-label="admin_id"]';
              $(targetSelect+' option').remove();
              // DBから受け取ったデータを子カテゴリのoptionにセット
              console.log(data);
              $(targetSelect).append($('<option>').text('選択して下さい').attr('value', ''));
              $.each(data, function(key, value) {
                if(value.first_name){
                  $(targetSelect).append($('<option>').text(value.first_name+' '+value.second_name).attr('value', value.id));
                } else {
                  $(targetSelect).append($('<option>').text(value.name).attr('value', value.id));
                }
              });
          })
          .fail((data) => {
              console.log('失敗');
          });
        });
      });
    </script>
    <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>

    <form action="{{ route('equipment.confirm') }}" class="h-adr" novalidate="novalidate" method="post">
    @csrf
      <div class="row justify-content-center">
        <div class="col-lg-9">
          <div class="card">
            <div class="card-body p-4">

              <h4 class="card-title fw-semibold mb-3">機材編集項目</h4>
              <p class="card-subtitle mb-5 lh-base">必須項目を全て入力して左下の「確認する」をクリックして下さい</p>

              <input type="hidden" name="id" value="{{ $equipment ? old('id',$equipment->id) : '' }}">

              <div class="row mb-3">
                <div class="col-md-6">

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3 w-100">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-laptop text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}機材の社内名称</h5>
                        <input type="text" class="form-control" id="portia_number" name="portia_number" value="{{ $equipment ? old('portia_number',$equipment->portia_number) : old('portia_number') }}">
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-buildings text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}機材保管場所</h5>
                        <select class="form-select" aria-label="location_id" name="location_id">
                            <option value="">選択して下さい</option>
                          @foreach($locations as $location)
                            <option value="{{ $location->id }}" {{ $equipment ? (old('location_id',$equipment->location_id) == $location->id ? 'selected' : '') : (old('location_id') == $location->id ? 'selected' : '') }}>{{ $location->corp->name }}｜{{ $location->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-user text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">機材を利用しているユーザー</h5>
                        <select class="form-select" aria-label="admin_id" name="admin_id">
                            <option value="">選択して下さい</option>
                          @foreach($admins as $admin)
                            <option value="{{ $admin->id }}" {{ $equipment ? (old('admin_id',$equipment->admin_id) == $admin->id ? 'selected' : '') : (old('admin_id') == $admin->id ? 'selected' : '') }}>{{ getNamefromUserId($admin->id) }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-toggle-left text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}機材利用状態</h5>
                        <select class="form-select" aria-label="status" name="status">
                            <option value="">選択して下さい</option>
                          @foreach(App\Models\Equipment::EQUIPMENT_STATUS as $index => $status)
                            <option value="{{ $index }}" {{ $equipment ? (old('status',$equipment->status) == $index ? 'selected' : '') : (old('status') == $index ? 'selected' : '') }}>{{ $status[0] }}</option>
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
                        <i class="ph ph-device-mobile text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}機材カテゴリー</h5>
                        <select class="form-select" aria-label="category" name="category">
                            <option value="">選択して下さい</option>
                          @foreach(App\Models\Equipment::EQUIPMENT_CATEGORIES as $index => $category)
                            <option value="{{ $index }}" {{ $equipment ? (old('category',$equipment->category) == $index ? 'selected' : '') : (old('category') == $index ? 'selected' : '') }}>{{ $category[0] }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-barcode text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}機材型番</h5>
                        <input type="text" id="number" name="number" class="form-control" value="{{ $equipment ? old('number',$equipment->number) : old('number') }}">
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-currency-jpy text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">機材購入価格</h5>
                        <div class="input-group border rounded-1">
                          <input type="text" id="price" name="price" class="form-control border-0" value="{{ $equipment ? old('price',floatval($equipment->price)) : old('price') }}">
                          <span class="input-group-text bg-transparent px-6 border-0" id="price_yen">円</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                        <i class="ph ph-calendar text-dark d-block fs-7" width="22" height="22"></i>
                      </div>
                      <div>
                        <h5 class="fs-4 fw-semibold">{!! $required_badge !!}機材購入日</h5>
                        <div class="input-group">
                          <input type="date" id="purchased_at" name="purchased_at" class="form-control" value="{{ $equipment ? old('purchased_at',$equipment->purchased_at->format('Y-m-d')) : old('purchased_at') }}">
                          <button class="btn bg-primary-subtle text-primary  rounded-end" type="button" aria-label="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" onclick="inputToday(this);">
                            本日の日付
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

              <div class="row">

                <div class="col-md-6 mb-4">
                  <div class="connect-sorting connect-sorting-todo">
                    <div class="task-container-header">
                      <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="Todo">バージョン・サイズなど</h6>
                    </div>
                    <div class="connect-sorting-content ui-sortable" data-sortable="true">

                      <div data-draggable="true" class="card img-task ui-sortable-handle">
                        <div class="card-body">
                          <div class="task-header">
                              <h5 class="fw-semibold d-flex align-items-center"><i class="ph ph-apple-logo me-2"></i>機材に導入されているOS</h5>
                          </div>
                          <div class="input-group">
                            <input type="text" list="oslist" id="os" name="os" class="form-control" value="{{ $equipment ? old('os',$equipment->os) : old('os') }}">
                            <datalist id="oslist">
                              <option value="Windows">
                            　<option value="macOS">
                            　<option value="Linux">
                            </datalist>
                            <input type="text" id="os_version" name="os_version" class="form-control" value="{{ $equipment ? old('os_version',$equipment->os_version) : old('os_version') }}" placeholder="バージョン">
                          </div>
                        </div>
                      </div>

                      <div data-draggable="true" class="card img-task ui-sortable-handle">
                        <div class="card-body">
                          <div class="task-header">
                              <h5 class="fw-semibold d-flex align-items-center"><i class="ph ph-monitor me-2"></i>ディスプレイサイズ</h5>
                          </div>
                          <div class="input-group border rounded-1">
                            <input type="text" id="display_size" name="display_size" class="form-control border-0" value="{{ $equipment ? floatval(old('display_size',$equipment->display_size)) : old('display_size') }}">
                            <span class="input-group-text bg-transparent px-6 border-0" id="inch">インチ</span>
                          </div>
                        </div>
                      </div>

                      <div data-draggable="true" class="card img-task ui-sortable-handle">
                        <div class="card-body">
                          <div class="task-header">
                            <h5 class="fw-semibold"><i class="ph ph-calendar me-2"></i>機材の利用開始日</h5>
                          </div>
                          <div class="task-content">
                            <div class="input-group">
                              <input type="date" id="used_at" name="used_at" class="form-control" value="{{ $equipment ? ($equipment->used_at ? old('used_at',$equipment->used_at) : old('used_at')) : old('used_at') }}">
                              <button class="btn bg-primary-subtle text-primary  rounded-end" type="button" aria-label="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" onclick="inputToday(this);">
                                本日の日付
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>

                <div class="col-md-6 mb-4">
                  <div class="connect-sorting connect-sorting-todo">
                    <div class="task-container-header">
                      <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="Todo">機材スペックなど</h6>
                    </div>
                    <div class="connect-sorting-content ui-sortable" data-sortable="true">
                      <div data-draggable="true" class="card img-task ui-sortable-handle">
                        <div class="card-body">
                          <div class="task-header">
                              <h5 class="fw-semibold"><i class="ph ph-memory me-2"></i>機材メモリ</h5>
                          </div>
                          <input type="text" id="memory" name="memory" class="form-control" value="{{ $equipment ? old('memory',$equipment->memory) : old('memory') }}">
                        </div>
                      </div>

                      <div data-draggable="true" class="card img-task ui-sortable-handle">
                        <div class="card-body">
                          <div class="task-header">
                              <h5 class="fw-semibold">
                                <i class="ph ph-hard-drives me-2"></i>機材ストレージ</h5>
                          </div>
                          <input type="text" id="storage" name="storage" class="form-control" value="{{ $equipment ? old('storage',$equipment->storage) : old('storage') }}">
                        </div>
                      </div>

                      <div data-draggable="true" class="card img-task ui-sortable-handle">
                        <div class="card-body">
                          <div class="task-header">
                              <h5 class="fw-semibold"><i class="ph ph-cpu me-2"></i>機材プロセッサ</h5>
                          </div>
                          <div class="task-content">
                            <p class="mb-0">
                              <input type="text" id="processor" name="processor" class="form-control" value="{{ $equipment ? ($equipment->processor ? old('processor',$equipment->processor) : old('processor')) : old('processor') }}">
                            </p>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>

              </div>

              <div class="p-4 rounded-2 text-bg-light">
                <label for="note" class="form-label"><i class="ph ph-list-dashes me-2"></i>機材についてのメモ</label>
                <textarea class="form-control bg-white" name="note" rows="4">{{ $equipment ? old('note',$equipment->note) : old('note') }}</textarea>
              </div>

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