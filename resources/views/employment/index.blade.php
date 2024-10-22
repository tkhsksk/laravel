@extends('common.layout')

@section('title',       '雇用形態一覧')
@section('description', '')
@section('keywords',    '')

@include('common.head')
@include('common.header')
@include('common.aside')

@section('contents')
<link href="@asset('/css/bootstrap4-toggle.min.css')" rel="stylesheet">
<script src="@asset('/js/bootstrap4-toggle.min.js')"></script>
<script>
$(function getEmployment() {
  toggle = $('#toggle-status');
  $('.chat-employment').on('click',function(){
    part_val = $(this).attr('aria-label');
    modal    = $('#employmentModal');
    
    $.ajax({
        url: '{{ route('employment.ajax') }}',
        type: 'get',
        data: {val : part_val},
        datatype: 'json',
    })
    .done((data) => {
        console.log(data);
        modal.modal('show');
        modal.find('input[name=id]').val(data.id);
        modal.find('input[name=name]').val(data.name);
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

  $('#employmentModal').on('shown.bs.modal', function (e) {
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
      <p class="mb-0 text-dark">@if($employments->total() > 0)<span class="me-1">現在</span><span class="px-1 fs-5 fw-bolder">{{ $employments->firstItem() }}</span> 〜 <span class="px-1 fs-5 fw-bolder">{{ $employments->lastItem() }}</span>件を表示<span class="d-md-inline d-none">しています</span>@endif</p>
      <h2 class="fw-bolder mb-0 fs-8 lh-base"><span class="fs-3 fw-normal me-md-3 me-2">現在</span>{{ $employments->total() }}<span class="fs-3 fw-normal ms-md-3 ms-2">件の形態<span class="d-md-inline d-none">が登録されています</span></span></h2>
    </div>

    <div class="location-list">
      <div class="card p-0">
        <div class="card-body p-3">
          <div class="d-flex justify-content-between align-items-center gap-6 mb-9">
            <form class="position-relative">
              <input type="text" class="form-control search-chat py-2 ps-5" name="keyword" id="text-srh" placeholder="雇用名称で検索" value="{{ $keyword }}">
              <i class="ph ph-magnifying-glass position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
            </form>
            <a class="fs-6 text-muted" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Filter list"><i class="ti ti-filter"></i></a>
            <a type="button" class="btn btn-primary d-flex align-items-center px-3 gap-6 chat-employment">
              <i class="ph ph-briefcase fs-5"></i>
              <span class="d-none d-md-block font-weight-medium fs-3">雇用形態を追加する</span>
            </a>
          </div>
          <div class="table-responsive rounded">
            <table class="table table-striped text-nowrap align-middle dataTable">
              <thead>

                <tr>
                  <th scope="col">雇用名称</th>
                  <th scope="col">更新日</th>
                  <th scope="col">登録日</th>
                  <th scope="col">ステータス</th>
                  <th scope="col">雇用形態メモ</th>
                </tr>
              </thead>
              <tbody>

                @foreach($employments as $employment)
                <tr class="odd">
                  <td class="sorting_1">
                    <div class="d-flex align-items-center">
                      <a type="button" class="chat-employment" aria-label="{{ $employment->id }}">
                        <img src="@asset('/thumb/no-user.jpeg')" class="rounded-circle object-fit-cover hover-img" alt="" width="46" height="46">
                      </a>
                      <div class="ms-3">
                        <h6 class="fw-semibold mb-1 fs-4"><a type="button" class="chat-employment" aria-label="{{ $employment->id }}">{{ $employment->name }}</a></h6>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="mb-0">{{ $employment->updated_at ? $employment->updated_at->format('Y/m/d') : '未更新' }}</p>
                  </td>
                  <td>
                    <p class="mb-0">{{ $employment->created_at ? $employment->created_at->format('Y/m/d') : '未登録' }}</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      {!! getStatus('有効','無効',$employment->status) !!}
                    </div>
                  </td>
                  <td>
                    <h6 class="mb-0 fs-3">
                      {!! $employment->note ? nl2br($employment->note) : '未登録' !!}
                    </h6>
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
              <p class="mb-0 fs-2 me-8 me-sm-9">{{ $employments->firstItem() }}–{{ $employments->lastItem() }} of {{ $employments->total() }}</p>
              {{ $employments->appends(request()->query())->links('common.pager') }}
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="modal fade" id="employmentModal" tabindex="-1" aria-labelledby="employmentModalTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0">
          <div class="modal-header bg-info-subtle rounded-top">
            <h6 class="modal-title d-flex"><i class="ph ph-briefcase fs-6 me-2"></i><span class="font-weight-medium fs-3">雇用形態を追加する</span></h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="{{ route('employment.update') }}" id="addEmploymentModalTitle" method="post">
            @csrf
          <input type="hidden" name="id" value="">
          <div class="modal-body">
            <div class="notes-box">
              <div class="notes-content">

                  <div class="row">
                    <div class="col-md-8 mb-3">
                      <div class="note-title">
                        <label class="form-label">雇用名称</label>
                        <input type="text" id="name" class="form-control" name="name" placeholder="正社員・パートなど" value="{{ old('name') }}">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="note-title">
                        <label class="form-label w-100">状態</label>
                        <input id="toggle-status" name="status" type="checkbox" value="true" data-toggle="toggle" data-on="有効" data-off="無効" data-onstyle="success" data-off-color="default">
                      </div>
                    </div>
                  </div>
                  <label for="note" class="form-label"><i class="ph ph-list-dashes me-2"></i>雇用形態についてのメモ</label>
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

  </div>
</div>
@endsection

@include('common.footer')