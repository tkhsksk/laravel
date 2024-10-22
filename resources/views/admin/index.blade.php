@extends('common.layout')

@section('title',       '社員・パート一覧')
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
      <p class="mb-0 text-dark">@if($admins->total() > 0)<span class="me-1">現在</span><span class="px-1 fs-5 fw-bolder">{{ $admins->firstItem() }}</span> 〜 <span class="px-1 fs-5 fw-bolder">{{ $admins->lastItem() }}</span>件を表示<span class="d-md-inline d-none">しています</span>@endif</p>
      <h2 class="fw-bolder mb-0 fs-8 lh-base"><span class="fs-3 fw-normal me-md-3 me-2">現在</span>{{ $admins->total() }}<span class="fs-3 fw-normal ms-md-3 ms-2">件のユーザー<span class="d-md-inline d-none">が登録されています</span></span></h2>
    </div>

    <div class="admin-list">
      <div class="card p-0">
        <div class="card-body p-3">
          <div class="d-flex justify-content-between align-items-center gap-6 mb-9">
            <button class="btn bg-warning-subtle text-warning" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
              <i class="ph ph-funnel fw-semibold me-2"></i>フィルター検索
            </button>

            <a href="javascript:void(0)" class="btn btn-primary d-flex align-items-center px-3 gap-6" id="add-user" data-bs-toggle="modal" data-bs-target="#addusermodal">
              <i class="ph ph-user-plus fs-5"></i>
              <span class="d-none d-md-block font-weight-medium fs-3">社員・パートを管理側から追加する</span>
            </a>
          </div>

          <div class="table-responsive rounded">
            <table id="zero_config" class="table table-striped text-nowrap align-middle dataTable" aria-describedby="zero_config_info">

              <thead>
                <tr>
                  <th class="sorting sorting_asc" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 250.141px;">氏名</th>
                  <th class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 180.359px;">肩書と雇用形態</th>
                  <th class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 180.625px;">所属オフィス</th>
                  <th class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 45.5156px;">権限</th>
                  <th class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending" style="width: 105.953px;">入社日</th>
                  <th class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 105.406px;">最終ログイン</th>
                </tr>
              </thead>

              <tbody>
                @foreach($admins as $admin)
                <tr class="odd">
                  <td class="sorting_1">
                    <div class="d-flex align-items-center gap-6">
                      <a href="/user/detail/{{ $admin->id }}">
                      <img src="{{ getUserImage($admin->id) }}" width="46" height="46" class="rounded-circle object-fit-cover card-hover">
                      </a>
                      <div>
                        <h6 class="mb-0"> <a href="/user/detail/{{ $admin->id }}">{{ getNamefromUserId($admin->id) }}</a></h6>
                        <p class="mb-0 d-flex align-items-center flex-wrap fs-3 text-muted">{{ $admin->user->email }}</p>
                      </div>
                    </div>
                  </td>
                  <td>{!! $admin->title ? $admin->title : $yet !!}<br />{!! $admin->employment_id ? '<a class="d-flex align-items-center" href="/employment"><i class="ph ph-briefcase me-2 fs-4"></i>'.$employments->find($admin->employment_id)->name.'</a>' : $yet !!}</td>
                  <td>
                    {!! $admin->department ? '<a href="/corp" class="d-flex align-items-center"><i class="ph ph-building-office me-2 fs-5"></i>'.getCorpName($admin->department->location->corp->id) : $yet !!}</a>
                    {!! $admin->department ? '<a href="/location/detail/'.$locations->find($admin->department->location_id)->id.'" class="d-flex align-items-center"><i class="ph ph-door-open me-2 fs-5"></i>'.$locations->find($admin->department->location_id)->name : $yet !!}</a>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <i class="ph ph-medal-military me-2 fs-5"></i>{{ App\Models\admin::ADMIN_ROLES[$admin->role][0] }}
                    </div>
                  </td>
                  <td>{!! $admin->employed_at ? $admin->employed_at->isoFormat('Y年M月D日(ddd)') : $yet !!}</td>
                  <td><i class="ph ph-stamp me-2 fs-5"></i>{!! $admin->user->signedin_at ? $admin->user->signedin_at->format('Y/m/d').'<br />'.$admin->user->signedin_at->format('H:i:s') : '<span class="text-muted">未ログイン</span>' !!}</td>
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
              <p class="mb-0 fs-2 me-8 me-sm-9">{{ $admins->firstItem() }}–{{ $admins->lastItem() }} of {{ $admins->total() }}</p>
              {{ $admins->appends(request()->query())->links('common.pager') }}
            </div>
          </div>

          <div class="modal fade" id="addusermodal" tabindex="-1" aria-labelledby="addusermodalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content border-0">
                <div class="modal-header bg-info-subtle rounded-top">
                  <h6 class="modal-title text-dark d-flex fw-semibold"><i class="ph ph-user-plus fs-6 me-3"></i><span class="font-weight-medium fs-3">社員・パートを追加する</span></h6>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.add') }}" id="addusersmodalTitle" method="post">
                  @csrf
                <div class="modal-body">
                  <div class="notes-box">
                    <div class="notes-content">

                        <div class="row">
                          <div class="col-md-12 mb-3">
                            <div class="note-title">
                              <label class="form-label">ユーザー名</label>
                              <input type="text" id="name" class="form-control" name="name" placeholder="ニックネーム" value="{{ old('name') }}">
                              <small id="emailHelp" class="form-text text-muted">正式な氏名はユーザー側が入力する必要があります</small>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="note-title">
                              <label class="form-label">メールアドレス</label>
                              <input type="mail" id="email" class="form-control" name="email" placeholder="メールアドレス" value="{{ old('email') }}">
                              <small id="emailHelp" class="form-text text-muted">ドメインportia.co.jpのみ利用可能です</small>
                            </div>
                          </div>
                        </div>

                    </div>
                  </div>
                  <div class="alert alert-light-danger bg-danger-subtle bg-danger-subtle text-danger mt-4 mb-0" role="alert">
                    <h4 class="alert-heading fs-5 fw-semibold"><i class="ph ph-warning-circle me-2"></i>追加をクリックする前にお読みください</h4>
                    <ul class="mb-0">
                      <li>・ユーザーを追加すると、本人のメールアドレス宛に新規登録メールが発送されますので、メールアドレスに間違いがないか十分ご注意ください</li>
                      <li>・新規登録メールは、マスター権限のユーザーにも同時にCCでメールが発送されます</li>
                    </ul>
                  </div>
                </div>
                <div class="modal-footer">
                  <div class="d-flex gap-6">
                    <button class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal" type="button">キャンセル</button>
                    <button id="btn-n-add" class="btn btn-primary" onclick="submitButton(this);"><i class="ph ph-check fs-5 me-2"></i>追加する</button>
                  </div>
                </div>
                </form>
              </div>
            </div>
          </div>

        </div>
      </div>
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

              <h6 class="fw-semibold fs-3 mb-2">氏名・カナ・メールアドレス</h6>
              <div class="input-group">
                <input placeholder="検索ワード" type="text" name="keyword" class="form-control form-control-lg" value="{{ $keyword }}">
                <button class="btn bg-light-subtle text-dark rounded-end border" type="button" aria-label="" onclick="delInput(this);">
                  <i class="ph ph-x"></i>
                </button>
              </div>

              <div class="mt-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-semibold fs-3 mb-0">無効社員も表示する</h6>
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