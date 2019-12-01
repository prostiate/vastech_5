@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Contacts</h3>
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
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right">
            <div class="x_content">
                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">Create New Sales <span class="caret"></span>
                </button>
                <ul role="menu" class="dropdown-menu">
                    <li><a href="#">Action</a>
                    </li>
                    <li><a href="#">Another action</a>
                    </li>
                    <li><a href="#">Something else here</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
            <div class="count">179</div>
            <span class="sparkline11 graph" style="height: 160px;"><canvas width="198" height="40" style="display: inline-block; width: 198px; height: 40px; vertical-align: top;"></canvas></span>
        </div>
    </div>
    <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
            <div class="count">179</div>
            <span class="sparkline11 graph" style="height: 160px;"><canvas width="198" height="40" style="display: inline-block; width: 198px; height: 40px; vertical-align: top;"></canvas></span>
        </div>
    </div>
    <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
            <div class="count">179</div>
            <span class="sparkline11 graph" style="height: 160px;"><canvas width="198" height="40" style="display: inline-block; width: 198px; height: 40px; vertical-align: top;"></canvas></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Contact List</h2>
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
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" role="tab" id="invoice-tab" data-toggle="tab" aria-expanded="true">Sales Invoice</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="delivery-tab" data-toggle="tab" aria-expanded="false">Sales Delivery</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="order-tab2" data-toggle="tab" aria-expanded="false">Sales Order</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content4" role="tab" id="quote-tab2" data-toggle="tab" aria-expanded="false">Sales Quote</a>
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="invoice-tab">
                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                        <tr class="headings">
                                            <th>
                                                <input type="checkbox" id="check-all" class="flat">
                                            </th>
                                            <th class="column-title">Number </th>
                                            <th class="column-title">Date </th>
                                            <th class="column-title">Customer </th>
                                            <th class="column-title">Due Date </th>
                                            <th class="column-title">Balance Due </th>
                                            <th class="column-title">Total </th>
                                            <th class="column-title">Status </th>
                                            <th class="column-title no-link last"><span class="nobr">Action</span>
                                            </th>
                                            <th class="bulk-actions" colspan="7">
                                                <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="even pointer">
                                            <td class="a-center ">
                                                <input type="checkbox" class="flat" name="table_records">
                                            </td>
                                            <td class=" ">121000040</td>
                                            <td class=" ">May 23, 2014</td>
                                            <td class=" ">John Blank L</td>
                                            <td class=" ">May 24, 2014</td>
                                            <td class="a-right a-right ">$7.45</td>
                                            <td class="a-right a-right ">$7.45</td>
                                            <td class=" ">Paid</td>
                                            <td class=" last"><a href="#">View</a>
                                            </td>
                                        </tr>
                                        <tr class="odd pointer">
                                            <td class="a-center ">
                                                <input type="checkbox" class="flat" name="table_records">
                                            </td>
                                            <td class=" ">121000039</td>
                                            <td class=" ">May 23, 2014</td>
                                            <td class=" ">John Blank L</td>
                                            <td class=" ">May 24, 2014</td>
                                            <td class="a-right a-right ">$7.45</td>
                                            <td class="a-right a-right ">$741.20</td>
                                            <td class=" ">Paid</td>
                                            <td class=" last"><a href="#">View</a>
                                            </td>
                                        </tr>
                                        <tr class="even pointer">
                                            <td class="a-center ">
                                                <input type="checkbox" class="flat" name="table_records">
                                            </td>
                                            <td class=" ">121000038</td>
                                            <td class=" ">May 24, 2014</td>
                                            <td class=" ">Mike Smith</td>
                                            <td class=" ">May 24, 2014</td>
                                            <td class="a-right a-right ">$7.45</td>
                                            <td class="a-right a-right ">$432.26</td>
                                            <td class=" ">Paid</td>
                                            <td class=" last"><a href="#">View</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="delivery-tab">
                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                        <tr class="headings">
                                            <th>
                                                <input type="checkbox" id="check-all" class="flat">
                                            </th>
                                            <th class="column-title">Invoice </th>
                                            <th class="column-title">Invoice Date </th>
                                            <th class="column-title">Order </th>
                                            <th class="column-title">Bill to Name </th>
                                            <th class="column-title">Status </th>
                                            <th class="column-title">Amount </th>
                                            <th class="column-title no-link last"><span class="nobr">Action</span>
                                            </th>
                                            <th class="bulk-actions" colspan="7">
                                                <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="even pointer">
                                            <td class="a-center ">
                                                <input type="checkbox" class="flat" name="table_records">
                                            </td>
                                            <td class=" ">121000040</td>
                                            <td class=" ">May 23, 2014 11:47:56 PM </td>
                                            <td class=" ">121000210 <i class="success fa fa-long-arrow-up"></i></td>
                                            <td class=" ">John Blank L</td>
                                            <td class=" ">Paid</td>
                                            <td class="a-right a-right ">$7.45</td>
                                            <td class=" last"><a href="#">View</a>
                                            </td>
                                        </tr>
                                        <tr class="odd pointer">
                                            <td class="a-center ">
                                                <input type="checkbox" class="flat" name="table_records">
                                            </td>
                                            <td class=" ">121000039</td>
                                            <td class=" ">May 23, 2014 11:30:12 PM</td>
                                            <td class=" ">121000208 <i class="success fa fa-long-arrow-up"></i>
                                            </td>
                                            <td class=" ">John Blank L</td>
                                            <td class=" ">Paid</td>
                                            <td class="a-right a-right ">$741.20</td>
                                            <td class=" last"><a href="#">View</a>
                                            </td>
                                        </tr>
                                        <tr class="even pointer">
                                            <td class="a-center ">
                                                <input type="checkbox" class="flat" name="table_records">
                                            </td>
                                            <td class=" ">121000038</td>
                                            <td class=" ">May 24, 2014 10:55:33 PM</td>
                                            <td class=" ">121000203 <i class="success fa fa-long-arrow-up"></i>
                                            </td>
                                            <td class=" ">Mike Smith</td>
                                            <td class=" ">Paid</td>
                                            <td class="a-right a-right ">$432.26</td>
                                            <td class=" last"><a href="#">View</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="order-tab">
                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                        <tr class="headings">
                                            <th>
                                                <input type="checkbox" id="check-all" class="flat">
                                            </th>
                                            <th class="column-title">Invoice </th>
                                            <th class="column-title">Invoice Date </th>
                                            <th class="column-title">Order </th>
                                            <th class="column-title">Bill to Name </th>
                                            <th class="column-title">Status </th>
                                            <th class="column-title">Amount </th>
                                            <th class="column-title no-link last"><span class="nobr">Action</span>
                                            </th>
                                            <th class="bulk-actions" colspan="7">
                                                <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="even pointer">
                                            <td class="a-center ">
                                                <input type="checkbox" class="flat" name="table_records">
                                            </td>
                                            <td class=" ">121000040</td>
                                            <td class=" ">May 23, 2014 11:47:56 PM </td>
                                            <td class=" ">121000210 <i class="success fa fa-long-arrow-up"></i></td>
                                            <td class=" ">John Blank L</td>
                                            <td class=" ">Paid</td>
                                            <td class="a-right a-right ">$7.45</td>
                                            <td class=" last"><a href="#">View</a>
                                            </td>
                                        </tr>
                                        <tr class="odd pointer">
                                            <td class="a-center ">
                                                <input type="checkbox" class="flat" name="table_records">
                                            </td>
                                            <td class=" ">121000039</td>
                                            <td class=" ">May 23, 2014 11:30:12 PM</td>
                                            <td class=" ">121000208 <i class="success fa fa-long-arrow-up"></i>
                                            </td>
                                            <td class=" ">John Blank L</td>
                                            <td class=" ">Paid</td>
                                            <td class="a-right a-right ">$741.20</td>
                                            <td class=" last"><a href="#">View</a>
                                            </td>
                                        </tr>
                                        <tr class="even pointer">
                                            <td class="a-center ">
                                                <input type="checkbox" class="flat" name="table_records">
                                            </td>
                                            <td class=" ">121000038</td>
                                            <td class=" ">May 24, 2014 10:55:33 PM</td>
                                            <td class=" ">121000203 <i class="success fa fa-long-arrow-up"></i>
                                            </td>
                                            <td class=" ">Mike Smith</td>
                                            <td class=" ">Paid</td>
                                            <td class="a-right a-right ">$432.26</td>
                                            <td class=" last"><a href="#">View</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="quote-tab">
                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                        <tr class="headings">
                                            <th>
                                                <input type="checkbox" id="check-all" class="flat">
                                            </th>
                                            <th class="column-title">Invoice </th>
                                            <th class="column-title">Invoice Date </th>
                                            <th class="column-title">Order </th>
                                            <th class="column-title">Bill to Name </th>
                                            <th class="column-title">Status </th>
                                            <th class="column-title">Amount </th>
                                            <th class="column-title no-link last"><span class="nobr">Action</span>
                                            </th>
                                            <th class="bulk-actions" colspan="7">
                                                <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="even pointer">
                                            <td class="a-center ">
                                                <input type="checkbox" class="flat" name="table_records">
                                            </td>
                                            <td class=" ">121000040</td>
                                            <td class=" ">May 23, 2014 11:47:56 PM </td>
                                            <td class=" ">121000210 <i class="success fa fa-long-arrow-up"></i></td>
                                            <td class=" ">John Blank L</td>
                                            <td class=" ">Paid</td>
                                            <td class="a-right a-right ">$7.45</td>
                                            <td class=" last"><a href="#">View</a>
                                            </td>
                                        </tr>
                                        <tr class="odd pointer">
                                            <td class="a-center ">
                                                <input type="checkbox" class="flat" name="table_records">
                                            </td>
                                            <td class=" ">121000039</td>
                                            <td class=" ">May 23, 2014 11:30:12 PM</td>
                                            <td class=" ">121000208 <i class="success fa fa-long-arrow-up"></i>
                                            </td>
                                            <td class=" ">John Blank L</td>
                                            <td class=" ">Paid</td>
                                            <td class="a-right a-right ">$741.20</td>
                                            <td class=" last"><a href="#">View</a>
                                            </td>
                                        </tr>
                                        <tr class="even pointer">
                                            <td class="a-center ">
                                                <input type="checkbox" class="flat" name="table_records">
                                            </td>
                                            <td class=" ">121000038</td>
                                            <td class=" ">May 24, 2014 10:55:33 PM</td>
                                            <td class=" ">121000203 <i class="success fa fa-long-arrow-up"></i>
                                            </td>
                                            <td class=" ">Mike Smith</td>
                                            <td class=" ">Paid</td>
                                            <td class="a-right a-right ">$432.26</td>
                                            <td class=" last"><a href="#">View</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- <script>
    $('#myTab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });

    $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
        var id = $(e.target).attr("href").substr(1);
        window.location.hash = id;
    });

    var hash = window.location.hash;
    $('#myTab a[href="' + hash + '"]').tab('show');
</script> -->
@endpush