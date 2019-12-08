@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false">Actions
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            @foreach($spk_item as $sii)
                            @if($sii->qty_remaining_sent != 0)
                            <li><a href="/sales_invoice/new/fromSPK/{{$spk->id}}">Create Invoice</a></li>
                            <li class="divider"></li>
                            @break
                            @endif
                            @endforeach
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
                                        <?php $qty += $qis->qty_in ?>
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
                                    <td class="text-center">
                                        <a href="/wip/new/fromSPK/{{$spk->id}}_{{$si->id}}" class="btn btn-dark">Create WIP</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="col-md-3 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/spk') }}" class="btn btn-dark">Cancel</a>
                            <?php $statusajah = 0 ?>
                            @foreach($spk_item as $a)
                                @if($a->status == 1)
                                    <!-- item open-->
                                    <?php $statusajah += 0 ?>
                                @else
                                    <?php $statusajah += 1 ?>
                                @endif
                            @endforeach
                            @if($statusajah == 0)
                                @if($spk->status == 2)
                                    <!-- header close-->
                                    <button type="button" class="btn btn-danger" id="click">Delete</button>
                                    <div class="btn-group">
                                        <button id="click" type="button" class="btn btn-success" onclick="window.location.href = '/spk/edit/{{$spk->id}}';">Edit</button>
                                    </div>
                                    <input type="text" value="{{$spk->id}}" id="form_id" hidden>
                                @endif
                            @endif
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