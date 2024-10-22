@extends('common.layout')

@section('title',       '企業一覧')
@section('description', '')
@section('keywords',    '')

@include('common.head')
@include('common.header')
@include('common.aside')

@section('contents')
<link href="@asset('/css/bootstrap4-toggle.min.css')" rel="stylesheet">
<script src="@asset('/js/bootstrap4-toggle.min.js')"></script>
<script>
$(function getData() {
  toggle = $('#toggle-status');
  $('.boot-modal').on('click',function(){
    part_val = $(this).attr('aria-label');
    modal    = $('#updateModal');
    
    $.ajax({
        url: '{{ route('corp.ajax') }}',
        type: 'get',
        data: {val : part_val},
        datatype: 'json',
    })
    .done((data) => {
        console.log(data);
        modal.modal('show');
        const arr = ['id','name','kana','cto','corp_mynumber','capital_stock','establishmented_at'];
        for(key in arr) {
          modal.find('input[name='+arr[key]+']').val(data[arr[key]]);
        }
        if(data.status == 'E'){
          toggle.bootstrapToggle('on')
        } else {
          toggle.bootstrapToggle('off')
        }
        modal.find('textarea[name=note]').val(data.note);
    })
    .fail((data) => {
        console.log('失敗');
    });
  });

  $('#updateModal').on('shown.bs.modal', function (e) {
    toggle.bootstrapToggle('destroy')
    toggle.bootstrapToggle('enable')
  })
});
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

    <div class="d-flex justify-content-between mb-2 align-items-end flex-wrap">
      <p class="mb-0 text-dark">@if($corps->total() > 0)<span class="me-1">現在</span><span class="px-1 fs-5 fw-bolder">{{ $corps->firstItem() }}</span> 〜 <span class="px-1 fs-5 fw-bolder">{{ $corps->lastItem() }}</span>件を表示<span class="d-md-inline d-none">しています</span>@endif</p>
      <h2 class="fw-bolder mb-0 fs-8 lh-base"><span class="fs-3 fw-normal me-md-3 me-2">現在</span>{{ $corps->total() }}<span class="fs-3 fw-normal ms-md-3 ms-2">件の企業<span class="d-md-inline d-none">が登録されています</span></span></h2>
    </div>

    <div class="corp-list">
      <div class="card p-0">
        <div class="card-body p-3">
          <div class="d-flex justify-content-between align-items-center gap-6 mb-9">
            <button class="btn bg-warning-subtle text-warning" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
              <i class="ph ph-funnel fw-semibold me-2"></i>フィルター検索
            </button>
            <a type="button" class="btn btn-primary d-flex align-items-center px-3 gap-6 boot-modal">
              <i class="ph ph-building-office fs-5"></i>
              <span class="d-none d-md-block font-weight-medium fs-3">企業を追加する</span>
            </a>
          </div>
          <div class="table-responsive rounded">
            <table class="table table-striped text-nowrap align-middle dataTable">
              <thead>

                <tr>
                  <th scope="col">名称</th>
                  <th scope="col">代表者名</th>
                  <th scope="col">登録オフィス</th>
                  <th scope="col">法人マイナンバー（法人番号）</th>
                  <th scope="col">法人インボイス番号</th>
                  <th scope="col">ステータス</th>
                </tr>
              </thead>
              <tbody>

                @foreach($corps as $corp)
                <tr class="odd">
                  <td class="sorting_1">
                    <div class="d-flex align-items-center">
                      <a type="button" class="boot-modal" aria-label="{{ $corp->id }}">
                        <img src="@asset('/thumb/no-bg.svg')" class="rounded-circle object-fit-cover hover-img" alt="" width="46" height="46">
                      </a>
                      <div class="ms-3">
                        <h6 class="fw-semibold mb-1 fs-4"><a type="button" class="boot-modal" aria-label="{{ $corp->id }}">{{ $corp->name }}</a></h6>
                        <p class="fs-3 mb-0 text-muted">{{ $corp->kana }}</p>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="mb-0">{{ $corp->cto ? $corp->cto : '未登録' }}</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      @foreach($corp->location as $location)
                        @if($loop->iteration == 4)                     
                         @break                     
                        @endif 
                      @if($location)
                      
                      <div style="width: 39px;height: 39px;" class="rounded-circle me-n2 object-fit-cover hover-img position-relative overflow-hidden">
                        <iframe src="https://www.google.com/maps?q={{ $location->address }}&output=embed&z=5" frameborder="0" style="border:0;" allowfullscreen class="position-absolute top-50 start-50 translate-middle"></iframe>
                        <a style="width: 39px;height: 39px;" class="d-block position-absolute" href="/location/detail/{{ $location->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $location->name }}"></a>
                      </div>
                      @endif
                      @endforeach
                    </div>
                  </td>
                  <td>
                    <h6 class="mb-0 fs-3">
                      {{ $corp->corp_mynumber ? $corp->corp_mynumber : '未登録' }}
                    </h6>
                  </td>
                  <td>
                    <h6 class="mb-0 fs-3">
                      {{ $corp->corp_mynumber ? 'T-'.$corp->corp_mynumber : '未登録' }}
                    </h6>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      {!! getStatus('有効','無効',$corp->status) !!}
                    </div>
                  </td>
                </tr>
                @endforeach
                
              </tbody>
            </table>
            <div class="d-flex align-items-center justify-content-end py-1">
              <p class="mb-0 fs-2 d-none">表示件数：</p>
              <select class="form-select w-auto ms-0 ms-sm-2 me-8 me-sm-4 py-1 pe-7 ps-2 border-0 d-none" aria-label="Default select example">
                <option selected="">5</option>
                <option value="1">10</option>
                <option value="2">25</option>
              </select>
              <p class="mb-0 fs-2 me-8 me-sm-9">{{ $corps->firstItem() }}–{{ $corps->lastItem() }} of {{ $corps->total() }}</p>
              {{ $corps->appends(request()->query())->links('common.pager') }}
            </div>
          </div>

        </div>
      </div>
    </div>
	</div>
