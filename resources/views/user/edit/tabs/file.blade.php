<div class="tab-pane fade @if($tab == Cookie::get('tab'))active show @endif" id="pills-{{$name}}" role="tabpanel" aria-labelledby="pills-{{$name}}-tab" tabindex="2">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex flex-wrap justify-content-between">
            <div>
              <h4 class="fw-semibold mb-4 d-flex align-items-center"><i class="{{ App\Models\Admin::ADMIN_MENU_TABS[$name][1] }} me-3 fs-6"></i>ユーザーに関する{{ App\Models\Admin::ADMIN_MENU_TABS[$name][0] }}</h4>
            </div>
          </div>

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
                    var img = '<img src="/protected/admin/'+data.admin_id+'/'+data.name+'" class="modernize-img object-fit-contain mx-auto d-block mb-3">';
                  } else if(data.extension == 'pdf'||data.extension == 'ai') {
                    var img = '<iframe src="/protected/admin/'+data.admin_id+'/'+data.name+'" height="390" frameborder="0" class="border-0 w-100"></iframe>';
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
                    <form action="{{ route('user.media') }}" method="post" enctype="multipart/form-data">
                      @csrf
                      <input type="hidden" value="{{ $name }}" name="tab">
                      <input type="hidden" value="{{ $admin->id }}" name="admin_id">
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
                    <form action="{{ route('user.file') }}" method="post" enctype="multipart/form-data">
                      @csrf
                      <input type="hidden" value="{{ $name }}" name="tab">
                      <input type="hidden" value="{{ $admin->id }}" name="admin_id">
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
                          {{ $file->origin_name }}
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