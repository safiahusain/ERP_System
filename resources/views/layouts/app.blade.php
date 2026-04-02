<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'promanage-erp') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendor/select2.css')}}">
    <!-- plugins:css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href={{ asset('vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}>
    <link rel="stylesheet" href={{ asset('vendors/iconfonts/ionicons/dist/css/ionicons.css') }}>
    <link rel="stylesheet" href={{ asset('vendors/iconfonts/flag-icon-css/css/flag-icon.min.css') }}>
    <link rel="stylesheet" href={{ asset('vendors/css/vendor.bundle.base.css') }}>
    <link rel="stylesheet" href={{ asset('vendors/css/vendor.bundle.addons.css') }}>
    <!-- inject:css -->
    <link rel="stylesheet" href={{ asset('css/shared/style.css') }}>
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href={{ asset('css/demo_1/style.css') }}>
    <!-- End Layout styles -->
    <link rel="shortcut icon" href={{ asset('images/favicon.ico') }} />
    <style>
        body .btn_loader {
            border: 2px solid #0f7484;
            border-radius: 50%;
            border-top: 2px solid #fff;
            border-bottom: 2px solid #fff;
            width: 22px;
            height: 22px;
            -webkit-animation: spin 2s linear infinite !important;
            -moz-animation: spin 2s linear infinite !important;
            animation: spin 2s linear infinite !important;
        }

        .menu-arrow {
            margin-right: 50px !important;
        }

        /* Base Modern Button */
        .btn-modern {
            padding: 12px 28px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            letter-spacing: 0.3px;
        }

        /* Primary Gradient */
        .btn-primary-gradient {
            background: linear-gradient(135deg, #1a73e8, #0d47a1);
            color: #fff;
            box-shadow: 0 4px 12px rgba(26, 115, 232, 0.3);
        }

        .btn-primary-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(26, 115, 232, 0.4);
        }

        /* Success Button */
        .btn-success {
            background: linear-gradient(135deg, #28a745, #1e7e34);
            color: #fff;
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(40, 167, 69, 0.4);
        }

        /* Danger Button */
        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #a71d2a);
            color: #fff;
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(220, 53, 69, 0.4);
        }

        /* Active Click Effect */
        .btn-modern:active {
            transform: scale(0.97);
        }

        .filters-btn {
            width: 18px !important;
            height: 24px !important;
            object-fit: contain;
        }

        .create-btn {
            width: 40px !important;
            height: 30px !important;
            object-fit: contain;
        }
        .modal-content{
            border-radius:18px;
            border:none;
            box-shadow:0 25px 70px rgba(0,0,0,.25);
            overflow:hidden;
        }

        .modal-header{
            background:linear-gradient(135deg,#2563eb,#1e40af);
            color:#fff;
            padding:18px 22px;
            border:none;
        }

        .cardHead{
            font-size:18px;
        }

        .modal-header img{
            width:18px;
            cursor:pointer;
            filter:invert(1);
        }

        .modal-body{
            padding:22px;
            background:#f8fafc;
        }

        label{
            font-size:13px;
            color:#64748b;
            font-weight:600;
        }

        select{
            border-radius:12px;
            padding:10px 14px;
            border:1px solid #e5e7eb;
            font-size:14px;
        }
        .form-control{
            border-radius:12px;
            padding:10px 14px;
            border:1px solid #e5e7eb;
            font-size:14px;
        }

        .form-control:focus{
            border-color:#2563eb;
            box-shadow:none;
        }

        .form-control:disabled{
            background:#f1f5f9;
            color:#64748b;
        }

        /* === Select2 main box === */
        .select2-container .select2-selection--single {
            height: auto !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 12px !important;
            padding: 3px 1px !important;
            font-size: 14px !important;
            background-color: #fff !important;
            display: flex !important;
            align-items: center !important;
        }

        /* Focus / open border color */
        .select2-container--default .select2-selection--single:focus,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.15) !important;
            outline: none !important;
        }

        /* Arrow color */
        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #64748b transparent transparent transparent !important;
        }

        /* Dropdown menu */
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #2563eb !important;
            color: #fff !important;
        }

        /* === 🔍 Search bar inside dropdown === */
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #e5e7eb !important;
            border-radius: 12px !important;
            padding: 8px 12px !important;
            font-size: 14px !important;
            outline: none !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field:focus {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.15) !important;
        }

        /* Dropdown background + border radius */
        .select2-dropdown {
            border-radius: 12px !important;
            border: 1px solid #e5e7eb !important;
            overflow: hidden !important;
        }

    </style>
