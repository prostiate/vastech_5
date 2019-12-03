@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Settings</h3>
    </div>
    <!--<div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Go!</button>
                </span>
            </div>
        </div>
    </div>-->
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Other Lists</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="close-link"></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    </div>
                    <div class="clearfix"></div>
                    <!--<div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                        <a href="#">
                            <div class="well profile_view">
                                <div class="col-sm-12">
                                    <div class="left col-xs-7">
                                        <h2><strong>Tags</strong></h2>
                                        <h4>Displays the list of tags</h4>
                                    </div>
                                    <div class="right col-xs-5 text-center">
                                        <img src="/assets/img/defaultuser.png" alt="" class="img-responsive">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>-->
                    <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                        <a href="/other/transactions">
                            <div class="well profile_view">
                                <div class="col-sm-12">
                                    <div class="left col-xs-7">
                                        <h2><strong>Transactions</strong></h2>
                                        <h4>List of all transactions</h4>
                                    </div>
                                    <div class="right col-xs-5 text-center">
                                        <img src="/assets/img/altransactions3.png" alt="" class="img-responsive">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!--<div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                        <a href="#">
                            <div class="well profile_view">
                                <div class="col-sm-12">
                                    <div class="left col-xs-7">
                                        <h2><strong>Recurring Schedule List</strong></h2>
                                        <h4>List of setting a schedule for recurring transactions</h4>
                                    </div>
                                    <div class="right col-xs-5 text-center">
                                        <img src="/assets/img/defaultuser.png" alt="" class="img-responsive">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                        <a href="#"></a>
                        <div class="well profile_view">
                            <div class="col-sm-12">
                                <div class="left col-xs-7">
                                    <h2><strong>Closed Book List</strong></h2>
                                    <h4>Display list of your closed books per period, including reports per period</h4>
                                </div>
                                <div class="right col-xs-5 text-center">
                                    <img src="/assets/img/defaultuser.png" alt="" class="img-responsive">
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>-->
                    <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                        <a href="/other/product_categories">
                            <div class="well profile_view">
                                <div class="col-sm-12">
                                    <div class="left col-xs-7">
                                        <h2><strong>Product Categories</strong></h2>
                                        <h4>Display list of product categories</h4>
                                    </div>
                                    <div class="right col-xs-5 text-center">
                                        <img src="/assets/img/productcategories.png" alt="" class="img-responsive">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!--<div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                        <a href="#">
                            <div class="well profile_view">
                                <div class="col-sm-12">
                                    <div class="left col-xs-7">
                                        <h2><strong>Attachments List</strong></h2>
                                        <h4>List of all attachments associate with transactions</h4>
                                    </div>
                                    <div class="right col-xs-5 text-center">
                                        <img src="/assets/img/defaultuser.png" alt="" class="img-responsive">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>-->
                    <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                        <a href="/other/payment_methods">
                            <div class="well profile_view">
                                <div class="col-sm-12">
                                    <div class="left col-xs-7">
                                        <h2><strong>Payment Methods</strong></h2>
                                        <h4>Displays Cash, Check, and any other ways you categorize payments you receive from customer</h4>
                                    </div>
                                    <div class="right col-xs-5 text-center">
                                        <img src="/assets/img/paymentmethod.png" alt="" class="img-responsive">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                        <a href="/other/taxes">
                            <div class="well profile_view">
                                <div class="col-sm-12">
                                    <div class="left col-xs-7">
                                        <h2><strong>Taxes</strong></h2>
                                        <h4>Display the list of taxes that is used in the payments from customer or payments to vendors</h4>
                                    </div>
                                    <div class="right col-xs-5 text-center">
                                        <img src="/assets/img/taxes.png" alt="" class="img-responsive">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                        <a href="/other/units">
                            <div class="well profile_view">
                                <div class="col-sm-12">
                                    <div class="left col-xs-7">
                                        <h2><strong>Product Units</strong></h2>
                                        <h4>Display the list of product units that is used in to track SKU or standard international units for products. Eg. kg, m, cm, l, box, pcs, unit, etc</h4>
                                    </div>
                                    <div class="right col-xs-5 text-center">
                                        <img src="/assets/img/productunits.png" alt="" class="img-responsive">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                        <a href="/other/terms">
                            <div class="well profile_view">
                                <div class="col-sm-12">
                                    <div class="left col-xs-7">
                                        <h2><strong>Terms</strong></h2>
                                        <h4>Displays the list of terms that determine the due date of payments from customer or payments to vendors. From here you, can add or edit terms</h4>
                                    </div>
                                    <div class="right col-xs-5 text-center">
                                        <img src="/assets/img/terms.png" alt="" class="img-responsive">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!--<div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                        <a href="#">
                            <div class="well profile_view">
                                <div class="col-sm-12">
                                    <div class="left col-xs-7">
                                        <h2><strong>Audits List</strong></h2>
                                        <h4>List of changes that have been made</h4>
                                    </div>
                                    <div class="right col-xs-5 text-center">
                                        <img src="/assets/img/defaultuser.png" alt="" class="img-responsive">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                        <a href="#">
                            <div class="well profile_view">
                                <div class="col-sm-12">
                                    <div class="left col-xs-7">
                                        <h2><strong>Export & Import List</strong></h2>
                                        <h4>Display list of import and export history in Jurnal. You can see status and data from each import & export, and delete data per import</h4>
                                    </div>
                                    <div class="right col-xs-5 text-center">
                                        <img src="/assets/img/defaultuser.png" alt="" class="img-responsive">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@endpush