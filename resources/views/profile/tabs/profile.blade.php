<script>
  tinyMce('profile');

  function editNote(el) {
    //$(el).toggleClass('d-none').toggleClass('d-block');
    $('#addnotemodal').modal('show');
    $('input[name=id]').val('');
    $('input[name=title]').val('');
    // https://github.com/tinymce/tinymce/issues/7383　thx a lot!!!!
    // 
    document.addEventListener('focusin', (e) => {
      if (e.target.closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
        e.stopImmediatePropagation();
      }
    });
    tinymce.activeEditor.setContent('');
    if(el){
      $.ajax({
        url: '{{ route('note.get') }}',
        type: 'get',
        data: {val : el},
        datatype: 'json',
      })
      .done((data) => {
        $('input[name=id]').val(data.id);
        $('input[name=title]').val(data.title);
        @if(old('id'))
        if({{ old('id') }} == data.id){
          tinymce.activeEditor.setContent('{!! old('note') !!}');
        } else {
          tinymce.activeEditor.setContent(data.note);
        }
        @else
          tinymce.activeEditor.setContent(data.note);
        @endif
      })
      .fail((data) => {
        alert('取得できるメモはあなたが登録したメモだけです');
      });
    }
  };

</script>
<div class="tab-pane fade @if($name == Cookie::get('tab'))active show @endif" id="pills-{{$name}}" role="tabpanel" aria-labelledby="pills-{{$name}}-tab" tabindex="0">

      <div class="d-flex justify-content-between mb-2">
        <button class="btn bg-warning-subtle text-warning d-flex align-items-center gap-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
          <i class="ph ph-funnel fw-semibold"></i><span class="d-none d-md-block ">メモの検索</span>
        </button>

        <a href="javascript:void(0)" class="btn bg-secondary-subtle text-secondary d-flex align-items-center gap-2" onclick="editNote();">
          <i class="ph ph-sticker fs-5"></i>
          <span class="d-none d-md-block font-weight-medium fs-3">メモを残す</span>
        </a>
      </div>

      <div class="d-flex justify-content-between mb-3 align-items-end flex-wrap">
        <p class="mb-n2 text-dark">@if($notes->total() > 0)<span class="px-1 fs-5 fw-bolder">{{ $notes->firstItem() }}</span> 〜 <span class="px-1 fs-5 fw-bolder">{{ $notes->lastItem() }}</span>件を表示しています @endif</p>
        <h2 class="fw-bolder mb-0 fs-8 lh-base"><span class="fs-3 fw-normal me-md-3 me-2">現在</span>{{ $notes->total() }}<span class="fs-3 fw-normal ms-md-3 ms-2">件のメモ<span class="d-md-inline d-none">が登録されています</span></span></h2>
      </div>

      <div class="grid-container d-grid">
        @foreach($notes as $note)
        <div class="card position-relative mb-0 hover-img" onclick="editNote('{{ $note->id }}');" role="button">
          <div class="card-body border-bottom overflow-hidden">
              @if($note->title)
              <h6 class="fw-semibold fs-5 pb-1">{{ $note->title }}</h6>
              @endif

            <div class="notification-body note{{ $note->id }}">
              {!! $note->note !!}
            </div>

          </div>
        </div>
        @endforeach
      </div>

      {{ $notes->appends(request()->query())->links('common.pager') }}
</div>

<div class="modal fade" id="addnotemodal" tabindex="-1" aria-labelledby="addnotemodalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content border-0">
      <div class="modal-header bg-info-subtle rounded-top">
        <h6 class="modal-title text-dark d-flex fw-semibold align-items-center gap-2"><i class="ph ph-sticker fs-6"></i><span class="font-weight-medium fs-4">あなた専用のメモを残す</span></h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('note.store') }}" novalidate="novalidate" method="post">
        @csrf
        <input name="id" value="" type="hidden">
        <input name="register_id" value="{{ $user->id }}" type="hidden">

        <div class="modal-body">
          <div class="mb-3 d-flex gap-6 flex-wrap justify-content-between align-items-center">
            <div>
              <p class="card-subtitle">・本文に埋め込める画像ファイルの最大サイズは <code>500KB</code> です</p>
              <p class="card-subtitle">・本文の最大文字数はコードを含めて <code>5000文字</code> です</p>
            </div>
            <button type="submit" class="btn btn-primary ms-auto d-flex align-items-center gap-2"><i class="ph ph-sticker fs-5"></i><span>メモを残す</span></button>
          </div>
          <div class="border-bottom mb-3">
            <input type="text" name="title" class="form-control form-control-lg fs-5 fw-bolder border-0" placeholder="メモのタイトルを追加" value="">
          </div>
          <textarea class="form-control bg-white tinymce" name="note"></textarea>
        </div>

        <div class="modal-footer">
          <div class="d-flex gap-6">
            <button class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal" type="button">キャンセル</button>
            <button type="submit" class="btn btn-primary d-flex align-items-center gap-2"><i class="ph ph-sticker fs-5"></i><span>メモを残す</span></button>
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

              <h6 class="fw-semibold fs-3 mb-2">メモ</h6>
              <input type="text" name="note" class="form-control form-control-lg fs-3" placeholder="メモの内容で検索" value="{{ $keyword }}">

              <h6 class="mt-4 fw-semibold fs-3 mb-2">登録日</h6>

              <div class="input-group mb-1">
                <input type="date" id="created_at_st" name="created_at_st" class="form-control form-control-lg" value="@isset($request->created_at_st){{ $request->created_at_st }}@endisset">
                <button class="btn bg-primary-subtle text-primary" type="button" aria-label="{{ now()->format('Y-m-d') }}" onclick="inputToday(this);">
                  本日
                </button>
                <button class="btn bg-warning-subtle text-warning rounded-end" type="button" aria-label="" onclick="delInput(this);">
                  削除
                </button>
              </div>

              <p class="text-center fs-4 mb-1">から</p>

              <div class="input-group mb-1">
                <input type="date" id="created_at_en" name="created_at_en" class="form-control form-control-lg" value="@isset($request->created_at_en){{ $request->created_at_en }}@endisset">
                <button class="btn bg-primary-subtle text-primary" type="button" aria-label="{{ now()->format('Y-m-d') }}" onclick="inputToday(this);">
                  本日
                </button>
                <button class="btn bg-warning-subtle text-warning rounded-end" type="button" aria-label="" onclick="delInput(this);">
                  削除
                </button>
              </div>
              <p class="text-center fs-4">まで</p>
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