</div>

<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0">
      <div class="modal-header bg-info-subtle rounded-top">
        <h6 class="modal-title d-flex"><i class="ph ph-building-office fs-6 me-2"></i><span class="font-weight-medium fs-3">企業を登録する</span></h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('corp.update') }}" id="updateModalTitle" method="post">
        @csrf
      <input type="hidden" name="id" value="">
      <div class="modal-body">
        <div class="notes-box">
          <div class="notes-content">

              <div class="row">
                <div class="col-md-6 mb-3">
                  <div class="note-title">
                    <label class="form-label">名称</label>
                    <input type="text" id="name" class="form-control" name="name" placeholder="" value="{{ old('name') }}">
                  </div>
                </div>

                <div class="col-md-6 mb-3">
                  <div class="note-title">
                    <label class="form-label">名称カナ</label>
                    <input type="text" id="kana" class="form-control" name="kana" placeholder="名称をカナで入力してください" value="{{ old('kana') }}">
                  </div>
                </div>

                <div class="col-md-5 mb-3">
                  <div class="note-title">
                    <label class="form-label">代表者名</label>
                    <input type="text" id="cto" class="form-control" name="cto" placeholder="" value="{{ old('cto') }}">
                  </div>
                </div>

                <div class="col-md-4 mb-3">
                  <div class="note-title">
                    <label class="form-label">設立日</label>
                    <input type="date" id="establishmented_at" class="form-control" name="establishmented_at" placeholder="" value="{{ old('establishmented_at') }}">
                  </div>
                </div>

                <div class="col-md-3 mb-3">
                  <div class="note-title">
                    <label class="form-label w-100">状態</label>
                    <input id="toggle-status" name="status" type="checkbox" value="true" data-toggle="toggle" data-on="有効" data-off="無効" data-onstyle="success" data-off-color="default">
                  </div>
                </div>

                <div class="col-md-6 mb-3">
                  <div class="note-title">
                    <label class="form-label">法人マイナンバー（法人番号）</label>
                    <input type="text" id="corp_mynumber" class="form-control" name="corp_mynumber" placeholder="" value="{{ old('corp_mynumber') }}">
                  </div>
                </div>

                <div class="col-md-6 mb-3">
                  <div class="note-title">
                    <label class="form-label">資本金</label>
                    <div class="input-group border rounded-1">
                      <input type="text" id="capital_stock" name="capital_stock" class="form-control border-0" value="{{ old('capital_stock') }}">
                      <span class="input-group-text bg-transparent px-6 border-0" id="capital_stock">万円</span>
                    </div>
                  </div>
                </div>

              </div>

              <label for="note" class="form-label"><i class="ph ph-list-dashes me-2"></i>企業についてのメモ</label>
              <textarea class="form-control bg-white" name="note" rows="4">{{ old('note') }}</textarea>

          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="d-flex gap-6">
          <button class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal" type="button">キャンセル</button>
          <button onclick="submitButton(this);" id="btn-n-add" class="btn btn-primary">登録する</button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="offcanvas customizer offcanvas-start text-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <form method="get">
  <div class="d-flex align-items-center justify-content-between p-3 border-bottom">

    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    <div class="d-flex align-items-center gap-7">
      <h4 class="offcanvas-title fw-semibold fs-4" id="offcanvasExampleLabel">
        <i class="ph ph-funnel fw-semibold me-2"></i>フィルター検索
      </h4>
      <button type="submit" class="btn btn-primary">検索</button>
    </div>
  </div>
  <div class="offcanvas-body h-n80 simplebar-scrollable-y" data-simplebar="init">
    <div class="simplebar-wrapper">
      <div class="simplebar-height-auto-observer-wrapper">
        <div class="simplebar-height-auto-observer"></div>
      </div>
      <div class="simplebar-mask">
        <div class="simplebar-offset">
          <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content">
            <div class="simplebar-content">

              <h6 class="fw-semibold fs-3 mb-2">名称・カナ</h6>
              <div class="input-group">
                <input type="text" name="keyword" class="form-control form-control-lg" value="{{ $keyword }}">
                <button class="btn btn-light rounded-end border" type="button" aria-label="" onclick="delInput(this);">
                  <i class="ph ph-x"></i>
                </button>
              </div>

              <div class="mt-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-semibold fs-3 mb-0">無効企業も表示する</h6>
                <div class="form-check form-switch mb-0">
                  <input class="form-check-input" type="checkbox" name="status" role="switch" id="flexSwitchCheckChecked" value="1" @isset($status)checked="" @endisset onChange="search(this);">
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="simplebar-placeholder"></div>
    </div>
    <div class="simplebar-track simplebar-horizontal">
      <div class="simplebar-scrollbar"></div>
    </div>
    <div class="simplebar-track simplebar-vertical">
      <div class="simplebar-scrollbar"></div>
    </div>
  </div>
  </form>
</div>
@endsection

@include('common.footer')