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

    <link rel="stylesheet" href="{{ mix('assets/app/css/app.css')}}">
    <link rel="stylesheet" href="{{ mix('assets/admin/css/admin.css')}}">

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

    <script src="{{ mix('assets/admin/js/admin.js') }}"></script>
    @stack('scripts')
</body>

</html>
