@extends('layouts/admin')

@section('contentheader')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Surat Perintah Kerja Details</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link">Start Date </a></li>
                    <li><input value="{{$today}}" type="date" id="datepicker1" class="form-control"></li>
                    <li><a class="collapse-link">End Date </a></li>
                    <li><input value="{{$today}}" type="date" id="datepicker2" class="form-control"></li>
                    <li>
                        <button type="button" id="click" class="btn btn-dark" onclick="next()">Filter</button>
                    </li>
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '#';" data-toggle="modal" data-target=".bs-example-modal-lg">More Filter
                        </button>
                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <form method="post" id="formCreate">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                            </button>
                                            <h3 class="modal-title" id="myModalLabel"><strong>Reports Filter</strong></h3>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-md-12">
                                                <div class="form-horizontal form-label-left">
                                                    <div class="form-group row">
                                                        <label>Start Date</label>
                                                        <input value="{{$today}}" type="date" id="datepicker3" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-horizontal form-label-left">
                                                    <div class="form-group row">
                                                        <label>End Date</label>
                                                        <input value="{{$today}}" type="date" id="datepicker4" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--{{--
                                            <div class="col-md-12">
                                                <div class="form-horizontal form-label-left">
                                                    <div class="form-group row">
                                                        <label>Filter by Period</label>
                                                        <select name="type_limit_balance" class="form-control selectbankname">
                                                            <option value="custom" selected>Custom</option>
                                                            <option value="today">Today</option>
                                                            <option value="this_week">This Week</option>
                                                            <option value="this_month">This Month</option>
                                                            <option value="this_year">This Year</option>
                                                            <option value="yesterday">Yesterday</option>
                                                            <option value="last_week">Last Week</option>
                                                            <option value="last_month">Last Month</option>
                                                            <option value="last_year">Last Year</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            --}}-->
                                            <div class="col-md-12">
                                                <div class="form-horizontal form-label-left">
                                                    <div class="form-group row">
                                                        <label>Filter by Products</label>
                                                        <select name="products" id="products" class="form-control selectaccount select_product" multiple>
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-horizontal form-label-left">
                                                    <div class="form-group row">
                                                        <label>Filter by Warehouses</label>
                                                        <select name="warehouses" id="warehouses" class="form-control selectaccount" multiple>
                                                            <option></option>
                                                            @foreach($warehouses as $a)
                                                            <option value="{{$a->id}}">{{$a->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="col-md-1 center-margin">
                                                <div class="form-horizontal">
                                                    <div class="form-group row">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                            <button type="button" id="click" class="btn btn-dark" onclick="nextMoreFilter()">Filter</button>
                                            <input type="text" name="hidden_id" id="hidden_id" hidden>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </li>
                    <li>
                        <button data-toggle="dropdown" class="btn btn-dark mr-5 dropdown-toggle" type="button" aria-expanded="false">Export
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a onclick="excel()">Excel</a>
                            </li>
                            <li><a onclick="csv()">CSV</a>
                            </li>
                            <li><a onclick="pdf()">PDF</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="col-12 table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr class="btn-dark">
                                                <th style="width:100px;">Date</th>
                                                <th class="text-left" style="width:200px;">Transaction Number</th>
                                                <th class="text-left" style="width:200px;">Memo</th>
                                                <th class="text-left" style="width:200px;">Customer</th>
                                                <th class="text-left" style="width:200px;">Warehouse</th>
                                                <th class="text-left" style="width:100px;">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($spk as $ot)
                                            <tr>
                                                <td>{{$ot->transaction_date}}</td>
                                                <td><a href="/spk/{{$ot->id}}">Surat Perintah Kerja #{{$ot->number}}</a></td>
                                                <td><a href="/spk/{{$ot->id}}">{{$ot->memo}}</a></td>
                                                <td><a href="/spk/{{$ot->id}}">{{$ot->contact->display_name}}</a></td>
                                                <td><a href="/spk/{{$ot->id}}">{{$ot->warehouse->name}}</a></td>
                                                <td><a href="/spk/{{$ot->id}}">{{$ot->spk_status->name}}</a></td>
                                            </tr>
                                            <thead>
                                                <tr>
                                                    <th style="width:100px;"></th>
                                                    <th class="text-left" style="width:300px;">Product</th>
                                                    <th class="text-left" style="width:200px;">Requirement Quantity</th>
                                                    <th class="text-left" style="width:200px;">Quantity Remaining</th>
                                                    <th class="text-left" style="width:100px;">Status</th>
                                                    <th class="text-left" style="width:100px;"></th>
                                                </tr>
                                            </thead>
                                        <tbody>
                                            @foreach($ot->spk_item as $otsi)
                                            <tr>
                                                <td></td>
                                                <td> <a href="/products/{{$otsi->product_id}}">{{$otsi->product->name}}</a></td>
                                                <td>{{$otsi->qty}}</td>
                                                <td>{{$otsi->qty_remaining}}</td>
                                                <td>{{$otsi->spk_item_status->name}}</td>
                                                <td></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        @endforeach
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
</div>


@endsection

@push('scripts')
<script src="{{ asset('js/other/zebradatepicker.js?v=5-20200221-1431') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200221-1431') }}" charset="utf-8"></script>
<script>
    function selectProduct() {
        $(".select_product").select2({
            placeholder: "Select Product",
            width: "100%",
            //minimumInputLength: 1,
            delay: 250,
            allowClear: true,
            ajax: {
                url: "/reports/select_product",
                dataType: "json",
                data: function(params) {
                    return {
                        term: params.term || "",
                        page: params.page || 1
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.results,
                        pagination: {
                            more: params.page * 10 < data.total_count
                        }
                    };
                },
                cache: true
            },
            templateResult: formatResult,
            templateSelection: formatRepoSelection
        });

        function formatRepoSelection(repo) {
            if (repo.code) {
                return (
                    repo.code + " - " + repo.text || repo.code + " - " + repo.text
                );
            } else {
                return (
                    repo.text || repo.text
                );
            }
        }

        function formatResult(result) {
            //console.log('%o', result);
            if (result.loading) return result.text;
            if (result.code) {
                var html = "<a>" + result.code + " - " + result.text + "</a>";

            } else {
                var html = "<a>" + result.text + "</a>";

            }
            //return html;
            return $(html);
        }
    }

    $(document).ready(function() {
        selectProduct();
    });

    function next() {
        var date1 = document.getElementById('datepicker1');
        var date2 = document.getElementById('datepicker2');
        var products = $('#products').val();
        var warehouses = $('#warehouses').val();
        window.location.href = "/reports/spk_details/start_date=" + date1.value + '&end_date=' + date2.value + '&products=' + products + '&warehouses=' + warehouses;
    }

    function nextMoreFilter() {
        var date3 = document.getElementById('datepicker3');
        var date4 = document.getElementById('datepicker4');
        var products = $('#products').val();
        var warehouses = $('#warehouses').val();
        window.location.href = "/reports/spk_details/start_date=" + date3.value + '&end_date=' + date4.value + '&products=' + products + '&warehouses=' + warehouses;
    }

    function excel() {
        var date1 = document.getElementById('datepicker1');
        var date2 = document.getElementById('datepicker2');
        var products = $('#products').val();
        var warehouses = $('#warehouses').val();
        window.location.href = "/reports/spk_details/excel/start_date=" + date1.value + '&end_date=' + date2.value + '&products=' + products + '&warehouses=' + warehouses;
    }

    function csv() {
        var date1 = document.getElementById('datepicker1');
        var date2 = document.getElementById('datepicker2');
        var products = $('#products').val();
        var warehouses = $('#warehouses').val();
        window.location.href = "/reports/spk_details/csv/start_date=" + date1.value + '&end_date=' + date2.value + '&products=' + products + '&warehouses=' + warehouses;
    }

    function pdf() {
        var date1 = document.getElementById('datepicker1');
        var date2 = document.getElementById('datepicker2');
        var products = $('#products').val();
        var warehouses = $('#warehouses').val();
        window.location.href = "/reports/spk_details/pdf/start_date=" + date1.value + '&end_date=' + date2.value + '&products=' + products + '&warehouses=' + warehouses;
    }
</script>
@endpush