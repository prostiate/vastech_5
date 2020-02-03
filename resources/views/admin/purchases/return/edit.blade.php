@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3>Update Purchase Return</h3>
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
                                    <input value="{{$header->number}}" type="text" class="form-control" name="trans_no" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Vendor*</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="{{ url('/contacts/'.$header->contact_id) }}">
                                        <h5>{{$header->contact->display_name}}</h5>
                                    </a>
                                    <input type="hidden" name="vendor_name" value="{{$header->contact_id}}">
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
                                        <h5>{{$header->transaction_date}}</h5>
                                    </a>
                                    <input type="hidden" name="trans_date" value="{{$header->transaction_date}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Email</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a>
                                        <h5>{{$header->email}}</h5>
                                    </a>
                                    <input type="hidden" name="email" value="{{$header->email}}">
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
                                        <h5>{{$header->due_date}}</h5>
                                    </a>
                                    <input type="hidden" name="due_date" value="{{$header->due_date}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Purchase No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="{{ url('/purchases_invoice/'.$header->selected_pi_id) }}">
                                        <h5> Purchase Invoice #{{$header->transaction_no_pi}}</h5>
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
                                    <input value="{{$header->return_date}}" type="text" class="form-control" name="return_date" id="datepicker3">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Warehouse</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a>
                                        <h5>{{$header->warehouse->name}}</h5>
                                    </a>
                                    <input type="hidden" name="warehouse" value="{{$header->warehouse_id}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Vendor Address</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a>
                                        <h5>{{$header->address}}</h5>
                                    </a>
                                    <input type="hidden" name="vendor_address" value="{{$header->address}}">
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
                                @foreach($item as $item)
                                <input type="text" name="invoice_item[]" value="{{$item->purchase_invoice_item_id}}" hidden>
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
                                            <h5>{{$item->qty_invoice}}</h5>
                                        </a>
                                        <input type="text" name="qty_invoice[]" value="{{$item->qty_invoice}}" hidden>
                                    </td>
                                    <td>
                                        <a>
                                            <h5>{{$item->qty_remaining_invoice}}</h5>
                                        </a>
                                        <input type="text" name="qty_remaining_return[]" value="{{$item->qty_remaining_invoice}}" hidden>
                                    </td>
                                    <td>
                                        <input onClick="this.select();" type="text" class="form-control qty" value='{{$item->qty}}' name='qty[]'>
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
                                        <input value="{{$item->amount}}" type="text" class="amount_display form-control" name="total_price_display[]" readonly>
                                        <input value="{{$item->amount}}" type="text" class="amount " name="total_price[]" hidden>
                                        <input value="{{$item->amounttax}}" type="text" class="amounttax" name="total_price_tax[]" hidden>
                                        <input value="{{$item->amountsub}}" type="text" class="amountsub" name="total_price_sub[]" hidden>
                                        <input value="{{$item->amountgrand}}" type="text" class="amountgrand" name="total_price_grand[]" hidden>
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
                                    <textarea class="form-control" name="message" rows="4">{{$header->message}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-4">
                                        <h4>Invoice Amount</h4>
                                        <h4>Sub Total</h4>
                                        @if($header->taxtotal > 0)
                                        <h4>Tax Total</h4>
                                        @endif
                                        <br>
                                        <h3><b>Total Return</b></h3>
                                        <h4>Balance Due</h4>
                                    </div>
                                    <?php
                                    $invoice_amount         = $header->purchase_invoice->grandtotal;
                                    if ($other_return == 0) {
                                        $balancedue_amount  = $header->purchase_invoice->grandtotal;
                                    } else {
                                        $balancedue_amount  = $other_return;
                                    }
                                    ?>
                                    <div class="col-md-4 float-right">
                                        <input class="invoice_amount form-control" readonly value="{{$invoice_amount}}">
                                        <input type="text" class="invoice_amount_input" name="invoice_amount" value="{{$invoice_amount}}" hidden>
                                        <input class="subtotal form-control" readonly>
                                        <input type="text" class="subtotal_input" name="subtotal" hidden>
                                        @if($header->taxtotal > 0)
                                        <input class="total form-control" readonly>
                                        <input type="text" class="total_input" name="taxtotal" hidden>
                                        @else
                                        <input type="text" name="taxtotal" value="0" hidden>
                                        @endif
                                        <br>
                                        <input class="balance form-control" readonly>
                                        <input type="text" class="balance_input" name="balance" hidden>
                                        <input class="balancedue form-control" readonly value="{{$balancedue_amount}}">
                                        <input type="text" class="balancedue_input_get" value="{{$balancedue_amount}}" hidden>
                                        <input type="text" class="balancedue_input_post" name="invoice_balancedue" value="{{$balancedue_amount}}" hidden>
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
                                    <textarea class="form-control" name="memo" rows="4">{{$header->memo}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-3 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/purchases_return/'.$header->id) }}" class="btn btn-danger">Cancel</a>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">Update</button>
                            </div>
                            <input value="{{$header->id}}" type="hidden" name="hidden_id">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/purchases/return/updateForm.js?v=5-03022020') }}" charset="utf-8"></script>
<script src="{{asset('js/purchases/return/addmoreitem.js?v=5-03022020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-03022020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-03022020') }}" charset="utf-8"></script>
@endpush