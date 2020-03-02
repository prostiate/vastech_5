<div class="col-md-3 left_col menu_fixed">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="/dashboard" class="site_title"><i class="fa fa-check"></i> <span><b>Vastech</b> Cloud</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="/assets/img/pp.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>Vincent</h2>
            </div>
            <div class="clearfix"></div>
        </div>
         /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li><a href="/dashboard"><i class="fa fa-home"></i> @lang("sidebar.dashboard") </a></li>
                    <li><a><i class="fa fa-tag"></i> @lang("sidebar.sales") <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="/sales_quote">@lang("sidebar.sq")</a></li>
                            <li><a href="/sales_order">@lang("sidebar.so")</a></li>
                            <li><a href="/sales_delivery">@lang("sidebar.sd")</a></li>
                            <li><a href="/sales_invoice">@lang("sidebar.si")</a></li>
                            <li><a href="/sales_payment">@lang("sidebar.sp")</a></li>
                            <li><a href="/sales_return">@lang("sidebar.sr")</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-credit-card"></i> @lang("sidebar.purchase") <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="/purchases_quote">@lang("sidebar.pq")</a></li>
                            <li><a href="/purchases_order">@lang("sidebar.po")</a></li>
                            <li><a href="/purchases_delivery">@lang("sidebar.pd")</a></li>
                            <li><a href="/purchases_invoice">@lang("sidebar.pi")</a></li>
                            <li><a href="/purchases_payment">@lang("sidebar.pp")</a></li>
                            <li><a href="/purchases_return">@lang("sidebar.pr")</a></li>
                        </ul>
                    </li>
                    <li><a href="/expenses"><i class="fa fa-outdent"></i> @lang("sidebar.ex") </a></li>
                    <li><a href="/spk"><i class="fa fa-pencil-square"></i> @lang("sidebar.spk") </a></li>
                    <li><a href="/wip"><i class="fa fa-cogs"></i> @lang("sidebar.wip") </a></li>
                </ul>
            </div>
            <div class="menu_section">
                <h3>Management</h3>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-users"></i> @lang("sidebar.con") <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="/contacts_all">@lang("sidebar.all")</a></li>
                            <li><a href="/contacts_customer">@lang("sidebar.cus")</a></li>
                            <li><a href="/contacts_vendor">@lang("sidebar.ven")</a></li>
                            <li><a href="/contacts_employee">@lang("sidebar.emp")</a></li>
                            <li><a href="/contacts_other">@lang("sidebar.oth")</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-dropbox"></i> @lang("sidebar.prod") <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="/products">@lang("sidebar.gs")</a></li>
                            <li><a href="/stock_adjustment">@lang("sidebar.sa")</a></li>
                            <li><a href="/warehouses">@lang("sidebar.wh")</a></li>
                            <li><a href="/warehouses_transfer">@lang("sidebar.wtl")</a></li>
                        </ul>
                    </li>
                    <li><a href="/cashbank"><i class="fa fa-bank"></i> @lang("sidebar.caba") </a></li>
                    <li><a href="/asset_managements"><i class="fa fa-desktop"></i> @lang("sidebar.asset") </a></li>
                    <li><a href="/chart_of_accounts"><i class="fa fa-book"></i> @lang("sidebar.coa") </a></li>
                </ul>
            </div>
            @if(Auth::user()->name == 'user')
            <div class="menu_section">
                <h3>Construction</h3>
                <ul class="nav side-menu">
                    <li><a href="/construction/offering_letter"><i class="fa fa-close"></i> @lang("sidebar.ofl") </a></li>
                    <li><a href="/construction/budget_plan"><i class="fa fa-close"></i> @lang("sidebar.bp") </a></li>
                    <li><a href="/construction/bill_quantities"><i class="fa fa-close"></i> @lang("sidebar.bq") </a></li>
                    <li><a href="/construction/form_order"><i class="fa fa-close"></i> @lang("sidebar.fo") </a></li>
                    <li><a href="/construction/progress"><i class="fa fa-close"></i> @lang("sidebar.pro") </a></li>
                </ul>
            </div>
            @endif
            <div class="menu_section">

                <h3>Setting</h3>
                <ul class="nav side-menu">
                    <!--<li><a href="#"><i class="fa fa-money"></i> Payroll </a></li>-->
                    @role('Owner|Ultimate|Other List')
                    <li><a href="/other"><i class="fa fa-tasks"></i> @lang("sidebar.ol") </a></li>
                    @endrole
                    <!--<li><a href="#"><i class="fa fa-qrcode"></i> Add-Ons </a></li>-->
                    @role('Owner|Ultimate|Reports')
                    <li><a href="/reports"><i class="fa fa-area-chart"></i> @lang("sidebar.rep") </a></li>
                    @endrole
                    @role('Owner|Ultimate|Setting')
                    <li><a href="/settings/company"><i class="fa fa-cog"></i> @lang("sidebar.set") </a></li>
                    @endrole
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings" href="/setting">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        /menu footer buttons -->
    </div>
</div>