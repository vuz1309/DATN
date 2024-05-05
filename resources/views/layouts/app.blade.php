<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ !empty($header_title) ? $header_title : '' }} - Quản lý trường học</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('public/plugins/fontawesome-free/css/all.min.css') }} ">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ url('public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }} ">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ url('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }} ">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ url('public/plugins/jqvmap/jqvmap.min.css') }} ">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('public/dist/css/adminlte.min.css') }} ">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ url('public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }} ">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ url('public/plugins/daterangepicker/daterangepicker.css') }} ">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ url('public/plugins/summernote/summernote-bs4.min.css') }} ">
    <link rel="stylesheet" href="{{ url('public/plugins/select2/css/select2.min.css') }}" />
    <!-- Google Font: Source Sans Pro -->


    <link rel="stylesheet" href="{{ url('public/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ url('public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{ url('public/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="{{ url('public/plugins/bs-stepper/css/bs-stepper.min.css') }}">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="{{ url('public/plugins/dropzone/min/dropzone.min.css') }}">
    <!-- Theme style -->
    <style>
        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.5);
            transition: opacity 0.1s, visibility 0.1s;
            z-index: 99999;
        }

        .loader--hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loader::after {
            content: "";
            width: 75px;
            height: 75px;
            border: 8px solid #dddddd;
            border-top-color: #1975d7;
            border-radius: 50%;
            animation: loading 0.5s ease infinite;
        }

        @keyframes loading {
            from {
                transform: rotate(0turn);
            }

            to {
                transform: rotate(1turn);
            }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <div class="loader"></div>

        @include('layouts.header')
        @yield('content')
        @include('_alert_dialog')
        @include('layouts.footer')
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ url('public/plugins/jquery/jquery.min.js') }} "></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ url('public/plugins/jquery-ui/jquery-ui.min.js') }} "></script>


    <!-- jquery-validation -->
    <script src="{{ url('public/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ url('public/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('public/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ url('resources/js/_alert_dialog.js') }}"></script>
    <script src="{{ url('resources/js/tools/currency.js') }}"></script>

    <!-- Bootstrap 4 -->
    <script src=" {{ url('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
    <!-- ChartJS -->
    <script src=" {{ url('public/plugins/chart.js/Chart.min.js') }} "></script>
    <!-- Sparkline -->
    <script src=" {{ url('public/plugins/sparklines/sparkline.js') }} "></script>
    <!-- JQVMap -->
    <script src=" {{ url('public/plugins/jqvmap/jquery.vmap.min.js') }} "></script>
    <script src=" {{ url('public/plugins/jqvmap/maps/jquery.vmap.usa.js') }} "></script>
    <!-- jQuery Knob Chart -->
    <script src=" {{ url('public/plugins/jquery-knob/jquery.knob.min.js') }} "></script>
    <!-- daterangepicker -->
    <script src=" {{ url('public/plugins/moment/moment.min.js') }} "></script>
    <script src=" {{ url('public/plugins/daterangepicker/daterangepicker.js') }} "></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src=" {{ url('public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }} "></script>
    <!-- Summernote -->
    <!-- overlayScrollbars -->
    <script src=" {{ url('public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }} "></script>
    <!-- AdminLTE App -->

    <script src="{{ url('public/dist/js/pages/dashboard.js') }}"></script>


    <script src="{{ url('public/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ url('public/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="{{ url('public/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ url('public/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ url('public/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- date-range-picker -->
    <!-- bootstrap color picker -->
    <script src="{{ url('public/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <!-- BS-Stepper -->
    <script src="{{ url('public/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
    <!-- dropzonejs -->
    <script src="{{ url('public/plugins/dropzone/min/dropzone.min.js') }}"></script>

    <script src="{{ url('public/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <!-- AdminLTE App -->

    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
        window.addEventListener("load", () => {
            const loader = document.querySelector(".loader");
            if (loader) {
                loader.classList.add("loader--hidden");

                // loader.addEventListener("transitionend", () => {
                //     document.body.removeChild(loader);
                // });
            }

        });
    </script>
    {{-- <script type="text/javascript">
        $(document).ready(function() {
            // Áp dụng mask cho tất cả các input type date
            $('input[type="date"]').inputmask({
                "mask": "99/99/9999",
                "placeholder": 'DD/MM/YYYY'
            });
        });
    </script> --}}

    @yield('script')

</body>

</html>
