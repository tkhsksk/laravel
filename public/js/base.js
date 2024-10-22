$(function() {
    window.onpageshow = function(event) {
        if (event.persisted) {
        $('button').removeClass('disabled').find('.spinner-border').remove();
        $('button').find('i').show();
        $('a').removeClass('disabled').find('.spinner-border').remove().find('i').show();
        $('a').find('i').show();
    }
    }
});

function inputToday(el) {
    $(el).prev('input').val($(el).attr('aria-label'));
};

function delInput(el) {
    $(el).parent().find('input').val('').focus();
};

function search(el) {
    $(el).closest('form').submit();
};

function sidebar(){
    $('#main-wrapper').toggleClass('show-sidebar');
};

$(function tooltip(){
    $('[data-bs-toggle="tooltip"]').tooltip();
});

function getSizeStr(e){
    var t = ["Bytes", "KB", "MB", "GB", "TB"]
    if (0 === e) return "n/a"
    var n = parseInt(Math.floor(Math.log(e) / Math.log(1024)))
    return Math.round(e / Math.pow(1024, n)) + " " + t[n]
}

function copyText(el) {
    const text = $(el).data('text');
    navigator.clipboard.writeText(text);
    $('.tooltip-inner').html('コピー完了');
};

function submitButton(el) {
    $(el).addClass('disabled').prepend('<span class="spinner-border spinner-border-sm me-2"><span class="visually-hidden">Loading...</span></span>');
    $(el).find('i').hide();
    var form = $(el).closest('form');
    form.submit();
};

function getRandValue(dig){
    const chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
    let randomStr = '';
    for(let i = 0; i < dig; i++) {
      while(true) {
        // ランダムな英数字を一文字生成
        const random = chars.charAt(Math.floor(Math.random() * chars.length));

        // randomStrに生成されたランダムな英数字が含まれるかチェック
        if(!randomStr.includes(random)) {
          // 含まれないなら、randomStrにそれを追加してループを抜ける
          randomStr += random;
          break;
        }
      }
    }
    return randomStr;
};

function inputShiftTime(el) {
    var array = [
        'preferred_hr_st',
        'preferred_min_st',
        'preferred_hr_end',
        'preferred_min_end'
    ];

    $.each(array, function(index, value) {
        $('select[name='+value+']').val($(el).data(value)).addClass('bg-warning-subtle text-danger');
    })
    if($(el).hasClass('reset')){
        $.each(array, function(index, value) {
            $('select[name='+value+']').removeClass('bg-warning-subtle text-danger');
        })
    }
};

function imageZoom() {
    $(".notification-body img").css('cursor','zoom-in');
    $(".notification-body img").click(function() {
        $.colorbox({
            href:this.src,
            opacity: 0.85,
            transition:'none',
            maxWidth:'90%',
            maxHeight:'90%'
        });
        return false;
    });
}

function faqAccess() {
    $(document).on("click", "#answerModal a", function () {
        const orig = $(this).closest('.modal-body').data('faq');
        if ($(this).attr('href').indexOf('#faq=') >= 0) {
            const url = $(this).attr('href');
            const nextSharpNum = url.indexOf("=") + 1;
            const id = url.substring(nextSharpNum);
            $('#answerModal .modal-content').empty();
            getFaq(id, '#answerModal .modal-content', orig);

            return false;
        }
    });
}

$(document).ready(function() {
    imageZoom();
});

$(function() {
    $('#answerModal').on('shown.bs.modal', function (e) {
        // imageZoom();
        faqAccess();
    })
    $('#answerModal').on('hidden.bs.modal', function (e) {
        $('#answerModal').off('shown.bs.modal');
    })
});

