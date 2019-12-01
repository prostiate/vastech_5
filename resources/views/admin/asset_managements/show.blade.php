@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <form method="post" id="formCreate" class="form-horizontal">
                <div class="x_title">
                    <h2>Asset Detail</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '#';" data-toggle="modal" data-target=".bs-example-modal-lg">Transaction History
                            </button>
                            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                            </button>
                                            <h5 class="modal-title" id="myModalLabel">Transaction History</h5>
                                            <h3 class="modal-title" id="myModalLabel"><strong></strong></h3>
                                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Transaction History</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="modal-body">
                                            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                                <div id="myTabContent" class="tab-content">
                                                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                                        <div class="table-responsive my-5">
                                                            <table id="example" class="table table-striped jambo_table bulk_action">
                                                                <thead>
                                                                    <tr class="headings">
                                                                        <th class="column-title" style="width:250px">Transaction Number</th>
                                                                        <th class="column-title" style="width:200px">Transaction Date</th>
                                                                        <th class="column-title" style="width:150px">Action</th>
                                                                        <th class="column-title" style="width:150px">Account</th>
                                                                        <th class="column-title text-right" style="width:150px">Debit</th>
                                                                        <th class="column-title text-right" style="width:150px">Credit</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Asset Name</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$assets->name}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Acquisition Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$assets->date}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Asset Number</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$assets->number}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Acquisition Cost</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>Rp @number($assets->cost)</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Fixed Asset Number</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$assets->coa->name}}</h5>
                                </div>
                            </div>
                            @if($detail)
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Remaining Useful Life</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$detail->life}}</h5>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Description</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($detail)
                <div class="clearfix"></div>
                <div class="x_title">
                    <h2>Depreciation</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Method</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$detail->method}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Depreciation Account</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$detail->coa_depreciate_account->name}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Rate / Year</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$detail->rate}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Accumulated Depreciation</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$detail->depreciate_accumulated}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">As at Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$detail->date}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <br>
                    <div class="col-md-3 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/asset_managements') }}" class="btn btn-danger">Cancel</a>
                            <div class="btn-group">
                                <button type="button" class="btn btn-success" onclick="window.location.href = '/asset_managements/edit/{{$assets->id}}';">Edit</button>
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="/asset_managements/edit/">Edit</a>
                                    </li>
                                    <li><a href="/asset_managements/dispose">Sell/Dispose</a>
                                    </li>
                                    <li><a href="#">Delete</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection