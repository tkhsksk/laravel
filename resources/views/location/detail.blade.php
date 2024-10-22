@extends('common.layout')

@section('title',       'オフィスの詳細')
@section('description', '')
@section('keywords',    '')

@include('common.head')
@include('common.header')
@include('common.aside')

@section('contents')

<div class="body-wrapper">
	<div class="container-fluid">

    @include('common.alert')

    <script>
    function inputFile(el) {
      var files    = $(el).prop('files');
      const result = $('#addfilemodal .modal-body .row');
      const array  = ['image/png','image/jpg','image/jpeg'];
      if(files.length > 0){
        $('#addfilemodal').modal('show');
      }
      $('#addfilemodal button.btn-primary').addClass('d-none');
      $.each(files, function(index, value) {
        if($.inArray(value.type, array) != -1){
          $('#btn-n-add').removeClass('d-none');
          var img = window.URL.createObjectURL(value);
        } else {
          $('#btn-f-add').removeClass('d-none');
          if(value.type == 'image/vnd.adobe.photoshop'){
            var img = '/image/admin/icon-psd.svg';
          } else if (value.type == 'application/postscript') {
            var img = '/image/admin/icon-ai.svg';
          } else {
            var img = '/image/admin/icon-pdf.svg';
          }
        }
        result
        .append(
           '<div class="col-auto mb-2">'
          +'<div class="hstack gap-3 file-chat-hover justify-content-between">'
          +'<div class="d-flex align-items-center gap-3">'
          +'<div class="rounded-1 text-bg-light p-6">'
          +'<img src="'+img+'" alt="modernize-img object-fit-contain" width="24" height="24">'
          +'</div>'
          +'<div><h6 class="fw-semibold pre">'+value.name+'</h6>'
          +'<div class="d-flex align-items-center gap-3 fs-2 text-muted">'
          +'<span>'+getSizeStr(value.size)+'</span>'
          +'<span>'+value.type+'</span>'
          +'</div>'
          +'</div>'
          +'</div>'
          +'</div>'
          +'</div>'
        );
      });

      $('#addfilemodal').on('hidden.bs.modal', function (e) {
        result.empty();
      });

      submitMedia();
      submitFile();
    };

    function prevFile(el) {
      $('#prevfilemodal').modal('show');
      part_val = $(el).attr('aria-label');
      const result = $('#prevfilemodal .modal-body');
      $.ajax({
          url: '{{ route('getfiledata') }}',
          type: 'get',
          data: {val : part_val},
          datatype: 'json',
      })
      .done((data) => {
          console.log(data);
          if(data.extension == 'jpg'||data.extension == 'jpeg'||data.extension == 'png'){
            var img = '<img src="/protected/location/'+data.location_id+'/'+data.name+'" class="modernize-img object-fit-contain mx-auto d-block mb-3">';
          } else if(data.extension == 'pdf'||data.extension == 'ai') {
            var img = '<iframe src="/protected/location/'+data.location_id+'/'+data.name+'" height="390" frameborder="0" class="border-0 w-100"></iframe>';
          } else {
            var img = '<img src="/image/admin/icon-'+data.extension+'.svg" style="max-height:300px" class="mb-3 d-block mx-auto">';
          }
          result
          .append(
             img
            +'<div class="rounded-1 text-bg-light p-6">'
            +'<div><h6 class="fw-semibold pre">'+data.name+'</h6>'
            +'<div class="d-flex align-items-center gap-3 fs-2 text-muted">'
            +'<span>'+getSizeStr(data.size)+'</span>'
            +'<span>'+data.origin_name+'</span>'
            +'<span>'+data.create_date+'</span>'
            +'<span>'+data.register_name+'</span>'
            +'</div>'
            +'</div>'
            +'</div>'
          );
      })
      .fail((data) => {
          console.log('失敗');
      });

      $('#prevfilemodal').on('hidden.bs.modal', function (e) {
        result.empty();
      });
    }

    function submitMedia() {
      $('#btn-n-add').on('click',function(){
        $('#submit-media').trigger('click');
      });
    }

    function submitFile() {
      $('#btn-f-add').on('click',function(){
        $('#submit-file').trigger('click');
      });
    }
  </script>

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
                  <a class="text-muted text-decoration-none" href="/location">オフィス一覧</a>
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
          <a href="/location/edit/{{ $location->id }}" class="text-bg-primary fs-6 rounded-circle p-2 text-white d-inline-flex position-absolute top-0 end-0 mt-n3 me-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="編集する"><i class="ph ph-pencil-line fs-6"></i></a>
          <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between">
              <div>
                <p class="mb-1">オフィス名称</p>
                <h4 class="fw-semibold mb-3 d-flex align-items-center"><i class="ph ph-door-open me-2 fs-5"></i>{{ $location->name }}</h4>
              </div>
              <div>
                <div class="d-flex align-items-center">
                  <span class="{{ App\Models\Location::LOCATION_STATUS[$location->status][1] }} p-1 rounded-circle"></span>
                  <p class="mb-0 ms-2">{{ App\Models\Location::LOCATION_STATUS[$location->status][0] }}</p>
                </div>
                <p class="text-muted mb-0">登録日：{{ $location->created_at->format('Y/n/j') }}</p>
                <p class="text-muted">更新日：{!! $location->updated_at ? $location->updated_at->format('Y/n/j') : $yet !!}</p>
              </div>
            </div>

            <div class="p-4 rounded-2 text-bg-light mb-4 d-flex">
              <i class="ph ph-list-dashes me-2 pt-1"></i><p class="mb-0 fs-3">{!! $location->note ? nl2br($location->note) : '<span class="text-muted">オフィスメモ未登録</span>' !!}</p>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <li class="d-flex align-items-center gap-6 mb-3">
                  <i class="ph ph-map-pin-line fs-5"></i><h6 class="fs-3 fw-semibold mb-0">〒 {{ getPost($location->post) }}<br>{{ $location->address }}</h6>
                </li>
                <iframe src="https://www.google.com/maps?q={{ $location->address }}&output=embed&z=14" width="100%" height="300px" frameborder="0" style="border:0" allowfullscreen></iframe>
              </div>
              <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="d-flex align-items-center gap-3">
                    <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                      <i class="ph ph-building-office text-dark d-block fs-7" width="22" height="22"></i>
                    </div>
                    <div>
                      <h5 class="fs-4 fw-semibold">企業名</h5>
                      <p class="mb-0">{{ $location->corp->name }}</p>
                    </div>
                  </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="d-flex align-items-center gap-3">
                    <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                      <i class="ph ph-device-mobile text-dark d-block fs-7" width="22" height="22"></i>
                    </div>
                    <div>
                      <h5 class="fs-4 fw-semibold">オフィス電話番号</h5>
                      <p class="mb-0">{{ $location->phone }}</p>
                    </div>
                  </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="d-flex align-items-center gap-3">
                    <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                      <i class="ph ph-train text-dark d-block fs-7" width="22" height="22"></i>
                    </div>
                    <div>
                      <h5 class="fs-4 fw-semibold">オフィス最寄駅</h5>
                      <p class="mb-0">{{ $location->nearest_station }}駅（他オフィス最寄駅：{{ $location->other_stations ? $location->other_stations : 'なし' }}）</p>
                    </div>
                  </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="d-flex align-items-center gap-3">
                    <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                      <i class="ph ph-calendar text-dark d-block fs-7" width="22" height="22"></i>
                    </div>
                    <div>
                      <h5 class="fs-4 fw-semibold">入居開始日</h5>
                      <p class="mb-0">{{ $location->occupancy_at->format('Y年n月j日') }}</p>
                    </div>
                  </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="d-flex align-items-center gap-3">
                    <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                      <i class="ph ph-files text-dark d-block fs-7" width="22" height="22"></i>
                    </div>
                    <div>
                      <h5 class="fs-4 fw-semibold">雇用保険適用事業所番号</h5>
                      <p class="mb-0">{{ getInsuranceNumber($location->employment_insurance_number) }}</p>
                    </div>
                  </div>
                </div>

              </div>
            </div>

            <div class="row">

              <div class="col-md-6 mb-4">
                <div class="connect-sorting connect-sorting-todo">
                  <div class="task-container-header">
                    <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="Todo">平米数・金額など</h6>
                  </div>
                  <div class="connect-sorting-content ui-sortable" data-sortable="true">
                    <div data-draggable="true" class="card img-task ui-sortable-handle">
                      <div class="card-body">
                        <div class="task-header">
                            <h5 class="fw-semibold"><i class="ph ph-house-line me-2"></i>オフィス平米数</h5>
                        </div>
                        <div class="task-content">
                          <p class="mb-0">
                            {{ floatval($location->width) }}㎡
                          </p>
                        </div>
                      </div>
                    </div>

                    <div data-draggable="true" class="card img-task ui-sortable-handle">
                      <div class="card-body">
                        <div class="task-header">
                            <h5 class="fw-semibold"><i class="ph ph-house-line me-2"></i>オフィス築年数</h5>
                        </div>
                        <div class="task-content">
                          <p class="mb-0">
                            {{ floatval($location->age) }}年
                          </p>
                        </div>
                      </div>
                    </div>

                    <div data-draggable="true" class="card img-task ui-sortable-handle">
                      <div class="card-body">
                        <div class="task-header">
                            <h5 class="fw-semibold"><i class="ph ph-currency-jpy me-2"></i>オフィス家賃</h5>
                        </div>
                        <div class="task-content">
                          <p class="mb-0">
                            {{ number_format($location->rent) }}円
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
                    <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="Todo">日付・期日など</h6>
                  </div>
                  <div class="connect-sorting-content ui-sortable" data-sortable="true">
                    <div data-draggable="true" class="card img-task ui-sortable-handle">
                      <div class="card-body">
                        <div class="task-header">
                            <h5 class="fw-semibold"><i class="ph ph-calendar me-2"></i>オフィス契約日</h5>
                        </div>
                        <div class="task-content">
                          <p class="mb-0">
                            {{ $location->contracted_at->format('Y年n月j日') }}
                          </p>
                        </div>
                      </div>
                    </div>

                    <div data-draggable="true" class="card img-task ui-sortable-handle">
                      <div class="card-body">
                        <div class="task-header">
                            <h5 class="fw-semibold"><i class="ph ph-calendar me-2"></i>オフィス家賃引落日</h5>
                        </div>
                        <div class="task-content">
                          <p class="mb-0">
                            毎月{{ $location->payment_date }}日
                          </p>
                        </div>
                      </div>
                    </div>

                    @if($location->leaving_at)
                    <div data-draggable="true" class="card img-task ui-sortable-handle">
                      <div class="card-body">
                        <div class="task-header">
                            <h5 class="fw-semibold"><i class="ph ph-calendar me-2"></i>オフィス退去日</h5>
                        </div>
                        <div class="task-content">
                          <p class="mb-0">
                            {{ $location->leaving_at->format('Y年n月j日') }}
                          </p>
                        </div>
                      </div>
                    </div>
                    @endif
                  </div>
                </div>
              </div>

              <hr class="mb-4">
              <h5 class="fw-semibold mb-3 position-relative position-relative">
                {{ $location->name }}に関するファイル
              </h5>

              <div class="row">
                <div class="offcanvas-body p-6 col-md-6">
                  <h6 class="fw-semibold mb-3 text-nowrap">
                    画像メディア一覧 <span class="text-muted me-3">({{ $images->total() }})</span><span class="fw-normal"><code>1MB</code>まで</span>
                  </h6>
                  <a class="chat-menu d-lg-none d-block text-dark fs-6 bg-hover-primary nav-icon-hover position-relative z-index-5" href="javascript:void(0)">
                    <i class="ti ti-x"></i>
                  </a>

                  <div class="row text-nowrap">
                    <div class="col-md-3 col-4 px-1 mb-2">
                      <div class="position-relative upload-area ratio ratio-1x1">
                        <p class="position-absolute top-50 start-50 translate-middle fw-bolder d-flex align-items-center opacity-50 justify-content-center"><i class="ph ph-plus me-2 fw-semibold"></i>追加</p>
                        <form action="{{ route('location.media') }}" method="post" enctype="multipart/form-data">
                          @csrf
                          <input type="hidden" value="{{ $location->id }}" name="location_id">
                          <input name="files[]" required="required" type="file" accept="image/png, image/jpeg, image/jpg" class="top-0 start-0 h-100 w-100 position-absolute" onchange="inputFile(this);" multiple>
                          <input type="submit" id="submit-media" class="d-none">
                        </form>
                      </div>
                    </div>
                    @foreach($images as $image)
                    <div class="col-md-3 col-4 px-1 mb-2">
                      <div class="ratio ratio-1x1 bg-light mb-2">
                        <img src="{{ $image->url }}" alt="modernize-img" class="rounded w-100 h-100 object-fit-cover" onclick="prevFile(this);" role="button" aria-label="{{ $image->id }}">
                      </div>
                    </div>
                    @endforeach
                  </div>

                  <p class="mb-0 fs-2 me-8 me-sm-9">{{ $images->firstItem() }}–{{ $images->lastItem() }}件目 /全 {{ $images->total() }}枚</p>
              {{ $images->links('common.pager') }}

                </div>

                <div class="offcanvas-body p-6 col-md-6">
                  <h6 class="fw-semibold mb-3 text-nowrap">
                    ファイル一覧 <span class="text-muted me-3">({{ $files->total() }})</span><span class="fw-normal"><code>10MB</code>まで</span>
                  </h6>
                  <div class="row text-nowrap">

                    <div class="col-md-12 mb-3">
                      <div class="position-relative upload-area p-9">
                        <p class="position-absolute top-50 start-50 translate-middle fw-bolder d-flex align-items-center opacity-50 justify-content-center"><i class="ph ph-plus me-2 fw-semibold"></i>追加する</p>
                        <form action="{{ route('location.file') }}" method="post" enctype="multipart/form-data">
                          @csrf
                          <input type="hidden" value="{{ $location->id }}" name="location_id">
                          <input name="files[]" required="required" type="file" accept="application/pdf, application/postscript,  image/x-photoshop" class="top-0 start-0 h-100 w-100 position-absolute" onchange="inputFile(this);" multiple>
                          <input type="submit" id="submit-file" class="d-none">
                        </form>
                      </div>
                    </div>
                    
                    @foreach($files as $file)
                    <div class="col-12 mb-9">
                      <div href="{{ $file->url }}" class="hstack gap-3 file-chat-hover justify-content-between text-nowrap">
                        <div class="d-flex align-items-center gap-3" onclick="prevFile(this);" role="button" aria-label="{{ $file->id }}">
                          <div class="rounded-1 text-bg-light p-6">
                            <img src="@asset('/image/admin/icon-{{ $file->extension }}.svg')" alt="modernize-img" width="24" height="24">
                          </div>
                          <div>
                            <h6 class="fw-semibold">
                              {{ $file->name }}
                            </h6>
                            <div class="d-flex align-items-center gap-3 fs-2 text-muted">
                              <span>{{ byteFormat($file->size) }}</span>
                              <span>登録日：{{ $file->created_at->format('Y/m/d') }}</span>
                            </div>
                          </div>
                        </div>
                        <span class="position-relative nav-icon-hover download-file">
                          <i class="ti ti-download text-dark fs-6 bg-hover-primary"></i>
                        </span>
                      </div>
                    </div>
                    @endforeach
                  </div>

                  <p class="mb-0 fs-2 me-8 me-sm-9">{{ $files->firstItem() }}–{{ $files->lastItem() }}件目 /全 {{ $files->total() }}ファイル</p>
              {{ $files->links('common.pager') }}

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

              <div class="position-relative">
                <hr class="mb-4">
                <a type="button" class="text-bg-primary fs-6 rounded-circle p-2 text-white d-inline-flex position-absolute top-0 end-0 me-4 chat-department" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="部署を追加する"><i class="ph ph-list-plus fs-6"></i></a>
              </div>

              <h5 class="fw-semibold mb-3 position-relative position-relative">
                {{ $location->name }}に所属する部署
              </h5>

              @foreach($location->department as $department)
              <div class="col-md-6">
                <ul class="chat-users mb-0" data-simplebar="init">
                  <li>
                    <a class="px-4 py-3 bg-hover-light-black d-flex align-items-start justify-content-between chat-department" aria-label="{{ $department->id }}" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="名称を編集する">
                      <div class="d-flex align-items-center">
                        <div class="btn btn-warning round rounded-circle d-flex align-items-center justify-content-center">
                          <i class="ph ph-tree-structure fs-6"></i>
                        </div>
                        <div class="ms-3 d-inline-block w-75">
                          <h6 class="mb-1 fw-semibold chat-title" data-username="">
                            {{ $department->name }}
                          </h6>
                          <span class="fs-3 text-truncate text-body-color d-block">登録日：{{ $department->created_at->format('Y年n月j日') }}</span>
                        </div>
                      </div>
                      <p class="fs-2 mb-0 text-muted">所属人数：{{ count(App\Models\Admin::where('department_id',$department->id)->where('status','E')->get()) }}</p>
                    </a>
                  </li>
                </ul>
              </div>
              @endforeach

              <div class="modal fade" id="departmentModal" tabindex="-1" aria-labelledby="departmentModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content border-0">
                    <div class="modal-header bg-info-subtle rounded-top">
                      <h6 class="modal-title d-flex">
                        <i class="ph ph-building-office fs-6 me-3"></i><span class="font-weight-medium fs-3">{{ $location->name }}に所属する部署を編集する</span>
                      </h6>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('location.department') }}" id="departmentModalTitle" method="post">
                      @csrf
                    <div class="modal-body">
                      <div class="notes-box">
                        <div class="notes-content">

                            <div class="row">
                              <div class="col-md-12">
                                <div class="note-title">
                                  <input type="hidden" name="id" value="">
                                  <input type="hidden" name="location_id" value="{{ $location->id }}">
                                  <label class="form-label">オフィス部署名称</label>
                                  <input type="text" id="name" class="form-control" name="name" placeholder="「〇〇部」まで全て入力して下さい" value="{{ old('name') }}">
                                </div>
                              </div>
                            </div>

                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <div class="d-flex gap-6">
                        <button class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal" type="button">キャンセル</button>
                        <button type="submit" id="btn-office-add" class="btn btn-primary">登録する</button>
                      </div>
                    </div>
                    </form>
                  </div>
                </div>
              </div>

              <hr class="mb-4 mt-3">
              <h5 class="fw-semibold mb-3">{{ $location->name }}に所属するメンバー</h5>

              @foreach($location->admin as $admin)
              @if($admin->status == 'E')
              <div class="col-md-6">
                <ul class="chat-users mb-0" data-simplebar="init">
                  <li>
                    <a href="/user/detail/{{ $admin->id }}" class="px-4 py-3 bg-hover-light-black d-flex align-items-start justify-content-between chat-user" id="chat_user_{{ $admin->id }}" data-user-id="{{ $admin->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="メンバー詳細へ">
                      <div class="d-flex align-items-center">
                        <span class="position-relative">
                          <img src="{{ getUserImage($admin->user_id) }}" class="rounded-circle me-n2 card-hover border border-2 border-white object-fit-cover" alt="user1" width="48" height="48" class="rounded-circle">
                          <span class="position-absolute bottom-0 end-0 p-1 badge rounded-pill bg-success">
                            <span class="visually-hidden">New alerts</span>
                          </span>
                        </span>
                        <div class="ms-3 d-inline-block w-75">
                          <h6 class="mb-1 fw-semibold chat-title" data-username="{{ getNamefromUserId($admin->user_id) }}">
                            {{ getNamefromUserId($admin->user_id) }}
                          </h6>
                          <span class="fs-3 text-truncate text-body-color d-flex align-items-center"><i class="ph ph-cake fs-5 me-2"></i>{!! $users->find($admin->user_id)->birthday ? $users->find($admin->user_id)->birthday->format('n月j日') : $yet !!}</span>
                        </div>
                      </div>
                      <p class="fs-2 mb-0 text-muted">{{ $admin->employment_id ? App\Models\Employment::find($admin->employment_id)->name : $yet }}</p>
                    </a>
                  </li>
                </ul>
              </div>
              @endif
              @endforeach

            </div>
          </div>
        </div>
      </div>
    </div>
    
	</div>
