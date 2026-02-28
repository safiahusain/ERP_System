<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Star Admin Premium Bootstrap Admin Dashboard Template</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('css/toastr.css') }}">
    <link rel="stylesheet" href={{ asset('vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}>
    <link rel="stylesheet" href={{ asset('vendors/iconfonts/ionicons/dist/css/ionicons.css') }}>
    <link rel="stylesheet" href={{ asset('vendors/iconfonts/flag-icon-css/css/flag-icon.min.css') }}>
    <link rel="stylesheet" href={{ asset('vendors/css/vendor.bundle.base.css') }}>
    <link rel="stylesheet" href={{ asset('vendors/css/vendor.bundle.addons.css') }}>
    <link rel="stylesheet" href={{ asset('css/shared/style.css') }}>
    <link rel="stylesheet" href={{ asset('images/favicon.ico') }}>
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
                <div class="row w-100">
                    <div class="col-lg-4 mx-auto">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        <script src={{ asset('vendors/js/vendor.bundle.base.js') }}></script>
        <script src={{ asset('vendors/js/vendor.bundle.addons.js') }}></script>
        <script src={{ asset('js/shared/off-canvas.js') }}></script>
        <script src={{ asset('js/shared/misc.js') }}></script>
        {{-- <script src={{ asset('js/shared/jquery.cookie.js') }} type="text/javascript"></script> --}}
</body>

</html>
