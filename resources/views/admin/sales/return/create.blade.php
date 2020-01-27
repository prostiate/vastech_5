@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3>Create Sales Return</h3>
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
                                    <input value="{{$trans_no}}" type="text" class="form-control" name="trans_no" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Customer*</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="{{ url('/contacts/'.$po->contact_id) }}">
                                        <h5>{{$po->contact->display_name}}</h5>
                                    </a>
                                    <input type="hidden" name="vendor_name" value="{{$po->contact_id}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Transaction Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a>
                                        <h5>{{$po->transaction_date}}</h5>
                                    </a>
                                    <input type="hidden" name="trans_date" value="{{$po->transaction_date}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Email</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a>
                                        <h5>{{$po->email}}</h5>
                                    </a>
                                    <input type="hidden" name="email" value="{{$po->email}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Due Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a>
                                        <h5>{{$po->due_date}}</h5>
                                    </a>
                                    <input type="hidden" name="due_date" value="{{$po->due_date}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Sales No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="{{ url('/sales_invoice/'.$po->id) }}">
                                        <h5>Sales Invoice #{{$po->number}}</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Return Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$today}}" type="text" class="form-control" name="return_date" id="datepicker3">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Warehouse</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a>
                                        <h5>{{$po->warehouse->name}}</h5>
                                    </a>
                                    <input type="hidden" name="warehouse" value="{{$po->warehouse_id}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Biling Address</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a>
                                        <h5>{{$po->address}}</h5>
                                    </a>
                                    <input type="hidden" name="vendor_address" value="{{$po->address}}">
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
                                    <th class="column-title" style="width:300px">Product</th>
                                    <th class="column-title" style="width:110px">Invoice Qty</th>
                                    <th class="column-title" style="width:120px">Returnable Qty</th>
                                    <th class="column-title" style="width:110px">Returned Qty</th>
                                    <th class="column-title" style="width:90px">Units</th>
                                    <th class="column-title" style="width:150px">Unit Price</th>
                                    <th class="column-title" style="width:90px">Tax</th>
                                    <th class="column-title" style="width:150px">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                @foreach($po_item as $item)
                                <input type="text" name="invoice_item[]" value="{{$item->id}}" hidden>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <a href="{{ url('/products/'.$item->product_id) }}">
                                                <h5>{{$item->product->name}}</h5>
                                            </a>
                                            <input type="tex" name="products[]" value="{{$item->product_id}}" hidden>
                                        </div>
                                    </td>
                                    <td>
                                        <a>
                                            <h5>{{$item->qty}}</h5>
                                        </a>
                                        <input type="text" name="qty_invoice[]" value="{{$item->qty}}" hidden>
                                    </td>
                                    <td>
                                        <a>
                                            <h5>{{$item->qty_remaining_return}}</h5>
                                        </a>
                                        <input type="text" name="qty_remaining_return[]" value="{{$item->qty_remaining_return}}" hidden>
                                    </td>
                                    <td>
                                        <input onClick="this.select();" type="text" class="form-control qty" value='0' name='qty[]'>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <a>
                                                <h5>{{$item->unit->name}}</h5>
                                            </a>
                                            <input type="text" name="units[]" value="{{$item->unit_id}}" hidden>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <a>
                                                <h5>Rp @number($item->unit_price)</h5>
                                            </a>
                                            <input type="text" name="unit_price[]" class="unit_price" value="{{$item->unit_price}}" hidden>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <a>
                                                <h5>{{$item->tax->name}}</h5>
                                            </a>
                                            <input type="text" name="tax[]" class="taxes" value="{{$item->tax_id}}" rate="{{$item->tax->rate}}" hidden>
                                        </div>
                                    </td>
                                    <td>
                                        <input value="0" type="text" class="amount_display form-control" name="total_price_display[]" readonly>
                                        <input value="0" type="text" class="amount form-control form-control-sm " name="total_price[]" hidden>
                                        <input value="0" type="text" class="amounttax" name="total_price_tax[]" hidden>
                                        <input value="0" type="text" class="amountsub" name="total_price_sub[]" hidden>
                                        <input value="0" type="text" class="amountgrand" name="total_price_grand[]" hidden>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="messageForm" style="text-align: left;">Message</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea class="form-control" name="message" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-4">
                                        <h4>Invoice Amount</h4>
                                        <h4>Sub Total</h4>
                                        @if($po->taxtotal > 0)
                                        <h4>Tax Total</h4>
                                        @endif
                                        <br>
                                        <h3><b>Total Return</b></h3>
                                        <h4>Balance Due</h4>
                                    </div>
                                    <div class="col-md-4 float-right">
                                        <input class="invoice_amount form-control" readonly value="{{$po->grandtotal}}">
                                        <input type="text" class="invoice_amount_input" name="invoice_amount" value="{{$po->grandtotal}}" hidden>
                                        <input class="subtotal form-control" readonly>
                                        <input type="text" class="subtotal_input" name="subtotal" hidden>
                                        @if($po->taxtotal > 0)
                                        <input class="total form-control" readonly>
                                        <input type="text" class="total_input" name="taxtotal" hidden>
                                        @else
                                        <input type="text" name="taxtotal" value="0" hidden>
                                        @endif
                                        <br>
                                        <input class="balance form-control" readonly>
                                        <input type="text" class="balance_input" name="balance" hidden>
                                        <input class="balancedue form-control" readonly value="{{$po->balance_due}}">
                                        <input type="text" class="balancedue_input_get" value="{{$po->balance_due}}" hidden>
                                        <input type="text" class="balancedue_input_post" name="invoice_balancedue" value="{{$po->balance_due}}" hidden>
                                        <div class="form-group tile"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">Memo</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea class="form-control" name="memo" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-3 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/sales_invoice/'.$po->id) }}" class="btn btn-danger">Cancel</a>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">Create</button>
                            </div>
                            <input value="{{$po->id}}" type="hidden" name="hidden_id">
                            <input value="{{$po->number}}" type="hidden" name="hidden_id_number">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/sales/return/createForm.js?v=5-27012020') }}" charset="utf-8"></script>
<script src="{{asset('js/sales/return/addmoreitem.js?v=5-27012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-27012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-27012020') }}" charset="utf-8"></script>
@endpush