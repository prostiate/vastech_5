@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '#';" data-toggle="modal" data-target=".bs-example-modal-lg">@lang('wip.show.spk_history')
                        </button>
                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                        </button>
                                        <h5 class="modal-title" id="myModalLabel">@lang('wip.show.spk_history')</h5>
                                        <h3 class="modal-title" id="myModalLabel"><strong>@lang('wip.show.title'){{$wip->number}}</strong></h3>
                                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">@lang('wip.show.spk_history')</a>
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
                                                                    <th class="column-title">@lang('wip.show.table_2.col_1')</th>
                                                                    <th class="column-title">@lang('wip.show.table_2.col_2')</th>
                                                                    <th class="column-title">@lang('wip.show.table_2.col_3')</th>
                                                                    <th class="column-title">@lang('wip.show.table_2.col_4')</th>
                                                                    <th class="column-title">@lang('wip.show.table_2.col_5')</th>
                                                                    <th class="column-title">@lang('wip.show.table_2.col_6')</th>
                                                                    <th class="column-title">@lang('wip.show.table_2.col_7')</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="neworderbody">
                                                                <tr>
                                                                    <td>
                                                                        <a>{{$wip->spk->transaction_date}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="/spk/{{$wip->selected_spk_id}}">Surat Perintah Kerja #{{$wip->spk->number}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="/spk/{{$wip->selected_spk_id}}">{{$wip->spk->vendor_ref_no}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="/contacts/{{$wip->spk->contact_id}}">{{$wip->spk->contact->display_name}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="/warehouses/{{$wip->spk->warehouse_id}}">{{$wip->spk->warehouse->name}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a>{{$wip->spk->desc}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a>{{$wip->spk->spk_status->name}}</a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-dark" data-dismiss="modal">@lang('wip.show.close')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '#';" data-toggle="modal" data-target=".bs-example-modal-lg-2">@lang('wip.show.vje')
                        </button>
                        <div class="modal fade bs-example-modal-lg-2" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                        </button>
                                        <h5 class="modal-title" id="myModalLabel">@lang('wip.show.vje_report')</h5>
                                        <h3 class="modal-title" id="myModalLabel"><strong>@lang('wip.show.title'){{$wip->number}}</strong></h3>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive my-5">
                                            <table id="example" class="table table-striped jambo_table bulk_action">
                                                <thead>
                                                    <tr class="headings">
                                                        <th class="column-title" style="width:200px">@lang('wip.show.table_3.col_1')</th>
                                                        <th class="column-title" style="width:250px">@lang('wip.show.table_3.col_2')</th>
                                                        <th class="column-title" style="width:150px">@lang('wip.show.table_3.col_3')</th>
                                                        <th class="column-title" style="width:150px">@lang('wip.show.table_3.col_4')</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="neworderbody">
                                                    @foreach ($get_all_detail as $po)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ url('/purchases_invoice/'.$po->coa_id) }}">{{$po->coa->code}}</a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ url('/purchases_invoice/'.$po->coa_id) }}">{{$po->coa->name}}</a>
                                                        </td>
                                                        <td>
                                                            @if($po->debit == 0)
                                                            @else
                                                            <a>Rp @number($po->debit)</a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($po->credit == 0)
                                                            @else
                                                            <a>Rp @number($po->credit)</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr class="headings">
                                                        <td>
                                                            <strong><b>Total</b></strong>
                                                        </td>
                                                        <td>
                                                        </td>
                                                        <td>
                                                            <strong><b>Rp @number($total_debit)</b></strong>
                                                        </td>
                                                        <td>
                                                            <strong><b>Rp @number($total_credit)</b></strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <input type="button" class="btn btn-dark add" value="+ Add More Item" hidden>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-dark" data-dismiss="modal">@lang('wip.show.close')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false">@lang('wip.show.action.action_1')
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a target="_blank" href="/wip/print/PDF/{{$wip->id}}">@lang('wip.show.action.action_2')</a></li>
                        </ul>
                    </li>
                </ul>
                <h3><b>@lang("wip.show.title"){{$wip->number}}</b></h3>
                <a>Status: </a>
                @if($wip->status == 1)
                <span class="label label-warning" style="color:white;">@lang("status.open")</span>
                @elseif($wip->status == 2)
                <span class="label label-success" style="color:white;">@lang("status.closed")</span>
                @elseif($wip->status == 3)
                <span class="label label-success" style="color:white;">@lang("status.paid")</span>
                @elseif($wip->status == 4)
                <span class="label label-warning" style="color:white;">@lang("status.part")</span>
                @elseif($wip->status == 5)
                <span class="label label-danger" style="color:white;">@lang("status.over")</span>
                @elseif($wip->status == 6)
                <span class="label label-success" style="color:white;">@lang("status.sent")</span>
                @elseif($wip->status == 7)
                <span class="label label-success" style="color:white;">@lang("status.act")</span>
                @elseif($wip->status == 8)
                <span class="label label-success" style="color:white;">@lang("status.sold")</span>
                @elseif($wip->status == 9)
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang("wip.show.trans_no")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a>{{$wip->number}}</a></h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang("wip.show.trans_date")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a>{{$wip->transaction_date}}</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang("wip.show.spk")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/spk/{{$wip->selected_spk_id}}">Surat Perintah Kerja #{{$wip->transaction_no_spk}}</a></h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang("wip.show.contact")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/contacts/{{$wip->contact_id}}">{{$wip->contact->display_name}}</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang("wip.show.ref_no")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/spk/{{$wip->selected_spk_id}}">{{$wip->spk->vendor_ref_no}}</a></h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang("wip.show.warehouse")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/warehouses/{{$wip->warehouse_id}}">{{$wip->warehouse->name}}</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">@lang("wip.show.product_name")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/products/{{$wip->result_product}}">{{$wip->product->name}}</a></h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang("wip.show.product_qty")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a>{{$wip->result_qty}} {{$wip->product->other_unit->name}}</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">@lang("wip.show.note")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a>{{$wip->desc}}</a></h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">@lang("wip.show.method")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a>@if($wip->production_method == 0) Material Per Product Qty @else Material For All Product Qty @endif</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group tiles"></div>
                    <br>
                    <div>
                        <a>@lang("wip.show.footnote.note_1")<strong><span>1</span></strong> @lang("wip.show.footnote.note_2") <strong>{{$wip->product->name}}</strong></a>
                    </div>
                    <br>
                    <div class="table-responsive my-5">
                        <table id="example" class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <!--<th class="column-title" style="width: 250px">Quantity In Stock</th>-->
                                    <th class="column-title" style="width: 350px">@lang("wip.show.table.col_1")</th>
                                    <th class="column-title" style="width: 250px">@lang("wip.show.table.col_2")</th>
                                    <th class="column-title" style="width: 300px">@lang("wip.show.table.col_3")</th>
                                    <th class="column-title" style="width: 300px">@lang("wip.show.table.col_4")</th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                <?php $qtyin = 0 ?>
                                <?php $qtyout = 0 ?>
                                <?php $qty = 0 ?>
                                @foreach($wip_item as $cpbi)
                                <tr>
                                    <td>
                                        <a href="/products/{{$cpbi->product_id}}">{{$cpbi->product->name}}</a>
                                    </td>
                                    <td>
                                        <a>{{$cpbi->qty_require}}</a>
                                    </td>
                                    <!--<td>
                                        @foreach($quantity_in_stock as $qis)
                                        @if($qis->product_id == $cpbi->product_id)
                                        <?php $qtyin += $qis->qty_in ?>
                                        <?php $qtyout += $qis->qty_out ?>
                                        <?php $qty = $qis->qty_in - $qis->qty_out ?>
                                        @endif
                                        @endforeach
                                        <a>{{$qty}}</a>
                                    </td>-->
                                    <td>
                                        <a>Rp @number($cpbi->price)</a>
                                    </td>
                                    <td>
                                        <a>Rp @number($cpbi->total_price)</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="neworderfoot">
                                <tr>
                                    <td colspan="3" class="text-right">
                                        <h5><strong>@lang("wip.show.margin")</strong>@if($wip->margin_type == 'rp') (Rp) @else (%) @endif
                                        </h5>
                                    </td>
                                    <td>
                                        <h5>Rp @number($wip->margin_value)</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right">
                                        <h5><strong>@lang("wip.show.cogs")</strong></h5>
                                    </td>
                                    <td>
                                        <h5>Rp @number($wip->grandtotal_with_qty + $wip->margin_total)</h5>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <br>
                    <div class="col-md-3 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/wip') }}" class="btn btn-dark">@lang("wip.show.cancel")</a>
                            @hasrole('Owner|Ultimate|Production')
                            @can('Delete')
                            <button type="button" class="btn btn-danger" id="click">@lang("wip.show.delete")</button>
                            @endcan
                            @endrole
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success" onclick="window.location.href = '/wip/edit/{{$wip->id}}';">@lang("wip.show.edit")</button>
                            </div>
                            <input type="text" value="{{$wip->id}}" id="form_id" hidden>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/request/sukses/wip/deleteForm_per.js?v=5-20200312-1327') }}" charset="utf-8"></script>
@endpush