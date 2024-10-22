@extends('common.layout')

@section('title',       'サイトの詳細')
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
                  <a class="text-muted text-decoration-none" href="/site">サイト一覧</a>
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

    <div class="row justify-content-center">
      <div class="col-lg-9">
        <div class="card position-relative">
          <a href="/site/edit/{{ $site->id }}" class="text-bg-primary fs-6 rounded-circle p-2 text-white d-inline-flex position-absolute top-0 end-0 mt-n3 me-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="編集する"><i class="ph ph-pencil-line fs-6"></i></a>
          <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between">
              <div>
                <p class="mb-1">サイト名</p>
                <h4 class="fw-semibold mb-3 d-flex align-items-center text-break"><i class="ph ph-browsers me-2 fs-5"></i>{{ $site->name ? $site->name : getSiteDatas($site->url)['title'] }}</h4>
              </div>
              <div>
                <div class="d-flex align-items-center">
                  <span class="{{ App\Models\Admin::ADMIN_STATUS[$site->status][1] }} p-1 rounded-circle"></span>
                  <p class="mb-0 ms-2">{{ App\Models\Admin::ADMIN_STATUS[$site->status][0] }}</p>
                </div>
                <p class="text-muted mb-0">登録日：{{ $site->created_at->format('Y/n/j') }}</p>
                <p class="text-muted">更新日：{!! $site->updated_at ? $site->updated_at->format('Y/n/j') : $yet !!}</p>
              </div>
            </div>

            <div class="p-4 rounded-2 text-bg-light mb-4 d-flex">
              <i class="ph ph-list-dashes me-2 pt-1"></i><p class="mb-0 fs-3">{!! $site->note ? nl2br($site->note) : '<span class="text-muted">サイトメモ未登録</span>' !!}</p>
            </div>

            <div class="row mb-3">
              <div class="col-md-6 mb-3">
                <div class="ratio ratio-4x3">
                  <img src="{{ getSiteDatas($site->url)['ogpimg'] }}" class="object-fit-contain card-img" alt="">
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="d-flex align-items-center gap-3">
                    <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                      <i class="ph ph-browsers text-dark d-block fs-7" width="22" height="22"></i>
                    </div>
                    <div>
                      <h5 class="fs-4 fw-semibold">サイトURL</h5>
                      <p class="mb-0 text-break"><a href="{{ $site->url }}" target="_blank">{{ $site->url }}</a></p>
                    </div>
                  </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="d-flex align-items-center gap-3">
                    <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                      <i class="ph ph-user text-dark d-block fs-7" width="22" height="22"></i>
                    </div>
                    <div>
                      <h5 class="fs-4 fw-semibold">サイト情報最終更新者</h5>
                      <p class="mb-0">{{ getNamefromUserId($site->register_id) }}</p>
                    </div>
                  </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="d-flex align-items-center gap-3">
                    <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                      <i class="ph ph-user-circle-gear text-dark d-block fs-7" width="22" height="22"></i>
                    </div>
                    <div>
                      <h5 class="fs-4 fw-semibold">サイト管理画面URL</h5>
                      <p class="mb-0"><a href="{{ $site->url_admin }}" target="_blank">{{ $site->url_admin }}</a></p>
                    </div>
                  </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="d-flex align-items-center gap-3">
                    <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                      <i class="ph ph-password text-dark d-block fs-7" width="22" height="22"></i>
                    </div>
                    <div>
                      <h5 class="fs-4 fw-semibold">basic認証</h5>
                      @if($site->basic_id)
                      <div class="table-responsive border rounded">
                        <table class="table mb-0">
                          <tr><td class="fw-semibold p-2 bg-info-subtle text-end w-30">user</td><td class="p-2"><span class="d-flex">{{ $site->basic_id }}<a class="ms-1 d-flex align-items-center justify-content-center" data-text="{{ $site->basic_id }}" onclick="copyText(this);" role="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="コピーする"><i class="ph ph-clipboard-text text-dark d-block fs-5" data-bs-toggle="collapse" data-bs-target="#collapseSignin" aria-expanded="false" aria-controls="collapseSignin"></i></a></span></td></tr>
                          <tr><td class="fw-semibold p-2 bg-info-subtle text-end w-30 border-0">pass</td><td class="p-2 border-0"><span class="d-flex">{{ cryptDecrypt($site->basic_pass) }}<a class="ms-1 d-flex align-items-center justify-content-center" data-text="{{ cryptDecrypt($site->basic_pass) }}" onclick="copyText(this);" role="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="コピーする"><i class="ph ph-clipboard-text text-dark d-block fs-5" data-bs-toggle="collapse" data-bs-target="#collapseSignin" aria-expanded="false" aria-controls="collapseSignin"></i></a></span></td></tr>
                        </table>
                      </div>
                      @endif
                    </div>
                  </div>
                </div>

              </div>
            </div>

            <div class="row">

              <div class="col-md-6 mb-4">
                <div class="connect-sorting connect-sorting-todo">
                  <div class="task-container-header">
                    <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="Todo">サーバー・DBについて</h6>
                  </div>
                  <div class="connect-sorting-content ui-sortable" data-sortable="true">
                    <div data-draggable="true" class="card img-task ui-sortable-handle">
                      <div class="card-body">
                        <div class="task-header">
                            <h5 class="fw-semibold"><i class="ph ph-hard-drives me-2"></i>サーバー管理</h5>
                        </div>
                        <div class="task-content">
                          <p class="mb-0">
                            {!! App\Models\Site::getServer($site->server_id) !!}
                          </p>
                        </div>
                      </div>
                    </div>

                    <div data-draggable="true" class="card img-task ui-sortable-handle">
                      <div class="card-body">
                        <div class="task-header">
                            <h5 class="fw-semibold"><i class="ph ph-database me-2"></i>db管理</h5>
                        </div>
                        <div class="task-content">
                          <p class="mb-0">
                            {!! App\Models\Site::getDatabase($site->db_id) !!}
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

              <div class="col-md-6 mb-4">
                <div class="connect-sorting connect-sorting-todo">
                  <div class="task-container-header">
                    <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="Todo">ドメイン・gitなど</h6>
                  </div>
                  <div class="connect-sorting-content ui-sortable" data-sortable="true">
                    <div data-draggable="true" class="card img-task ui-sortable-handle">
                      <div class="card-body">
                        <div class="task-header">
                            <h5 class="fw-semibold"><i class="ph ph-hard-drive me-2"></i>ドメイン管理サイト</h5>
                        </div>
                        <div class="task-content">
                          <p class="mb-0">
                            {!! App\Models\Site::getSite($site->domain_site_id) !!}
                          </p>
                        </div>
                      </div>
                    </div>

                    <div data-draggable="true" class="card img-task ui-sortable-handle">
                      <div class="card-body">
                        <div class="task-header">
                            <h5 class="fw-semibold"><i class="ph ph-github-logo me-2"></i>git operation list</h5>
                        </div>
                        <div class="task-content">
                          <p class="mb-0">
                            {{ $site->git }}
                          </p>
                        </div>
                      </div>
                    </div>

                    @if($site->leaving_at)
                    <div data-draggable="true" class="card img-task ui-sortable-handle">
                      <div class="card-body">
                        <div class="task-header">
                            <h5 class="fw-semibold"><i class="ph ph-calendar me-2"></i>オフィス退去日</h5>
                        </div>
                        <div class="task-content">
                          <p class="mb-0">
                            {{ $site->leaving_at->format('Y年n月j日') }}
                          </p>
                        </div>
                      </div>
                    </div>
                    @endif
                  </div>
                </div>
              </div>

              <script>
              $(function getDepartment() {
                $('.chat-department').on('click',function(){
                  part_val = $(this).attr('aria-label');
                  modal = $('#departmentModal');
                  
                  $.ajax({
                      url: '{{ route('location.ajax') }}',
                      type: 'get',
                      data: {val : part_val},
                      datatype: 'json',
                  })
                  .done((data) => {
                      console.log(data);
                      modal.modal('show');
                      modal.find('input[name=id]').val(data.id);
                      modal.find('input[name=name]').val(data.name);
                  })
                  .fail((data) => {
                      console.log('失敗');
                  });
                });
              });
              </script>

            </div>
          </div>
        </div>
      </div>
    </div>
    
	</div>
</div>
@endsection

@include('common.footer')