@section('common.footer')
<div class="offcanvas offcanvas-end shopping-cart" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header py-4 flex-wrap">
        <h5 class="offcanvas-title fs-5 fw-semibold" id="offcanvasRightLabel">
            <i class="ph ph-basket me-2 fs-5"></i>あなたの購入リクエスト
        </h5>
        <p class="mb-0 text-danger"><i class="ph ph-asterisk me-2"></i>新規のみ、最新5件まで</p>
    </div>
    <div class="offcanvas-body h-100 px-4 pt-0" data-simplebar="init">
        <div class="simplebar-wrapper overflow-y-scroll" style="margin: 0px -24px -16px;">
            <div class="simplebar-height-auto-observer-wrapper">
                <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask position-relative">
                <div class="simplebar-offset position-relative" style="right: 0px; bottom: 0px;">
                    <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden;">
                        <div class="simplebar-content" style="padding: 0px 24px 16px;">
                            <ul class="mb-0">
                                @foreach(getUserOrders(5) as $order)
                                <li class="pb-7">
                                    <div class="d-flex align-items-center">
                                        @if(getFirstImage($order->note))
                                        <img src="@asset({{getFirstImage($order->note)}})" width="63" height="61" class="rounded-1 me-9 flex-shrink-0 object-fit-cover" alt="">
                                        @else
                                        <img src="@asset('/thumb/no-bg.svg')" width="63" height="61" class="rounded-1 me-9 flex-shrink-0 object-fit-cover" alt="">
                                        @endif
                                        <div>
                                            <h6 class="mb-1">{{ $order->product_name }}</h6>
                                            <p class="mb-0 text-muted fs-2">{{ $order->created_at->isoFormat('Y/M/D(ddd)') }}</p>
                                            <span class="badge fw-semibold py-1 fs-2 bg-{{ App\Models\order::STATUS[$order->status][1] }}-subtle text-{{ App\Models\order::STATUS[$order->status][1] }}">{{ App\Models\order::STATUS[$order->status][0] }}</span>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            <div class="align-bottom">
                                <a href="/order" class="btn btn-outline-primary w-100">購入リストへ</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
            <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
        </div>
        <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
            <div class="simplebar-scrollbar" style="height: 0px; display: none;"></div>
        </div>
    </div>
</div>

