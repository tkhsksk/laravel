<div class="tab-pane fade @if($tab == Cookie::get('tab'))active show @endif" id="pills-{{$name}}" role="tabpanel" aria-labelledby="pills-{{$name}}-tab" tabindex="0">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex flex-wrap justify-content-between">
            <div>
              <h4 class="fw-semibold mb-4 d-flex align-items-center"><i class="{{ App\Models\Admin::ADMIN_MENU_TABS[$name][1] }} me-3 fs-6"></i>{{ App\Models\Admin::ADMIN_MENU_TABS[$name][0] }}に関するデータ</h4>
            </div>
            <div>
            </div>
          </div>
          
          <div class="row">
          @if($equipments->count() > 0)
          @foreach($equipments as $equipment)
          <div class="col-sm-6 col-xl-4">
            <div class="card hover-img overflow-hidden rounded-2 border" id="equipment-{{$equipment->id}}">
              <div class="position-relative">
                <a href="/equipment/detail/{{ $equipment->id }}" class=" ratio ratio-1x1">
                  <img src="@asset('/image/equipment/{{$equipment->category}}.jpg')" class="card-img-top rounded-0 h-100 object-fit-cover" style="max-height: 250px" alt="{{ $equipment->category }}">
                </a>
                <a href="/equipment/edit/{{ $equipment->id }}" class="text-bg-primary rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="編集する"><i class="ph ph-pencil-line fs-4"></i></a>
              </div>
              <div class="card-body pt-3 p-4">
                <h6 class="fw-semibold fs-4 mb-1">portia管理番号</h6>
                <p class="text-muted">{{ $equipment->portia_number }}</p>
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                  <h6 class="fw-semibold fs-4 mb-2"><i class="ph ph-currency-jpy text-dark me-1"></i>{!! $equipment->price ? number_format($equipment->price).' 円' : $yet !!}</h6>
                  <div class="list-unstyled d-flex align-items-center mb-0">
                    <p class="mb-1 badge bg-warning-subtle text-warning fs-2">{{ App\Models\Equipment::EQUIPMENT_CATEGORIES[$equipment->category][0] }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endforeach
          @else
          <div class="alert customize-alert alert-dismissible alert-light-danger bg-danger-subtle text-danger fade show remove-close-icon" role="alert">
            <div class="d-flex align-items-center  me-3 me-md-0">
              <i class="ph ph-smiley-sad fs-5 me-2 text-danger"></i>
              現在、ユーザーが利用中の機材はありません
            </div>
          </div>
          @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

