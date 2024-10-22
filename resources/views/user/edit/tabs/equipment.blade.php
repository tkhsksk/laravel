<script src="@asset('/js/dualbox/jquery.bootstrap-duallistbox.js')"></script>

<div class="tab-pane fade @if($tab == Cookie::get('tab'))active show @endif" id="pills-{{$name}}" role="tabpanel" aria-labelledby="pills-{{$name}}-tab" tabindex="0">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title fw-semibold">使用機材</h5>
          <p class="card-subtitle mb-4">ユーザーが使用する機材を左のボックスから選択して下さい<br />選択後、左下の「登録する」をクリックして下さい</p>
          <div class="">
          <form id="equipments_form" action="#" method="post">
            @csrf
            <select multiple="multiple" size="" name="equipments[]">
              @foreach($able_equipments as $equipment)
              <option value="{{ $equipment->id }}" @if($equipment->admin_id == $user->id) selected @endif>{{ App\Models\Equipment::EQUIPMENT_CATEGORIES[$equipment->category][1] }}　{{ $equipment->portia_number }}（{{ App\Models\Equipment::EQUIPMENT_CATEGORIES[$equipment->category][0] }}）</option>
              @endforeach
            </select>
            <button type="submit" class="btn btn-primary mt-3"><i class="fa-solid fa-check fs-5 me-2"></i>保存する</button>
          </form>
          <script>
            var demo1 = $('select[name="equipments[]"]')
            .bootstrapDualListbox({
              filterTextClear:'<i class="ph ph-x fs-2"></i>',
              filterPlaceHolder:'機材の検索',
              moveSelectedLabel:'選択済みに移動',
              moveAllLabel:'選択済みに全て移動',
              removeSelectedLabel:'選択を解除',
              removeAllLabel:'選択を全て解除',
              nonSelectedListLabel: 'すべての利用可能機材',
              selectedListLabel: 'ユーザーの使用中機材',
              infoText:'（{0}件）',
              infoTextEmpty:'（0件）',
              infoTextFiltered:'（該当：{0}件 / 全{1}件）',
            });

            $("#equipments_form").submit(function() {
              // alert($('[name="equipments[]"]').val());
              $.ajax({
                  url: '{{ route('user.equipment') }}',
                  type: 'get',
                  data: {
                    equipment : $('[name="equipments[]"]').val(),
                    user      : {{ $user->id }},
                  },
                  datatype: 'json',
              })
              .done((data) => {
                  // console.log(data);
                  $('#addequipmentmodal .notes-content').empty();
                  $('#addequipmentmodal .alert').addClass('d-none');
                  if(data.length){
                    $('#addequipmentmodal .notes-content').append(
                      '<p><span class="fs-6 me-1 fw-semibold">'+data.length+
                      '</span>つの機材が登録されています</p>'
                      );
                    $.each(data, function(key, value) {
                      $('#addequipmentmodal .notes-content').append(
                        '<p class="mb-0 d-flex align-items-center justify-content-center"><i class="ph ph-desktop me-2 fs-6"><a href="'
                        + '{{ route('equipment.edit') }}/'
                        + value.id
                        + '"></i>'
                        + value.portia_number
                        + '（型番：'+value.number
                        + '）</a></p>'
                        );
                    });
                  } else {
                    $('#addequipmentmodal .alert').removeClass('d-none');
                  }
                  $('#addequipmentmodal').modal('show');
              })
              .fail((data) => {
                  console.log('失敗');
              });
              return false;
            });
          </script>

          </div> 
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addequipmentmodal" tabindex="-1" aria-labelledby="addequipmentmodalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0">

      <div class="modal-header bg-info-subtle rounded-top">
        <h6 class="modal-title d-flex"><i class="ph ph-desktop fs-6 me-2"></i><span class="font-weight-medium fs-3">ユーザーの使用機材を更新しました</span></h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body text-center fs-4">
        <div class="alert customize-alert alert-dismissible alert-light-danger bg-danger-subtle text-danger fade remove-close-icon mb-0 show d-none" role="alert">
          <div class="d-flex align-items-center me-3 me-md-0">
            <i class="ph ph-smiley-sad fs-5 me-2 text-danger"></i>ユーザー全ての機材を削除しました
          </div>
        </div>
        <div class="notes-box">
          <div class="notes-content">
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <div class="d-flex gap-6">
          <button class="btn btn-primary" data-bs-dismiss="modal" type="button">閉じる</button>
        </div>
      </div>

    </div>
  </div>
</div>