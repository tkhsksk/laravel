@if(session('flash.failed') or $errors->any())
<div class="alert customize-alert alert-dismissible alert-light-danger bg-danger-subtle text-danger fade show remove-close-icon" role="alert">
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    {!! session('flash.failed') !!}
    @foreach ($errors->all() as $error)
    <div class="d-flex align-items-center me-3 me-md-0 fs-3"><i class="ph ph-smiley-sad fs-5 me-2 text-danger"></i>{{ $error }}</div>
    @endforeach
</div>
@endif

@if(session('flash.success'))
<div class="alert customize-alert alert-dismissible text-success text-success alert-light-success bg-success-subtle fade show remove-close-icon" role="alert">
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  <div class="d-flex align-items-center  me-3 me-md-0">
    <i class="fa-solid fa-check fs-3 me-2 text-success"></i>{{ session('flash.success') }}
  </div>
</div>
@endif