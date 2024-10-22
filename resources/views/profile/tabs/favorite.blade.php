<script>
  function favBtn(el) {
      $(el).toggleClass('liked');
      $('#pills-favorite .card').toggleClass('opacity-50');
      favorite = $(el).attr('favorite-id');
      content  = $(el).attr('content-id');
      $.ajax({
          url: '{{ route('manual.favorite') }}',
          type: 'get',
          data: {
            val  : favorite,
            cont : content
          },
          datatype: 'json',
      })
      .done((data) => {
        console.log(data)
        if(data.id){
          $(el).attr('favorite-id',data.id);
        } else {
          $(el).attr('favorite-id','');
        }
      })
      .fail((data) => {
        console.log('fail')
      });
  }
</script>

<div class="tab-pane container-fluid fade @if($name == Cookie::get('tab'))active show @endif" id="pills-{{$name}}" role="tabpanel" aria-labelledby="pills-{{$name}}-tab" tabindex="0">
  <div class="d-sm-flex align-items-center justify-content-between mt-3 mb-4">
    <h3 class="mb-3 mb-sm-0 fw-semibold d-flex align-items-center">お気に入りマニュアル <span class="badge text-bg-secondary fs-2 rounded-4 py-1 px-2 ms-2">{{ $favorites->count() }}</span></h3>
  </div>
  <div class="row">
    @foreach($favorites as $favorite)
    @php
      $manual = App\Models\Manual::find($favorite->contents_id);
    @endphp
    <div class="col-md-6 col-lg-3">
        <div class="card rounded-2 overflow-hidden hover-img">
          <div class="row">
            <div class="position-relative col-md-12 col-6">
              <a href="/manual/detail/{{ $manual->id }}" class="bg-body-secondary d-block h-100">
                @if(getFirstImage($manual->note))
                <img src="@asset({{getFirstImage($manual->note)}})" class="card-img-top rounded-0">
                @else
                <img src="@asset('/thumb/no-bg.jpg')" class="card-img-top rounded-0">
                @endif
              </a>
              <span class="d-md-block d-none badge text-bg-light fs-2 rounded-4 lh-sm mb-9 me-9 py-1 px-2 fw-semibold position-absolute bottom-0 end-0 text-wrap">およそ{{ getReadTime($manual->note) }}で読めます</span>
              <img src="{{ getUserImage($manual->register_id) }}" alt="" class="img-fluid rounded-circle position-absolute bottom-0 start-0 mb-md-n9 mb-1 ms-md-9 ms-3 object-fit-cover" style="width:40px;height: 40px" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="登録者：{{ getNamefromUserId($manual->register_id,'U') }}">
            </div>

            <div class="card-body p-4 ps-md-4 ps-0 col-md-12 col-6">
              <span class="d-md-none d-block badge text-bg-light fs-2 rounded-4 lh-sm mb-3 py-1 px-2 fw-semibold end-0 text-wrap">およそ{{ getReadTime($manual->note) }}で読めます</span>
              <h3 class="d-block mt-md-2 mb-md-3 mb-0 fs-5 text-dark fw-semibold lh-sm"><a href="/manual/detail/{{ $manual->id }}">{{ $manual->id }}｜{{ $manual->title }}</a><a href="/manual/edit/{{ $manual->id }}" class="d-inline-block ms-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="編集する"><i class="ph ph-pencil-line fs-5"></i></a></h3>
              <div class="d-flex align-items-center gap-2 flex-wrap justify-content-md-between justify-content-end">
                <button type="button" class="likeButton fs-2 @if(isFavorite('M', $manual->id))liked @endif" onclick="favBtn(this);" favorite-id="{{ isFavorite('M', $manual->id) }}" content-id="{{ $manual->id }}">
                  <svg class="likeButton__icon" viewBox="0 0 100 100"><path d="M91.6 13A28.7 28.7 0 0 0 51 13l-1 1-1-1A28.7 28.7 0 0 0 8.4 53.8l1 1L50 95.3l40.5-40.6 1-1a28.6 28.6 0 0 0 0-40.6z"/></svg>
                 <span class="d-md-inline d-none">ブックマーク</span>
                </button>
                <div class="d-flex align-items-center fs-2 ms-auto">
                  <i class="ph ph-calendar text-dark me-1"></i>{{ $manual->created_at->isoFormat('YYYY年M月D日(ddd)') }}
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    @endforeach
  </div>
</div>