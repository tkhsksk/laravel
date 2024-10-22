<div class="tab-pane container-fluid fade @if($name == Cookie::get('tab'))active show @endif" id="pills-{{$name}}" role="tabpanel" aria-labelledby="pills-{{$name}}-tab" tabindex="0">
  <div class="d-sm-flex align-items-center justify-content-between mt-3 mb-4">
    <h3 class="mb-3 mb-sm-0 fw-semibold d-flex align-items-center">あなたのシフト履歴 <span class="badge text-bg-secondary fs-2 rounded-4 py-1 px-2 ms-2">{{ $shifts->count() }}</span></h3>
    <!--<form class="position-relative">
      <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh" placeholder="Search Followers">
      <i class="ph ph-magnifying-glass position-absolute top-50 start-0 translate-middle-y text-dark ms-3"></i>
    </form>-->
  </div>
  <div class="row">
    @foreach($shifts as $shift)
    <div class=" col-md-6 col-xl-4">
      <div class="card">
        <div class="card-body p-4 d-flex align-items-center gap-6 flex-wrap">
          <div>
            <h5 class="fw-semibold mb-0">{{ $shift->preferred_date->isoFormat('Y年M月D日 (ddd)') }}</h5>
            <span class="fs-2 d-flex align-items-center"><i class="ph ph-clock text-dark fs-3 me-1"></i>{{ getShiftTime($shift->id) }}</span>
          </div>
          <a class="btn btn-outline-primary py-1 px-2 ms-auto" href="/shift/detail/{{ $shift->id }}">詳細</a>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>