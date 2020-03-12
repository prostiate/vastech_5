@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '#';" data-toggle="modal" data-target=".bs-example-modal-lg">@lang("spk.show.history")
                        </button>
                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                        </button>
                                        <h5 class="modal-title" id="myModalLabel">@lang("spk.show.history")</h5>
                                        <h3 class="modal-title" id="myModalLabel"><strong>@lang("spk.show.title"){{$spk->number}}</strong></h3>
                                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">@lang("spk.show.wip_history")</a>
                                            </li>
                                            <li role="presentation" class=""><a href="#tab_content2" id="sales-tab" role="tab" data-toggle="tab" aria-expanded="true">@lang("spk.show.si_history")</a>
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
                                                                    <th class="column-title">@lang("spk.show.table_2.col_1")</th>
                                                                    <th class="column-title">@lang("spk.show.table_2.col_2")</th>
                                                                    <th class="column-title">@lang("spk.show.table_2.col_3")</th>
                                                                    <th class="column-title">@lang("spk.show.table_2.col_4")</th>
                                                                    <th class="column-title">@lang("spk.show.table_2.col_5")</th>
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
                                                                    <th class="column-title">@lang("spk.show.table_3.col_1")</th>
                                                                    <th class="column-title">@lang("spk.show.table_3.col_2")</th>
                                                                    <th class="column-title">@lang("spk.show.table_3.col_3")</th>
                                                                    <th class="column-title">@lang("spk.show.table_3.col_4")</th>
                                                                    <th class="column-title">@lang("spk.show.table_3.col_5")</th>
                                                                    <th class="column-title">@lang("spk.show.table_3.col_6")</th>
                                                                    <th class="column-title">@lang("spk.show.table_3.col_7")</th>
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
                                        <button type="button" class="btn btn-dark" data-dismiss="modal">@lang("spk.show.close")</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false">@lang("spk.show.action.action")
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            @hasrole('Owner|Ultimate|Production')
                            @can('Create')
                            @if($can >= 1)
                            @if($spk->user->company_id == 2)
                            @hasrole('Owner|Ultimate|Sales Invoice')
                            <li><a href="/sales_invoice/new/fromSPK/{{$spk->id}}">@lang("spk.show.action.action_1")</a></li>
                            @endrole
                            <li class="divider"></li>
                            @endif
                            @endif
                            @endcan
                            @endrole
                            <li><a target="_blank" href="/spk/print/PDF/{{$spk->id}}">@lang("spk.show.action.action_2")</a></li>
                        </ul>
                    </li>
                </ul>
                <h3><b>@lang("spk.show.title"){{$spk->number}}</b></h3>
                <a>Status: </a>
                @if($spk->status == 1)
                <span class="label label-warning" style="color:white;">@lang("status.open")</span>
                @elseif($spk->status == 2)
                <span class="label label-success" style="color:white;">@lang("status.closed")</span>
                @elseif($spk->status == 3)
                <span class="label label-success" style="color:white;">@lang("status.paid")</span>
                @elseif($spk->status == 4)
                <span class="label label-warning" style="color:white;">@lang("status.part")</span>
                @elseif($spk->status == 5)
                <span class="label label-danger" style="color:white;">@lang("status.over")</span>
                @elseif($spk->status == 6)
                <span class="label label-success" style="color:white;">@lang("status.sent")</span>
                @elseif($spk->status == 7)
                <span class="label label-success" style="color:white;">@lang("status.act")</span>
                @elseif($spk->status == 8)
                <span class="label label-success" style="color:white;">@lang("status.sold")</span>
                @elseif($spk->status == 9)
                <span class="label label-success" style="color:white;">@lang("status.dis")</span>
                @endif
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang("spk.show.trans_no")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$spk->number}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang("spk.show.trans_date")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$spk->transaction_date}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang("spk.show.contact")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/contacts/{{$spk->contact_id}}">{{$spk->contact->display_name}}</a></h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang("spk.show.warehouse")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/warehouses/{{$spk->warehouse_id}}">{{$spk->warehouse->name}}</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang("spk.show.ref_no")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$spk->vendor_ref_no}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">@lang("spk.show.note")</label>
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
                                    <th class="column-title" style="width: 400px">@lang("spk.show.table.col_1")</th>
                                    <th class="column-title">@lang("spk.show.table.col_2")</th>
                                    <th class="column-title">@lang("spk.show.table.col_3")</th>
                                    <th class="column-title">@lang("spk.show.table.col_4")</th>
                                    <th class="column-title">@lang("spk.show.table.col_5")</th>
                                    <th class="column-title text-center" style="width: 200px">@lang("spk.show.table.col_6")</th>
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
                                        <a href="/wip/new/fromSPK/{{$spk->id}}_{{$si->id}}" class="btn btn-dark">@lang("spk.show.create_wip")</a>
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
                            <a href="{{ url('/spk') }}" class="btn btn-dark">@lang("spk.show.cancel")</a>
                            @hasrole('Owner|Ultimate|Production')
                                @if($statusajah == 0)
                                    @if($spk->status == 2)
                                    <!-- header close-->
                                    @can('Delete')
                                        <button type="button" class="btn btn-danger" id="click">@lang("spk.show.delete")</button>
                                    @endcan
                                    @can('Edit')
                                        <div class="btn-group">
                                            <button id="click" type="button" class="btn btn-success" onclick="window.location.href = '/spk/edit/{{$spk->id}}';">@lang("spk.show.edit")</button>
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
<script src="{{ asset('js/request/sukses/spk/deleteForm.js?v=5-20200312-1327') }}" charset="utf-8"></script>
@endpush