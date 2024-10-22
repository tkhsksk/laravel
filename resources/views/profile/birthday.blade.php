<div class="confetti-land">
  @for ($i = 0; $i < 80; $i++)
    <div class="confetti"></div>
  @endfor
</div>

@php $hat = @asset('/image/party-hat.png'); @endphp
<style>
  .prof-image::after{
    content: url({{ $hat }});
    position: absolute;
    width: 50px;
    height: 30px;
    top: -36px;
    right: -12px;
    transform: rotate(31deg);
  }
</style>