<script>
    $(function(){
        const result = $('#searchFaqModal ul.list');
        $("#faqSearch").keyup(function (e) {
            const key = $(this).val();
            result.empty()

            if(e.keyCode === 13) {
                result.empty()
                $.ajax({
                    url: '{{ route('faq.search') }}',
                    type: 'get',
                    data: {word : key},
                    datatype: 'json',
                })
                .done((data) => {
                    result.empty()
                    $('#searchFaqModal .count').text(data.length);
                    $.each(data, function(index, value) {
                        result
                        .append(
                            '<li class="mb-1 bg-hover-light-black">'
                           +'<a href="javascript:void(0)" class="p-2 getAnswer d-flex" data-bs-toggle="modal" data-bs-target="#answerModal" data-bs-dismiss="modal" data-faq-id="'+value.id+'">'
                           +'<div class="ratio ratio-1x1 position-relative me-2" style="width:21px;">'
                           +'<span class="notification bg-tinymce rounded-circle w-100 h-100 position-absolute top-0 lh-1 d-flex justify-content-center align-items-center text-white small">Q</span>'
                           +'</div>'
                           +'<span class="d-block">'+value.question+'</span>'
                           +'</div>'
                           +'</li>');
                    });
                })
                .fail((data) => {
                    console.log('失敗');
                });
            }
        });

        const an = $('#answerModal .modal-content');
        $(document).on('click','.getAnswer',function() {
            const id = $(this).data('faq-id');
            getFaq(id, an);
        });

        $('#searchFaqModal').on('hidden.bs.modal', function (e) {
            // $('#searchFaqModal .count').text('0');
            // result.empty();
        });

        $('#answerModal').on('hidden.bs.modal', function (e) {
            an.empty();
        });
    });

    function getFaq(target_id, e, orig_id) {
        if(orig_id){
            var orig_btn = '<a class="btn bg-danger-subtle text-danger" type="button" href="/#faq='+orig_id+'">Q'+orig_id+'に戻る</a>';
        } else {
            var orig_btn = '';
        }
        $.ajax({
            url: '{{ route('faq.search') }}',
            type: 'get',
            data: {id : target_id},
            datatype: 'json',
        })
        .done((data) => {
            $(e).append(
                '<div class="bg-tinymce modal-header border-bottom justify-content-between flex-wrap gap-2"><div class="d-flex"><div class="ratio ratio-1x1 position-relative me-2" style="width:31px;"><span class="notification rounded-circle w-100 h-100 position-absolute top-0 lh-1 d-flex justify-content-center align-items-center bg-white text-tinymce h5">Q</span></div><h5 class="mb-0 text-white mt-1">'+data.question+'</h5></div><div class="d-flex"><a class="btn btn-light d-flex align-items-center px-3 text-primary me-2" data-text="'+data.id+'" onclick="copyText(this);"><i class="ph ph-clipboard-text me-2"></i>idのコピー</a><a class="btn btn-light d-flex align-items-center px-3 text-primary" data-text="{{ route('faq.index') }}?pw-faq='+data.id+'" onclick="copyText(this);"><i class="ph ph-clipboard-text me-2"></i>URLのコピー</a></div></div>'
               +'<div class="modal-body notification-body border-bottom fs-4" data-faq="'+data.id+'">'+data.answer+'</div>'
               +'<div class="modal-footer gap-1">'+orig_btn+'<a class="btn btn-primary d-flex align-items-center px-3" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#searchFaqModal"><i class="ph ph-list-magnifying-glass me-2"></i>FAQのクイック検索に戻る</a><button class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal" type="button">閉じる</button><a class="btn btn-rounded bg-secondary-subtle text-secondary" href="/faq/edit/'+data.id+'"><i class="ph ph-pencil-simple-line me-2"></i>編集する</a></div>');
            imageZoom();
        })
        .fail((data) => {
            console.log('取得できませんでした');
        });
    }
</script>

<div class="modal fade" id="searchFaqModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content rounded-1">
            <div class="modal-header border-bottom">
                <input type="search" class="form-control fs-3" placeholder="FAQのタイトルで検索" id="faqSearch">
            </div>
            <div class="modal-body message-body" data-simplebar="init">
                <div class="simplebar-wrapper overflow-y-scroll" style="margin: -16px;">
                    <div class="simplebar-height-auto-observer-wrapper">
                        <div class="simplebar-height-auto-observer"></div>
                    </div>
                    <div class="simplebar-mask position-relative">
                        <div class="simplebar-offset position-relative" style="right: 0px; bottom: 0px;">
                            <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden;">
                                <div class="simplebar-content" style="padding: 16px;">
                                    <h5 class="fs-4 p-1 d-flex align-items-center fw-semibold"><i class="ph ph-list-magnifying-glass me-3 fs-6"></i>FAQのクイック検索<span class="badge text-bg-warning fs-2 rounded-4 py-1 px-2 ms-3"><i class="ph ph-magnifying-glass me-1"></i><span class="fw-bold fs-3 ms-1 me-2 count">0</span>件がヒットしました</span></h5>
                                    <ul class="list mb-0">
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                    <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                </div>
                <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                    <div class="simplebar-scrollbar" style="height: 0px; display: none; transform: translate3d(0px, 0px, 0px);"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="answerModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered">
        <div class="modal-content rounded-1">
        </div>
    </div>
</div>

<footer class="text-center py-3">
    <i class="fa-brands fa-laravel me-1"></i>Laravel v{{ Illuminate\Foundation\Application::VERSION }} on PHP v{{ PHP_VERSION }}
</footer>
@endsection