$(function confetti(){
    var confettiPlayers = [];

    function makeItConfetti() {
      var confetti = document.querySelectorAll('.confetti');
      
      if (!confetti[0].animate) {
        return false;
      }

      for (var i = 0, len = confetti.length; i < len; ++i) {
        var candycorn = confetti[i];
        candycorn.innerHTML = '<div class="rotate"><div class="askew"></div></div>';
        var scale = Math.random() * .7 + .3;
        var player = candycorn.animate([
          { transform: `translate3d(${(i/len*100)}vw,-5vh,0) scale(${scale}) rotate(0turn)`, opacity: scale },
          { transform: `translate3d(${(i/len*100 + 10)}vw,105vh,0) scale(${scale}) rotate(${ Math.random() > .5 ? '' : '-'}2turn)`, opacity: 1 }
        ], {
          duration: Math.random() * 6000 + 8000,
          iterations: Infinity,
          delay: -(Math.random() * 7000)
        });
        
        confettiPlayers.push(player);
      }
    }

    makeItConfetti();
    onChange({currentTarget: {value: 'bookmarks'}})

    document.getElementById('type').addEventListener('change', onChange)

    function onChange(e) {
      document.body.setAttribute('data-type', e.currentTarget.value);
      confettiPlayers.forEach(player => player.playbackRate = e.currentTarget.value === 'bookmarks' ? 2 : 1);
    }
});


function tinyMce(id){
    // TinyMCE version 6.6.2 
    switch (id) {
    case 'notification':
    case 'profile':
        var height = 550;
        break;
    case 'manual':
        var height = 700;
        break;
    case 'order':
    case 'faq':
        var height = 550;
        break;
    default:
        var height = 400;
        break;
    }

    tinymce.init({
        selector:  'textarea.tinymce',
        //editorのelementを取得
        init_instance_callback : function(editor) {
          console.log("Editor: " + editor.id + " is now initialized.");
        },
        language:'ja',
        setup: (editor) => {
            editor.ui.registry.addButton('codeblock', {
              icon: 'ai',
              onAction: () => {
                var selected = tinymce.activeEditor.selection.getContent();
                var node     = tinymce.activeEditor.selection.getNode();
                var hasClass = $(node).hasClass('codeblock');
                if(hasClass){
                    $(node)
                    .removeClass('codeblock')
                    .removeAttr('style');
                } else {
                    var content = '<p class="codeblock" style="background:#1d2020;color:#e3e3e3;border-radius:8px;padding:8px 16px;font-family:SFMono-Regular, Menlo, Monaco, Consolas, monospace;white-space:nowrap;overflow-x:auto;font-size:0.962em;">' + (selected != '' ? selected : '') + '</p>';
                    editor.insertContent(content);
                }
              }
            });
            editor.on('keydown', function (e) {
                if (e.metaKey&&e.keyCode === 13) {
                    tinymce.execCommand('mceInsertContent', 0, '<p></p>');
                }
            });
        },
        statusbar: false,
        menubar:   false,
        height:    height,
        link_default_target: '_blank',
        relative_urls: false,//これと
        remove_script_host: false,//これがないと画像のパスが登録時におかしくなる
        newline_behavior:'invert',
        plugins:   'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount code',
        toolbar:   'blocks bold align underline forecolor backcolor | emoticons link image table hr | numlist bullist | code codeblock',
        block_formats: 'Paragraph=p; Header 1=h3; Header 2=h4; Header 3=h5',
        toolbar_location: 'bottom',
        upload_tab_first:true,

        // ここから下がイメージの貼り付けをするための処理
        image_title: true,
        automatic_uploads: true,
        images_upload_url: '/upload/'+id, // 画像が貼り付けられるとアクセス PostController 'upload'
        file_picker_types: 'image',
        // images_reuse_filename: true,
        paste_data_images: false,// pasteだとファイル名が変更されない
        file_picker_callback: function(cb, value, meta) {
            $('.tox-dialog .alert').remove();
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function() {
                var file = this.files[0];
                var reader = new FileReader();

                reader.readAsDataURL(file);
                reader.onload = function () {
                    var id        = (new Date()).getTime() + getRandValue(10);
                    var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                    var base64    = reader.result.split(',')[1];
                    var blobInfo  = blobCache.create(id, file, base64);

                    var limit     = 512000;
                    console.log(getSizeStr(blobInfo.blob().size));
                    if(blobInfo.blob().size > limit){
                        $('<div class="d-flex align-items-center bg-danger-subtle text-danger alert p-2 h6" role="alert">'
                         +'<i class="ph ph-warning-circle fs-5 me-2 text-danger"></i>'
                         +'最大ファイルサイズは'+getSizeStr(limit)+'です</div>').insertBefore('.tox-form');
                        return;
                    }

                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                };
            };
            input.click();
        }
    });
};
