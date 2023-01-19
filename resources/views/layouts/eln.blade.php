<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" type="image/png" href="{{ asset('img/sukk.png') }}">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('adminlte-3/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- sweetalert2 -->
    <link rel="stylesheet" href="{{ asset('sweetalert/sweetalert2.min.css') }}">
    @yield('link')

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
        th {
            text-align: center;
        }

        .ow-break-word {
            overflow-wrap: break-word;
        }

        .hyphens {
            hyphens: auto;
        }

    </style>
</head>

<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->

<body class="hold-transition skin-red sidebar-mini">
   
    <div class="wrapper">
        {{-- </header> --}}
        @include('layouts.eln.nav')

        <!-- Main Sidebar Container -->
        @include('layouts.eln.sidebar')

        <div class="content-wrapper">
            @yield('content')
            @php
                $kp = Auth::user()->nokp;
                $pass = Auth::user()->password;
            @endphp
            @if (Hash::check($kp, $pass))
                <!-- Modal -->
                <div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tukar Kata Laluan</h5>

                            </div>
                            <form action="{{ url('tukar-password') }}" method="post">
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="password">Kata Laluan Baru</label>
                                            <input type="password"
                                                class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                name="password" id="password" aria-describedby="helpId"
                                                aria-invalid="true" required autofocus>
                                            <small id="helpId" class="error invalid-feedback">
                                                {{ $errors->first('password') }}
                                            </small>
                                        </div>

                                        <div class="form-group">
                                            <label for="confirmpassword">Taip Semula Kata Laluan Baru</label>
                                            <input type="password" class="form-control {{ $errors->has('confirmpassword') ? ' is-invalid' : '' }}"
                                                name="confirmpassword" id="confirmpassword" aria-invalid="true" aria-describedby="helpId"
                                                required>
                                            <small id="helpId" class="error invalid-feedback">
                                                {{ $errors->first('confirmpassword') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="{{ url('logout') }}" class="btn btn-secondary"> <i
                                            class="fas fa-sign-out-alt"></i> Log Keluar</a>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                        Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <!-- Main Footer -->
        @include('layouts.eln.footer')
    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="{{ asset('adminlte-3/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('adminlte-3/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte-3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('adminlte-3/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('adminlte-3/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    {{-- <script src="{{ asset('adminlte-3/plugins/jqvmap/jquery.vmap.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('adminlte-3/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script> --}}
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('adminlte-3/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('adminlte-3/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('adminlte-3/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('adminlte-3/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
    </script>
    <!-- Summernote -->
    <script src="{{ asset('adminlte-3/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('adminlte-3/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte-3/dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    {{-- <script src="{{ asset('adminlte-3/dist/js/pages/dashboard.js') }}"></script> --}}
    <!-- Select2 -->
    <script src="{{ asset('adminlte-3/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('adminlte-3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- bs-custom-file-input -->
    <script src="{{ asset('adminlte-3/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('adminlte-3/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('adminlte-3/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- SweetAlert -->
    <script src="{{ asset('sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('sweetalert/sweetalert2.min.js') }}"></script>

    @yield('script')

    <script>
        $('#luluspermohonan').click(function() {
            Swal.fire({
                title: 'Adakah anda pasti?',
                text: "Permohonan ini akan diluluskan",
                icon: 'question',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Luluskan'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Diluluskan!',
                        'Permohonan telah berjaya diluluskan.',
                        'success'
                    )
                }
            });
        });

        



        $(function() {
            bsCustomFileInput.init();
        });
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2();

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {
                'placeholder': 'mm/dd/yyyy'
            })
            //Money Euro
            $('[data-mask]').inputmask();

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            //Date and time picker
            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                }
            });

            //Date range picker
            $('#reservation').daterangepicker({
                locale: {
                    format: 'MM/DD/YYYY'
                }
            })
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'DD/MM/YYYY hh:mm A'
                }
            });
            //Date range as a button
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                            'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                        'MMMM D, YYYY'))
                }
            );

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            });

            //Bootstrap Duallistbox
            // $('.duallistbox').bootstrapDualListbox();

            //Colorpicker
            // $('.my-colorpicker1').colorpicker();
            //color picker with addon
            // $('.my-colorpicker2').colorpicker();

            // $('.my-colorpicker2').on('colorpickerChange', function(event) {
            //     $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            // })

            // $("input[data-bootstrap-switch]").each(function() {
            //     $(this).bootstrapSwitch('state', $(this).prop('checked'));
            // });
        });
    </script>

    <script type="text/javascript">
        $(window).on('load', function() {
            $('#myModal').modal('show');
        });
    </script>
     @include('sweetalert::alert')
</body>

</html>
