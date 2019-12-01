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
                    <li><a href="/dashboard"><i class="fa fa-home"></i> Dashboard </a></li>
                    <!-- <li><a href="/sales"><i class="fa fa-tag"></i> Sales </a></li> -->
                    @hasrole('Owner|Ultimate|Sales|GT|MT|WS')
                    <li><a><i class="fa fa-tag"></i> Sales <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="/sales_quote">Sales Quote</a></li>
                            <li><a href="/sales_order">Sales Order</a></li>
                            <li><a href="/sales_delivery">Sales Delivery</a></li>
                            <li><a href="/sales_invoice">Sales Invoice</a></li>
                            <li><a href="/sales_payment">Sales Payment</a></li>
                            <li><a href="/sales_return">Sales Return</a></li>
                        </ul>
                    </li>
                    @endrole
                    @hasrole('Owner|Ultimate|Purchase')
                    <li><a><i class="fa fa-credit-card"></i> Purchases <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="/purchases_quote">Purchases Quote</a></li>
                            <li><a href="/purchases_order">Purchases Order</a></li>
                            <li><a href="/purchases_delivery">Purchases Delivery</a></li>
                            <li><a href="/purchases_invoice">Purchases Invoice</a></li>
                            <li><a href="/purchases_payment">Purchases Payment</a></li>
                            <li><a href="/purchases_return">Purchases Return</a></li>
                        </ul>
                    </li>
                    @endrole
                    <!-- <li><a href="/purchases"><i class="fa fa-credit-card"></i> Purchases </a></li> -->
                    @hasrole('Owner|Ultimate|Accountant|Finance')
                    <li><a href="/expenses"><i class="fa fa-outdent"></i> Expenses </a></li>
                    @endrole
                    @hasrole('Owner|Ultimate|Production')
                    <li><a href="/spk"><i class="fa fa-times"></i> Surat Perintah Kerja </a></li>
                    <li><a href="/wip"><i class="fa fa-times"></i> Work In Progress </a></li>
                    @endrole
                </ul>
            </div>
            <div class="menu_section">
                <h3>Management</h3>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-users"></i> Contacts <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="/contacts_all">All Contact</a></li>
                            <li><a href="/contacts_customer">Contact Customer</a></li>
                            <li><a href="/contacts_vendor">Contact Vendor</a></li>
                            <li><a href="/contacts_employee">Contact Employee</a></li>
                            <li><a href="/contacts_other">Contact Other</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-dropbox"></i> Products <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="/products">Goods & Services</a></li>
                            @hasrole('Owner|Ultimate|Warehouse')
                            <li><a href="/stock_adjustment">Stock Adjustment</a></li>
                            <li><a href="/warehouses">Warehouses</a></li>
                            <li><a href="/warehouses_transfer">Warehouse Transfer List</a></li>
                            <!--<li><a>Production<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="/production_one">Station 1</a></li>
                                    <li><a href="/production_two">Station 2</a></li>
                                    <li><a href="/production_three">Station 3</a></li>
                                    <li><a href="/production_four">Station 4</a></li>
                                </ul>
                            </li>-->
                            @endrole
                        </ul>
                    </li>
                    <!--<li><a href="/products"><i class="fa fa-dropbox"></i> Products </a></li>-->
                    @hasrole('Owner|Ultimate|Accountant|Finance')
                    <li><a href="/cashbank"><i class="fa fa-bank"></i> Cash & Bank </a></li>
                    <!--<li><a href="#"><i class="fa fa-desktop"></i> Assets Management </a></li>-->
                    <li><a href="/chart_of_accounts"><i class="fa fa-book"></i> Chart of Accounts </a></li>
                    @endrole
                </ul>
            </div>
            <div class="menu_section">
                
                <h3>Setting</h3>
                <ul class="nav side-menu">
                    <!--<li><a href="#"><i class="fa fa-money"></i> Payroll </a></li>-->
                    <li><a href="/other"><i class="fa fa-tasks"></i> Other Lists </a></li>
                    @hasrole('Owner|Ultimate|Accountant')
                    <!--<li><a href="#"><i class="fa fa-qrcode"></i> Add-Ons </a></li>-->
                    <li><a href="/reports"><i class="fa fa-area-chart"></i> Reports </a></li>
                    <li><a href="/settings/company"><i class="fa fa-cog"></i> Settings </a></li>
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