</head>
<body>
    @php
        $user   =  Auth()->user();
    @endphp
    <div class="container-scroller">

        @include('layouts.partials.navbar')

        <!-- partial -->
        <div class="container-fluid page-body-wrapper">

            @include('layouts.partials.sidebar')

                {{-- Page Content --}}

                <div class="main-panel">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src={{ asset('vendors/js/vendor.bundle.base.js') }}></script>
    <script src={{ asset('vendors/js/vendor.bundle.addons.js') }}></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script src={{ asset('js/shared/off-canvas.js') }}></script>
    <script src={{ asset('js/shared/misc.js') }}></script>
    <script src="{{ asset('js/vendor/select2.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src={{ asset('js/demo_1/dashboard.js') }}></script>
    <!-- End custom js for this page-->
    {{-- <script src={{ asset('js/shared/jquery.cookie.js') }} type="text/javascript"></script> --}}

    @yield('js')
    <script>
        function validate_fields(my_array,type,obj)
        {
            my_array.forEach(element =>
            {
                let error_state =   false;
                let error_span  =   $('#'+type+element);
                let message     =   '';

                for (let i = 0; i < Object.keys(obj).length; i++)
                {
                    let my_key      =   Object.keys(obj)[i];
                    let status      =   (element ==  my_key);

                    if (status)
                    {
                        message         =   obj[Object.keys(obj)[i]];
                        error_state =   true;
                    }
                }

                if (error_state)
                {
                    error_span.removeClass( "d-none");
                    error_span.empty().html(message);
                }
                else
                {
                    error_span.addClass( "d-none");
                }
            });
        }

        function clear_fields(my_array,type)
        {
            my_array.forEach(element =>
            {
                let error_span  =   $('#'+type+element);

                error_span.addClass( "d-none");
            });
        }

        function animate_btn(id,text,scope)
        {
            let target_btn         =   $('#'+id);

            if (target_btn)
            {
                if (scope == 'load')
                {
                    target_btn.empty().html("<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true' style='width: 1.5rem; height: 1.5rem;'></span>");
                    target_btn.attr( "disabled", "disabled" );
                }
                else
                {
                    target_btn.empty().html(text);
                    target_btn.removeAttr( "disabled", "disabled" );
                }
            }
        }

    </script>
    <script src="{{ asset('js/toastr.js') }}"></script>
    <script>
        function loader_on()
        {
            document.getElementById("overlay-loader").style.display = "block";
            $("#loader-image").removeClass("d-none");
        }

        function loader_off()
        {
            document.getElementById("overlay-loader").style.display = "none";
            $("#loader-image").addClass("d-none");
        }

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": 1000,
            "hideDuration": 100,
            "timeOut": 8000,
            "extendedTimeOut": 0,
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        @if(session('info'))
                @php
                    $info   =   session('info');
                @endphp

                toastr['{{$info->type}}']('{{$info->message}}', '{{$info->title}}');

                @php
                        session()->forget('info');
                @endphp
        @endif
        @if(session('success'))
                @php
                    $success   =   session('success');
                @endphp

                toastr['{{$success->type}}']('{{$success->message}}', '{{$success->title}}');

                @php
                        session()->forget('success');
                @endphp
        @endif
        @if(session('warning'))
                @php
                    $warning   =   session('warning');
                @endphp

                toastr['{{$warning->type}}']('{{$warning->message}}', '{{$warning->title}}');

                @php
                        session()->forget('warning');
                @endphp
        @endif
        @if(session('error'))
                @php
                    $error   =   session('error');
                @endphp

                toastr['{{$error->type}}']('{{$error->message}}', '{{$error->title}}');

                @php
                        session()->forget('error');
                @endphp
        @endif
        @if(session('messages'))
            @foreach(session('messages') as $item)
                toastr['{{$item->type}}']('{{$item->message}}', '{{$item->title}}');
            @endforeach

            @php
                    session()->forget('messages');
                @endphp
        @endif
        // toastr['success']('Test Message', 'Success');
    </script>
</body>
</html>
