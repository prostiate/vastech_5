@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '#';" data-toggle="modal" data-target=".bs-example-modal-lg">History
                        </button>
                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                        </button>
                                        <h5 class="modal-title" id="myModalLabel">History</h5>
                                        <h3 class="modal-title" id="myModalLabel"><strong>Surat Perintah Kerja #{{$spk->number}}</strong></h3>
                                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Work In Progress History</a>
                                            </li>
                                            <li role="presentation" class=""><a href="#tab_content2" id="sales-tab" role="tab" data-toggle="tab" aria-expanded="true">Sales Invoice History</a>
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
                                                                    <th class="column-title">Production Date</th>
                                                                    <th class="column-title">Transaction Number</th>
                                                                    <th class="column-title">Production Name</th>
                                                                    <th class="column-title">Total</th>
                                                                    <th class="column-title">Created Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($wip_item as $wi)
                                                                @if($wi->wip->selected_spk_id == $spk->id)
                                                                <tr>
                                                                    <td>
                                                                        {{$wi->wip->transaction_date}}
                                                                    </td>
                                                                    <td>
                                                                        <a href="/wip/{{$wi->wip->id}}">Work In Progress #{{$wi->wip->number}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="/products/{{$wi->wip->result_product}}">{{$wi->wip->product->name}}</a>
                                                                    </td>
                                                                    <td>
                                                                        {{$wi->wip->result_qty}}
                                                                    </td>
                                                                    <td>
                                                                        {{$wi->wip->updated_at}} ({{$wi->wip->user->name}})
                                                                    </td>
                                                                </tr>
                                                                @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="sales-tab">
                                                    <div class="table-responsive my-5">
                                                        <table id="example" class="table table-striped jambo_table bulk_action">
                                                            <thead>
                                                                <tr class="headings">
                                                                    <th class="column-title">Transaction Date</th>
                                                                    <th class="column-title">Transaction Number</th>
                                                                    <th class="column-title">Due Date</th>
                                                                    <th class="column-title">Fabrication Only</th>
                                                                    <th class="column-title">Grand Total</th>
                                                                    <th class="column-title">Status</th>
                                                                    <th class="column-title">Created Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($sii as $sii)
                                                                @if($sii->sale_invoice->selected_spk_id == $spk->id)
                                                                <tr>
                                                                    <td>
                                                                        {{$sii->sale_invoice->transaction_date}}
                                                                    </td>
                                                                    <td>
                                                                        <a href="/sales_invoice/{{$sii->sale_invoice->id}}">Sales Invoice #{{$sii->sale_invoice->number}}</a>
                                                                    </td>
                                                                    <td>
                                                                        {{$sii->sale_invoice->due_date}}
                                                                    </td>
                                                                    <td>
                                                                        @if($sii->sale_invoice->jasa_only == 1) Yes @else No @endif
                                                                    </td>
                                                                    <td>
                                                                        Rp {{number_format($sii->sale_invoice->grandtotal, 2, ',','.')}}
                                                                    </td>
                                                                    <td>
                                                                        {{$sii->sale_invoice->status_sales->name}}
                                                                    </td>
                                                                    <td>
                                                                        {{$sii->sale_invoice->updated_at}} ({{$sii->sale_invoice->user->name}})
                                                                    </td>
                                                                </tr>
                                                                @endif
                                                                @endforeach
                                                            </tbody>
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
                    <li>
                        <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false">Actions
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            @hasrole('Owner|Ultimate|Production')
                            @can('Create')
                            @if($can >= 1)
                            @hasrole('Owner|Ultimate|Sales Invoice')
                            <li><a href="/sales_invoice/new/fromSPK/{{$spk->id}}">Create Invoice</a></li>
                            @endrole
                            <li class="divider"></li>
                            @endif
                            @endcan
                            @endrole
                            <li><a target="_blank" href="/spk/print/PDF/{{$spk->id}}">Print & Preview</a></li>
                        </ul>
                    </li>
                </ul>
                <h3><b>Surat Perintah Kerja #{{$spk->number}}</b></h3>
                <a>Status: </a>
                @if($spk->status == 1)
                <span class="label label-warning" style="color:white;">Open</span>
                @elseif($spk->status == 2)
                <span class="label label-success" style="color:white;">Closed</span>
                @elseif($spk->status == 3)
                <span class="label label-success" style="color:white;">Paid</span>
                @elseif($spk->status == 4)
                <span class="label label-warning" style="color:white;">Partial</span>
                @elseif($spk->status == 5)
                <span class="label label-danger" style="color:white;">Overdue</span>
                @else
                <span class="label label-success" style="color:white;">Sent</span>
                @endif
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Transaction No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$spk->number}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Transaction Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$spk->transaction_date}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Contact</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/contacts/{{$spk->contact_id}}">{{$spk->contact->display_name}}</a></h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Warehouse</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/warehouses/{{$spk->warehouse_id}}">{{$spk->warehouse->name}}</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">SPK Ref No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$spk->vendor_ref_no}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">Note</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$spk->desc}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group tiles"></div>
                    <br>
                    <div class="table-responsive my-5">
                        <table id="example" class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title" style="width: 400px">Product Name</th>
                                    <th class="column-title">Quantity Ready</th>
                                    <th class="column-title">Requirement Quantity</th>
                                    <th class="column-title">Quantity Remaining</th>
                                    <th class="column-title">Status</th>
                                    <th class="column-title text-center" style="width: 200px">Action</th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                <?php $qty = 0 ?>
                                @foreach($spk_item as $si)
                                <tr>
                                    <td>
                                        <a href="/products/{{$si->product_id}}">{{$si->product->name}}</a>
                                    </td>
                                    <td>
                                        @foreach($quantity_in_stock as $qis)
                                        @if($qis->product_id == $si->product_id)
                                        <?php $qty += $qis->qty_in - $qis->qty_out ?>
                                        @endif
                                        @endforeach
                                        <a>{{$qty}}</a>
                                        <?php $qty = 0 ?>
                                    </td>
                                    <td>
                                        <a>{{$si->qty}}</a>
                                    </td>
                                    <td>
                                        <a>{{$si->qty_remaining}}</a>
                                    </td>
                                    <td>
                                        <a>{{$si->spk_item_status->name}}</a>
                                    </td>
                                    @hasrole('Owner|Ultimate|Production')
                                    @can('Create')
                                    <td class="text-center">
                                        <a href="/wip/new/fromSPK/{{$spk->id}}_{{$si->id}}" class="btn btn-dark">Create WIP</a>
                                    </td>
                                    @endcan
                                    @else
                                    <td></td>
                                    @endrole
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="col-md-3 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/spk') }}" class="btn btn-dark">Cancel</a>
                            @hasrole('Owner|Ultimate|Production')
                            @if($statusajah == 0)
                            @if($spk->status == 2)
                            <!-- header close-->
                            @can('Delete')
                            <button type="button" class="btn btn-danger" id="click">Delete</button>
                            @endcan
                            @can('Edit')
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success" onclick="window.location.href = '/spk/edit/{{$spk->id}}';">Edit</button>
                            </div>
                            @endcan
                            <input type="text" value="{{$spk->id}}" id="form_id" hidden>
                            @endif
                            @endif
                            @endrole
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/request/sukses/spk/deleteForm.js') }}" charset="utf-8"></script>
@endpush