</div>

<div class="modal fade" id="addfilemodal" tabindex="-1" aria-labelledby="addfilemodalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0">
      <div class="modal-header bg-info-subtle rounded-top">
        <h6 class="modal-title text-dark d-flex fw-semibold"><i class="ph ph-folder-simple-user fs-6 me-2"></i><span class="font-weight-medium fs-3">ファイルを追加する</span></h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-break">
        <div class="row">
        </div>
      </div>
      <div class="modal-footer">
        <div class="d-flex gap-6">
          <button class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal" type="button">キャンセル</button>
          <button type="button" id="btn-n-add" class="btn btn-primary d-none" onclick="submitMedia();">追加する</button>
          <button type="button" id="btn-f-add" class="btn btn-primary d-none" onclick="submitFile();">追加する</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="prevfilemodal" tabindex="-1" aria-labelledby="prevfilemodalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content border-0">
      <div class="modal-header bg-info-subtle rounded-top">
        <h6 class="modal-title text-dark d-flex fw-semibold"><i class="ph ph-folder-simple-user fs-6 me-2"></i><span class="font-weight-medium fs-3">ファイルをプレビュー</span></h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-break pb-0">
      </div>
      <div class="modal-footer">
        <div class="d-flex gap-6">
          <button class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal" type="button">キャンセル</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@include('common.footer')