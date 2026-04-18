<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Star Admin Premium Bootstrap Admin Dashboard Template</title>
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
    <script src={{ asset('vendors/js/vendor.bundle.base.js') }}></script>
    <script src={{ asset('vendors/js/vendor.bundle.addons.js') }}></script>
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
    </div>
    <script src={{ asset('js/shared/off-canvas.js') }}></script>
<script src={{ asset('js/shared/misc.js') }}></script>
    {{-- <script src={{ asset('js/shared/jquery.cookie.js') }} type="text/javascript"></script> --}}
    <script>
        (function() {
            var hideKey = 'hide_project_progress_badge_auth';
            if (localStorage.getItem(hideKey) === '1') return;
            var badge = document.createElement('div');
            badge.className = 'project-progress-badge';
            badge.id = 'project-progress-badge';
            badge.style.zIndex = '99999';
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
