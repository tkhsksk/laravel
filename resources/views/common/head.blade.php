@section('common.head')
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title')｜Lara WORKS</title>
<meta name="description" content="@yield('description')">
<meta name="keywords" content="@yield('keywords')"/>

<link rel="stylesheet" type="text/css" href="@asset('/css/styles.css')">
<link rel="stylesheet" type="text/css" href="@asset('/css/colorbox.css')">
<link rel="stylesheet" type="text/css" href="@asset('/css/base.css')">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.1/css/all.css">

<script src="@asset('/js/bootstrap.bundle.min.js')"></script>
<script src="@asset('/js/jquery-3.7.1.min.js')"></script>
<script src="@asset('/js/popper.min.js')"></script>
<script src="@asset('/js/jquery.colorbox-min.js')"></script>
<script src="https://unpkg.com/@phosphor-icons/web"></script>
<script src="@asset('/js/tinymce/tinymce.min.js')"></script>
<script src="@asset('/js/simplebar.min.js')"></script>
<script src="@asset('/js/theme/app.horizontal.init.js')"></script>
<script src="@asset('/js/theme/app.min.js')"></script>
<script src="@asset('/js/theme/sidebarmenu.js')"></script>
<script src="@asset('/js/theme/theme.js')"></script>
<script src="@asset('/js/base.js')"></script>
@endsection