@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <!--<ul class="nav navbar-right panel_toolbox">
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
                                                                    <th class="column-title" style="width:250px">
                                                                        Transaction Number</th>
                                                                    <th class="column-title" style="width:200px">
                                                                        Transaction Date</th>
                                                                    <th class="column-title" style="width:150px">
                                                                        Action</th>
                                                                    <th class="column-title" style="width:150px">
                                                                        Account</th>
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
                </ul>-->
                <h3><b>Asset #{{$assets->number}}</b></h3>
                <a>Status: </a>
                @if($assets->status == 1)
                <span class="label label-warning" style="color:white;">Open</span>
                @elseif($assets->status == 2)
                <span class="label label-success" style="color:white;">Closed</span>
                @elseif($assets->status == 3)
                <span class="label label-success" style="color:white;">Paid</span>
                @elseif($assets->status == 4)
                <span class="label label-warning" style="color:white;">Partial</span>
                @elseif($assets->status == 5)
                <span class="label label-danger" style="color:white;">Overdue</span>
                @elseif($assets->status == 6)
                <span class="label label-success" style="color:white;">Sent</span>
                @elseif($assets->status == 7)
                <span class="label label-success" style="color:white;">Active</span>
                @elseif($assets->status == 8)
                <span class="label label-success" style="color:white;">Sold</span>
                @elseif($assets->status == 9)
                <span class="label label-success" style="color:white;">Disposed</span>
                @endif
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <div class="form-group">
                    <div class="form-horizontal form-label-left">
                        <div class="col-md-6">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Asset
                                Name</label>
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
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Asset
                                Number</label>
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <h5>{{$assets->number}}</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Acquisition Cost</label>
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <h5><?php echo 'Rp ' . number_format($assets->cost, 2, ',', '.') ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-horizontal form-label-left">
                        <div class="col-md-6">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Fixed
                                Asset Number</label>
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <h5><a href="/chart_of_accounts/{{$assets->asset_account}}">{{$assets->coa->name}}</a></h5>
                            </div>
                        </div>
                        @if($details)
                        <div class="col-md-6">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Remaining Useful Life</label>
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <h5>{{$details->life}}</h5>
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
        </div>
        @if($details)
        <div class="x_panel">
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
                                <h5>@if($details->method == 'straight') Straight Line @else Reducing Balance @endif</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Depreciation Account</label>
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <h5><a href="/chart_of_accounts/{{$details->depreciate_account}}">{{$details->coa_depreciate_account->name}}</a></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-horizontal form-label-left">
                        <div class="col-md-6">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Rate / Year</label>
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <h5>{{$details->rate}}</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Accumulated Depreciation</label>
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <h5><?php echo 'Rp ' . number_format($details->depreciate_accumulated, 2, ',', '.') ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-horizontal form-label-left">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">As at
                                Date</label>
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <h5>{{$details->date}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="x_panel">
            <div class="x_title">
                <h2> Transaction History </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x-content">
                <table id="example" class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th class="column-title">Date</th>
                            <th class="column-title">Action </th>
                            <th class="column-title">Transaction No. </th>
                            <th class="column-title">Account</th>
                            <th class="column-title">Debit </th>
                            <th class="column-title">Credit </th>
                        </tr>
                    </thead>
                    <tbody class="neworderbody">
                        @foreach ($journals as $i => $journal)
                        <tr>
                            <td>
                                <a>{{$journal->transaction_date}}</a>
                            </td>
                            <td>
                                <a>Created</a>
                            </td>
                            <td>
                                <a>{{$journal->number}}</a>
                            </td>
                            <td>
                                <a href="/chart_of_accounts/{{$details->depreciate_account}}">{{$details->asset->coa->name}}</a>
                            </td>
                            @if ($loop->first)
                            <td>
                                <a><?php echo 'Rp ' . number_format($journal->journal_entry_item[0]->debit, 2, ',', '.') ?></a>
                            </td>
                            <td>
                                <a><?php echo 'Rp ' . number_format($journal->journal_entry_item[0]->credit, 2, ',', '.') ?></a>
                            </td>
                            @else
                            <td>
                                <a><?php echo 'Rp ' . number_format($journal->journal_entry_item[1]->debit, 2, ',', '.') ?></a>
                            </td>
                            <td>
                                <a><?php echo 'Rp ' . number_format($journal->journal_entry_item[1]->credit, 2, ',', '.') ?></a>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        <br>
    </div>
    <div class="col-md-2 center-margin">
        <div class="form-group">
            <a href="{{ url('/asset_managements') }}" class="btn btn-danger">Cancel</a>
            <div class="btn-group">
                <button type="button" class="btn btn-success" onclick="window.location.href = '/asset_managements/edit/{{$assets->id}}';">Edit</button>
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <!--<li><a href="/asset_managements/dispose/{{$assets->id}}">Sell/Dispose</a></li>-->
                    @if(Auth::user()->company_id == 5)
                    @if(Auth::user()->id == 999999)
                    <li><a href="#" id="click">Delete</a>
                        <input type="text" value="{{$assets->id}}" id="form_id" hidden>
                    </li>
                    @endif
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/asset_management/dataTable.js?v=5-20200319-0916') }}" charset="utf-8"></script>
@endpush