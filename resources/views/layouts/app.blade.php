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
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

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



    <!-- DataTables -->
    <link rel="stylesheet" href="{{ url('public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet"
        href="{{ url('public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ url('public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}" />

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

        .dataTables_wrapper .dt-buttons {
            width: 100%;
        }
    </style>
    @yield('style')
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
    <script src="{{ url('resources/js/_loading.js') }}"></script>
    <script src="{{ url('resources/js/tools/currency.js') }}"></script>

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


    <!-- DataTables  & Plugins -->
    <script src="{{ url('public/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('public/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ url('public/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ url('public/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ url('public/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ url('public/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ url('public/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ url('public/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ url('public/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
        window.addEventListener("load", () => {
            const loader = document.querySelector(".loader");
            if (loader) {
                loader.classList.add("loader--hidden");
            }
            $("#tableList").DataTable({
                    paging: false,
                    lengthChange: false,
                    searching: '{{ !empty($useSearch) ? $useSearch : false }}',
                    ordering: true,
                    info: false,
                    autoWidth: false,
                    responsive: false,
                    language: {
                        search: "Tìm kiếm:",
                        searchPlaceholder: "Nhập từ khóa tìm kiếm...",
                    },
                    buttons: [{
                            extend: 'copy',
                            text: '<i class="fas fa-copy"></i> Sao chép',
                            className: 'btn btn-md ml-2 mt-2 mr-2 btn-secondary'
                        },
                        {
                            extend: 'excel',

                            text: '<i class="fas fa-file-excel"></i> Xuất khẩu',
                            className: 'btn btn-md mr-2 mt-2 btn-info'
                        },
                        {
                            extend: 'pdf',

                            text: '<i class="fas fa-file-pdf"></i> PDF',
                            className: 'btn btn-md mr-2 mt-2 btn-warning'
                        },
                        {
                            extend: 'print',

                            text: '<i class="fas fa-print"></i> In',
                            className: 'btn btn-md mr-2 mt-2 btn-success'
                        },
                        {
                            extend: 'colvis',
                            text: '<i class="fas fa-eye"></i> Ẩn hiện cột',
                            className: 'btn btn-md mr-2 mt-2 btn-dark'
                        },
                    ],
                }).buttons()
                .container()
                .appendTo("#tools");
            const currentSearchBox = $('#tableList_filter');

            // Chuyển ô tìm kiếm đến target mong muốn
            $('#searchBox').append(currentSearchBox);
        });
    </script>

    @yield('script')

</body>

</html>
