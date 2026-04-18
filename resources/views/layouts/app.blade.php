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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css">
    <link rel="stylesheet" href={{ asset('vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}>
    <link rel="stylesheet" href={{ asset('vendors/iconfonts/ionicons/dist/css/ionicons.css') }}>
    <link rel="stylesheet" href={{ asset('vendors/iconfonts/flag-icon-css/css/flag-icon.min.css') }}>
    <link rel="stylesheet" href={{ asset('vendors/css/vendor.bundle.base.css') }}>
    <link rel="stylesheet" href={{ asset('vendors/css/vendor.bundle.addons.css') }}>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
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
            color:#181818;
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

        /* pagination  */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 15px 0;
            list-style: none;
        }

        /* Lock Size Completely */
        .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            font-size: 15px;
            font-weight: 500;
            color: #374151;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            text-decoration: none;
            transition: all 0.25s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            box-sizing: border-box; /* VERY IMPORTANT */
        }

        /* Hover */
        .page-link:hover {
            background: #eef2ff;
            color: #2563eb;
            border: 1px solid #c7d2fe; /* border remove mat karein */
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.08);
        }

        /* Active */
        .page-item.active .page-link {
            background: #2563eb;
            color: #ffffff;
            border: 1px solid #2563eb; /* border remove na karein */
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.35);
        }

        /* Disabled */
        .page-item.disabled .page-link {
            background: #f3f4f6;
            color: #cbd5e1;
            border: 1px solid #e5e7eb;
            box-shadow: none;
            cursor: not-allowed;
        }

        /* FIX IMAGE RESIZE ISSUE */
        .page-link img {
            width: 18px;
            height: 18px;
            min-width: 18px;
            min-height: 18px;
            max-width: 18px;
            max-height: 18px;
            object-fit: contain;
            display: block;
        }

        .ios-switch {
            position: relative;
            display: inline-block;
            width: 42px;
            height: 22px;
        }

        .ios-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .ios-slider {
            position: absolute;
            cursor: pointer;
            background-color: #ccc;
            border-radius: 50px;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            transition: 0.3s;
        }

        .ios-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 2px;
            bottom: 2px;
            background: white;
            border-radius: 50%;
            transition: 0.3s;
        }

        .ios-switch input:checked + .ios-slider {
            background-color: #4cd964;
        }

        .ios-switch input:checked + .ios-slider:before {
            transform: translateX(20px);
        }
        /* calendar box */
        .flatpickr-calendar {
            border-radius: 15px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
            border: none !important;
            overflow: hidden;
        }

        /* header */
        .flatpickr-months {
            background:linear-gradient(135deg,#2563eb,#1e40af);
            color: white;
        }

        /* month text */
        .flatpickr-current-month {
            font-weight: bold;
        }

        /* days */
        .flatpickr-day {
            border-radius: 8px !important;
            transition: 0.2s;
        }

        /* hover effect */
        .flatpickr-day:hover {
            background: #e8f5e9;
        }

        /* selected day */
        .flatpickr-day.selected {
            background:linear-gradient(135deg,#2563eb,#1e40af) !important;
            color: #fff !important;
        }

        /* today highlight */
        .flatpickr-day.today {
            border: 1px solid #1e40af;
        }

        /* arrows */
        .flatpickr-prev-month,
        .flatpickr-next-month {
            fill: white !important;
        }

        .date-wrapper {
            position: relative;
        }

        .modern-date {
            border-radius: 10px;
            padding: 10px 40px 10px 12px; /* right space for icon */
            border: 1px solid #ddd;
            transition: 0.3s;
            height: 42px;
        }

        /* ICON FIX */
        .calendar-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 16px;
            pointer-events: none; /* important */
        }
        /* BASE BADGE */
        .badge-custom {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 8px;
            text-transform: capitalize;
        }

        /* STATUS COLORS (DARKER & CLEAN) */
        .status-pending {
            background-color: #ffc107;
            color: #1f1f1f;
        }

        .status-active {
            background-color: #0d6efd;
            color: #ffffff;
        }

        .status-testing {
            background-color: #6f42c1;
            color: #ffffff;
        }

        .status-completed {
            background-color: #198754;
            color: #ffffff;
        }

        .status-default {
            background-color: #6c757d;
            color: #ffffff;
        }

        /* PRIORITY COLORS (DARKER) */
        .priority-low {
            background-color: #20c997;
            color: #ffffff;
        }

        .priority-medium {
            background-color: #fd7e14;
            color: #ffffff;
        }

        .priority-high {
            background-color: #dc3545;
            color: #ffffff;
        }

        .priority-default {
            background-color: #343a40;
            color: #ffffff;
        }
    </style>
    <style>
        .project-progress-badge {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 320px;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: white;
            padding: 14px 16px;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            font-size: 13px;
            line-height: 1.5;
            animation: slideInBadge 0.4s ease-out;
        }
        @keyframes slideInBadge {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .project-progress-badge .badge-close {
            position: absolute;
            top: 6px;
            right: 8px;
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            opacity: 0.8;
            line-height: 1;
            padding: 0;
        }
        .project-progress-badge .badge-close:hover { opacity: 1; }
        .project-progress-badge .badge-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 10px;
            font-size: 12px;
        }
        .project-progress-badge .badge-checkbox input {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }
    </style>

    @yield('css')
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
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

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
        var base_url = "{{ url('/') }}";

        $(document).ready(function ()
        {
            // 👉 CURRENT PATH
            var current = window.location.pathname;

            // 👉 RESET (optional but safe)
            $('#sidebar .collapse').removeClass('show');
            $('#sidebar .menu-toggle').attr('aria-expanded', 'false');

            // 👉 AUTO ACTIVE DETECTION
            $('#sidebar .nav-link').each(function ()
            {
                var link = $(this).attr('href');

                if (!link || link === '#') return;

                // full URL → pathname
                var linkPath = new URL(link, window.location.origin).pathname;

                if (current === linkPath)
                {
                    $('#sidebar .nav-link').removeClass('active');
                    $('#sidebar .nav-item').removeClass('active');

                    $(this).addClass('active');
                    $(this).parent('.nav-item').addClass('active');

                    // 👉 OPEN PARENT MENUS
                    var parents = $(this).parents('.collapse');

                    parents.each(function ()
                    {
                        $(this).addClass('show');
                        $(this).prev('.menu-toggle').attr('aria-expanded', 'true');
                        $(this).parent('.nav-item').addClass('active');
                    });
                }
            });
        });

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

        function clear_data(x)
        {
            let modal_name = $(x).attr('data-target');

            $(modal_name).find('input').val('');
            $(modal_name).find('select').prop('selectedIndex', 0).trigger('change');
        }

        function fetch_data(page, target)
        {
            let parts = target.split('-');
            let route = base_url + '/' + parts.join('/') + '/index';

            $.ajax(
            {
                url         :   route+"?page="+page,
                type        :   "get",
                datatype    :   "html",
                success     :   function(success_response)
                {
                    $('#'+target+'-table-data').empty().html(success_response);


                    $("input[data-bootstrap-switch]").each(function()
                    {
                        $(this).bootstrapSwitch();
                    });
                },
                error       :   function(error_response)
                {
                    toastr['error']('Server error','Error');
                }
            });
        }

        $(document).on('submit', '.create_form', function(event)
        {
            event.preventDefault();

            let target      = $(this).data('target');
            let my_array    = $(this).data('array');
            let form        = $("#create_"+target+"_form");
            let data        = form.serialize();
            let create_btn  = $("#create_"+target+"_btn");
            let route       = create_btn.data('route');
            let btn_text    = create_btn.html();

            create_btn.html("<div class='btn_loader'></div>");
            create_btn.attr("disabled", true);

            $.ajax({
                url     : route,
                type    : 'POST',
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data    : data,

                success : function(success_resp)
                {
                    create_btn.html(btn_text);
                    create_btn.removeAttr("disabled");

                    toastr[success_resp.type](success_resp.message, success_resp.type.toUpperCase());

                    $("#create-"+target+"-modal").modal('hide');

                    setTimeout(function(){
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                    },200);

                    form[0].reset();

                    page = 1;
                    fetch_data(page,target);
                },
                error : function(error_resp)
                {
                    create_btn.html(btn_text);
                    create_btn.removeAttr("disabled");

                    if (error_resp.status == 422)
                    {
                        let type = 'create_';
                        let obj  = error_resp.responseJSON.errors;

                        validate_fields(my_array, type, obj);
                    }
                    else
                    {
                        let data = error_resp.responseJSON;
                        toastr[data.type](data.message, data.type.toUpperCase());
                    }
                }
            });
        });

        $(document).on('submit', '.update_form', function(event)
        {
            event.preventDefault();

            let target      =   $(this).data('target');
            let my_array    =   $(this).data('array');
            let my_form     =   $("#update-"+target+"-form");
            let data        =   my_form.serialize();
            let route       =   my_form.attr("action");
            let btn         =   "update_"+target+"_btn";
            let btn_text    =   $("#"+btn).html();

            console.log(my_form);
            animate_btn(btn,btn_text,'load');

            $.ajax(
            {
                url     :   route,
                type    :   'post',
                data    :   data,
                success: function(success_resp)
                {
                    fetch_data(1,target);
                    animate_btn(btn,btn_text,'remove');
                    $('#update-'+target+'-modal').modal('hide');
                    $("#update-"+target+"-form")[0].reset();
                    toastr[success_resp.type](success_resp.message,success_resp.type.toUpperCase());
                },
                error: function(error_resp)
                {
                    animate_btn(btn,btn_text,'remove');

                    if (error_resp.status   ==  422)
                    {
                        let type        =   'update_';
                        var obj         =   error_resp.responseJSON.errors;

                        validate_fields(my_array,type,obj)
                    }
                    else
                    {
                        let data    =   error_resp.responseJSON;
                        toastr[data.type](data.message,data.type.toUpperCase());
                    }
                }
            });
        });

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

        function set_delete_recode_id(id, target)
        {
            $('#delete-'+target+'-id').val(id);
            $("#delete-"+target+"-modal").modal('show');
        }

        function delete_recode(target)
        {
            let id              =   $('#delete-'+target+'-id').val();
            let btn             =   "delete-"+target+"-btn";
            let delete_route    =   $('#delete-'+target+'-btn').data('delete-route');
            delete_route        =   delete_route.replace(':id', id);
            let btn_text        =   $("#"+btn).html();

            animate_btn(btn,btn_text,'load');

            $.ajax(
            {
                url     :   delete_route,
                type    :   'get',
                headers :   {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success : function(success_resp)
                {
                    animate_btn(btn,btn_text,'remove');
                    $("#delete-"+target+"-modal").modal('hide');
                    toastr[success_resp.type](success_resp.message,success_resp.type.toUpperCase());
                    fetch_data(1,target);

                },
                error   : function(error_resp)
                {
                    animate_btn(btn,btn_text,'remove');
                    $("#delete-"+target+"-modal").modal('hide');
                    let data    =   error_resp.responseJSON;
                    toastr[data.type](data.message,data.type.toUpperCase());
                }
            });
        }

        function initDatePicker(selector) {
            return flatpickr(selector, {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "F j, Y"
            });
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
    <script>
        (function() {
            var hideKey = 'hide_project_progress_badge';
            if (localStorage.getItem(hideKey) === '1') return;
            var badge = document.createElement('div');
            badge.className = 'project-progress-badge';
            badge.id = 'project-progress-badge';
            badge.innerHTML = '<button type="button" class="badge-close" onclick="closeProgressBadge()">&times;</button><strong>Notice:</strong><br>This project is under development and will be completed soon.';
            badge.innerHTML += '<label class="badge-checkbox"><input type="checkbox" id="dont-show-again" onclick="handleDontShowAgain()"> Don\'t show again</label>';
            document.body.appendChild(badge);
            function closeProgressBadge() {
                var el = document.getElementById('project-progress-badge');
                if (el) el.remove();
            }
            window.closeProgressBadge = closeProgressBadge;
            function handleDontShowAgain() {
                var cb = document.getElementById('dont-show-again');
                if (cb.checked) {
                    localStorage.setItem(hideKey, '1');
                    closeProgressBadge();
                }
            }
            window.handleDontShowAgain = handleDontShowAgain;
        })();
    </script>
</body>
</html>
