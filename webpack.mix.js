const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

/*
 |--------------------------------------------------------------------------
 | Core
 |--------------------------------------------------------------------------
 |
 */

mix.scripts(
    [
        "node_modules/jquery/dist/jquery.js",
        //"resources/assets/js/app.js"
    ],
    "public/assets/app/js/app.js"
).version();

mix.styles(
    [
        "node_modules/font-awesome/css/font-awesome.css",
    ],
    "public/assets/app/css/app.css"
).version();

mix.copy(["node_modules/font-awesome/fonts/"], "public/assets/app/fonts");

/*
 |--------------------------------------------------------------------------
 | Auth
 |--------------------------------------------------------------------------
 |


mix.styles(
    "resources/assets/auth/css/login.css",
    "public/assets/auth/css/login.css"
).version();
mix.styles(
    "resources/assets/auth/css/register.css",
    "public/assets/auth/css/register.css"
).version();
mix.styles(
    "resources/assets/auth/css/passwords.css",
    "public/assets/auth/css/passwords.css"
).version();

mix.styles(
    [
        "node_modules/bootstrap/dist/css/bootstrap.css",
        "node_modules/gentelella/vendors/animate.css/animate.css",
        "node_modules/gentelella/build/css/custom.css"
    ],
    "public/assets/auth/css/auth.css"
).version();
*/

/*
 |--------------------------------------------------------------------------
 | Admin
 |--------------------------------------------------------------------------
 |
 */

mix.scripts(
    [
        //Bootstrap
        "node_modules/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js",
        //Progress Bar
        "node_modules/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js",
        "node_modules/gentelella/build/js/custom.js",
        //iCheck
        "node_modules/gentelella/vendors/iCheck/icheck.min.js",
        //nProgress
        "node_modules/gentelella/vendors/nprogress/nprogress.js",
        //DataTables
        "node_modules/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js",
        "node_modules/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js",
        "node_modules/gentelella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js",
        "node_modules/gentelella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js",
        "node_modules/gentelella/vendors/datatables.net-buttons/js/buttons.flash.min.js",
        "node_modules/gentelella/vendors/datatables.net-buttons/js/buttons.html5.min.js",
        "node_modules/gentelella/vendors/datatables.net-buttons/js/buttons.print.min.js",
        "node_modules/gentelella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js",
        "node_modules/gentelella/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js",
        "node_modules/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js",
        "node_modules/gentelella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js",
        "node_modules/gentelella/vendors/datatables.net-scroller/js/dataTables.scroller.min.js",
        //Chart JS
        "node_modules/gentelella/vendors/Chart.js/dist/Chart.min.js",
        //ECharts
        "node_modules/gentelella/vendors/echarts/dist/echarts.min.js",
        "node_modules/gentelella/vendors/echarts/map/js/world.js",
        //DateJS
        "node_modules/gentelella/vendors/DateJS/build/date.js",
        //Moment JS
        "node_modules/gentelella/production/js/moment/moment.min.js",
        //Datepicker Range
        "node_modules/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js",
        //Ion Rangeslider
        "node_modules/gentelella/vendors/ion.rangeSlider/js/ion.rangeSlider.min.js",
        //Custom Scrollbar
        "node_modules/gentelella/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js",
        //SweetAlert2
        "node_modules/sweetalert2/dist/sweetalert2.all.min.js",
        //ZEBRA DATEPICKER
        "node_modules/zebra_datepicker/dist/zebra_datepicker.min.js",

        "node_modules/gentelella/vendors/jszip/dist/jszip.min.js",
        "node_modules/gentelella/vendors/pdfmake/build/pdfmake.min.js",
        "node_modules/gentelella/vendors/pdfmake/build/vfs_fonts.js",
        "node_modules/guidechimp/dist/guidechimp.min.js",
        "node_modules/guidechimp/dist/plugins/multiPage.min.js",
        //Select2
        "node_modules/select2/dist/js/select2.full.min.js"
        //'resources/assets/admin/js/admin.js',
        /* MAYBE ADD THIS SCRIPT LATER IF NEEDED OR DELETE IT
        <!-- Gauge JS -->
        <script src="{{ asset('assets/gentelella/vendors/gauge.js/dist/gauge.min.js') }}"></script>
        <!-- Skyicons -->
        <script src="{{ asset('assets/gentelella/vendors/skycons/skycons.js') }}"></script>
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
        <!-- JQVMAP -->
        <script src="{{ asset('assets/gentelella/vendors/jqvmap/dist/jquery.vmap.js') }}"></script>
        <script src="{{ asset('assets/gentelella/vendors/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
        <script src="{{ asset('assets/gentelella/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>
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
        */
    ],
    "public/assets/admin/js/admin.js"
).version();

mix.styles(
    [
        //Bootstrap
        "node_modules/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css",
        //nProgress
        "node_modules/gentelella/vendors/nprogress/nprogress.css",
        //iCheck
        "node_modules/gentelella/vendors/iCheck/skins/flat/green.css",
        //Datatable Needs
        "node_modules/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css",
        "node_modules/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css",
        "node_modules/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css",
        "node_modules/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css",
        "node_modules/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css",
        //Normalize
        "node_modules/gentelella/vendors/normalize-css/normalize.css",
        "node_modules/gentelella/vendors/ion.rangeSlider/css/ion.rangeSlider.css",
        "node_modules/gentelella/vendors/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css",
        //Progress Bar
        "node_modules/gentelella/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css",
        //Datepicker Range
        "node_modules/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css",
        "node_modules/guidechimp/dist/guidechimp.min.css",
        //Select2
        "node_modules/select2/dist/css/select2.min.css",
        //SweetAlert2
        "node_modules/sweetalert2/dist/sweetalert2.min.css",
        //Zebra Datepicker
        "node_modules/zebra_datepicker/dist/css/bootstrap/zebra_datepicker.min.css"
        //'resources/assets/admin/css/admin.css',
    ],
    "public/assets/admin/css/admin.css"
).version();

/*  ADD THIS LATER IF NEEDED
//Mjolnic Bootstrap Colorpicker
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    //Cropper
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/cropper/dist/cropper.min.css') }}">
    //PNotify
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/pnotify/dist/pnotify.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/pnotify/dist/pnotify.buttons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/pnotify/dist/pnotify.nonblock.css') }}">
    //JQVMAP
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/jqvmap/dist/jqvmap.min.css') }}">
    //Custom Scrollbar
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') }}">
    //SweetAlert2
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/sweetalert2/sweetalert2.min.css') }}">
    //ZEBRA DATEPICKER
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/zebradatepicker/dist/css/bootstrap/zebra_datepicker.css') }}">
    //Prettify
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/google-code-prettify/bin/prettify.min.css') }}">
    //Switchery
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/switchery/dist/switchery.min.css') }}">
    //Starr
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/starrr/dist/starrr.css') }}">
    //Custom Theme Style
    <link rel="stylesheet" href="{{ asset('assets/gentelella/build/css/custom.min.css') }}"></link>
*/

mix.copy(
    ["node_modules/gentelella/vendors/bootstrap/dist/fonts"],
    "public/assets/admin/fonts"
);


