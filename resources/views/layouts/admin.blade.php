<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Vastech Cloud</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/png" href="/assets/img/logovastech.webp">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/font-awesome/css/font-awesome.min.css') }}">
    <!-- NProgress -->
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/nprogress/nprogress.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/iCheck/skins/flat/green.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css">
    <!-- Datatable Needs -->
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}">
    <!-- Normalize -->
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/normalize-css/normalize.css') }}">
    <!-- Ion Range Slider -->
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/ion.rangeSlider/css/ion.rangeSlider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css') }}">
    <!-- Datepicker Range -->
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- Mjolnic Bootstrap Colorpicker -->
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <!-- Cropper -->
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/cropper/dist/cropper.min.css') }}">
    <!-- Progress Bar -->
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}">
    <!-- PNotify -->
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/pnotify/dist/pnotify.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/pnotify/dist/pnotify.buttons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/pnotify/dist/pnotify.nonblock.css') }}">
    <!-- JQVMAP -->
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/jqvmap/dist/jqvmap.min.css') }}">
    <!-- Custom Scrollbar -->
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/sweetalert2/sweetalert2.min.css') }}">
    <!-- ZEBRA DATEPICKER -->
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/zebradatepicker/dist/css/bootstrap/zebra_datepicker.css') }}">
    <!-- Prettify -->
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/google-code-prettify/bin/prettify.min.css') }}">
    <!-- Switchery -->
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/switchery/dist/switchery.min.css') }}">
    <!-- Starr -->
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/starrr/dist/starrr.css') }}">
    <!-- Custom Theme Style -->
    <link rel="stylesheet" href="{{ asset('assets/gentelella/build/css/custom.min.css') }}">
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <!-- side navigation -->
            @include('layouts/sidebar')
            <!-- /side navigation -->

            <!-- top navigation -->
            @include('layouts/header')
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <!--<div class="page-title">
                        <div class="title_left">
                            <h3>Plain Page</h3>
                        </div>

                        <div class="title_right">
                            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search for...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">Go!</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    @yield('contentheader')

                    <div class="clearfix"></div>

                    @yield('content')
                    <!--<div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Plain Page</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Settings 1</a>
                                                </li>
                                                <li><a href="#">Settings 2</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    Add content to the page ...
                                </div>
                            </div>
                        </div>
                    </div>-->
                </div>
            </div>
            <!-- /page content -->

            <!-- footer content -->
            @include('layouts/footer')
            <!-- /footer content -->
        </div>
    </div>

    <!-- jQuery
    <script src="{{ asset('assets/gentelella/vendors/jquery2/jquery.min.js') }}"></script> -->
    <script src="{{ asset('assets/gentelella/vendors/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('assets/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('assets/gentelella/vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ asset('assets/gentelella/vendors/nprogress/nprogress.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('assets/gentelella/vendors/iCheck/icheck.min.js') }}"></script>
    <!-- Select2 -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <!-- Datatable Needs -->
    <script src="{{ asset('assets/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/jszip/dist/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/pdfmake/build/vfs_fonts.js') }}"></script>
    <!-- Chart JS -->
    <script src="{{ asset('assets/gentelella/vendors/Chart.js/dist/Chart.min.js') }}"></script>
    <!-- Gauge JS -->
    <script src="{{ asset('assets/gentelella/vendors/gauge.js/dist/gauge.min.js') }}"></script>
    <!-- Skyicons -->
    <script src="{{ asset('assets/gentelella/vendors/skycons/skycons.js') }}"></script>
    <!-- ECharts -->
    <script src="{{ asset('assets/gentelella/vendors/echarts/dist/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/echarts/map/js/world.js') }}"></script>
    <!-- JQuery Sparkline -->
    <script src="{{ asset('assets/gentelella/vendors/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
    <!-- JQuery Easy Pie -->
    <script src="{{ asset('assets/gentelella/vendors/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js') }}"></script>
    <!-- JQuery Flot -->
    <script src="{{ asset('assets/gentelella/vendors/Flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/Flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/Flot/jquery.flot.time.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/Flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/Flot/jquery.flot.resize.js') }}"></script>
    <!-- JQuery Flot -->
    <script src="{{ asset('assets/gentelella/vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/flot.curvedlines/curvedLines.js') }}"></script>
    <!-- DateJS -->
    <script src="{{ asset('assets/gentelella/vendors/DateJS/build/date.js') }}"></script>
    <!-- JQVMAP -->
    <script src="{{ asset('assets/gentelella/vendors/jqvmap/dist/jquery.vmap.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>
    <!-- Moment JS -->
    <script src="{{ asset('assets/gentelella/vendors/moment/min/moment.min.js') }}"></script>
    <!-- Datepicker Range -->
    <script src="{{ asset('assets/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- Ion Rangeslider -->
    <script src="{{ asset('assets/gentelella/vendors/ion.rangeSlider/js/ion.rangeSlider.min.js') }}"></script>
    <!-- Mjolnic Bootstrap Colorpicker -->
    <script src="{{ asset('assets/gentelella/vendors/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') }}"></script>
    <!-- JQuery Knob -->
    <script src="{{ asset('assets/gentelella/vendors/jquery-knob/dist/jquery.knob.min.js') }}"></script>
    <!-- Progress Bar -->
    <script src="{{ asset('assets/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('assets/gentelella/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>
    <!-- Custom Scrollbar -->
    <script src="{{ asset('assets/gentelella/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('assets/gentelella/vendors/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- ZEBRA DATEPICKER -->
    <script src="{{ asset('assets/gentelella/vendors/zebradatepicker/dist/zebra_datepicker.min.js') }}"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="{{ asset('assets/gentelella/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js') }}"></script>
    <!-- JQuery Hotkeys -->
    <script src="{{ asset('assets/gentelella/vendors/jquery.hotkeys/jquery.hotkeys.js') }}"></script>
    <!-- Prettify -->
    <script src="{{ asset('assets/gentelella/vendors/google-code-prettify/src/prettify.js') }}"></script>
    <!-- JQuery Tags Input -->
    <script src="{{ asset('assets/gentelella/vendors/jquery.tagsinput/src/jquery.tagsinput.js') }}"></script>
    <!-- Switchery -->
    <script src="{{ asset('assets/gentelella/vendors/switchery/dist/switchery.min.js') }}"></script>
    <!-- Parsley -->
    <script src="{{ asset('assets/gentelella/vendors/parsleyjs/dist/parsley.min.js') }}"></script>
    <!-- Autosize -->
    <script src="{{ asset('assets/gentelella/vendors/autosize/dist/autosize.min.js') }}"></script>
    <!-- Devbridge Autocomplete -->
    <script src="{{ asset('assets/gentelella/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js') }}"></script>
    <!-- Starrr -->
    <script src="{{ asset('assets/gentelella/vendors/starrr/dist/starrr.js') }}"></script>
    <!-- JQuery Smart Wizard -->
    <script src="{{ asset('assets/gentelella/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js') }}"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{ asset('assets/gentelella/build/js/custom.min.js') }}"></script>
    @stack('scripts')
</body>

</html>