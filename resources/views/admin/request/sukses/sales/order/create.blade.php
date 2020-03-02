@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3>Create Sales Order</h3>
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
                                    <select class="form-control select_contact contact_id" name="vendor_name">
                                        <option></option>
                                    </select>
                                    <input class="selected_contact_id" hidden>
                                    <input class="selected_contact_term" hidden>
                                    <input class="selected_email" hidden>
                                    <input class="tampungan_contact_id" hidden>
                                    <input class="tampungan_contact_term" hidden>
                                    <input class="tampungan_email" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Customer Ref No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" class="form-control" name="vendor_no">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Term</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectterm term" name="term">
                                        <option></option>
                                        @foreach($terms as $a)
                                        <option value="{{$a->id}}" length="{{$a->length}}">
                                            {{$a->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Transaction Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$today}}" type="text" class="form-control trans_date" name="trans_date" id="datepicker1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Warehouse</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectwarehouse" name="warehouse">
                                        <option></option>
                                        @foreach($warehouses as $a)
                                        <option value="{{$a->id}}">
                                            {{$a->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Due Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" class="form-control due_date" name="due_date" id="datepicker2">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Email</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="email" class="form-control email_text" name="email">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Billing Address</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea rows="4" class="form-control" name="vendor_address"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Marketting</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control select_contact_employee contact_id_employee" name="marketting">
                                        <option></option>
                                    </select>
                                    <input class="selected_contact_id_employee" hidden>
                                    <input class="tampungan_contact_id_employee" hidden>
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
                                    <th class="column-title">Description</th>
                                    <th class="column-title" style="width:90px">Qty</th>
                                    <th class="column-title" style="width:90px">Units</th>
                                    <th class="column-title">Harga Nota</th>
                                    <th class="column-title">Harga Beda</th>
                                    <th class="column-title" style="width:90px">Tax</th>
                                    <th class="column-title">Amount</th>
                                    <th class="column-title"></th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <select class="select_product form-control product_id" name="products[]">
                                                <option></option>
                                            </select>
                                            <input class="selected_product_id" hidden>
                                            <input class="selected_product_desc" hidden>
                                            <input class="selected_product_unit" hidden>
                                            <input class="selected_product_price" hidden>
                                            <input class="selected_product_tax" hidden>
                                            <input class="tampungan_product_id" hidden>
                                            <input class="tampungan_product_desc" hidden>
                                            <input class="tampungan_product_unit" hidden>
                                            <input class="tampungan_product_price" hidden>
                                            <input class="tampungan_product_tax" hidden>
                                        </div>
                                    </td>
                                    <td>
                                        <textarea class="form-control desc" name="desc[]" rows="1"></textarea>
                                    </td>
                                    <td>
                                        <input onClick="this.select();" type="text" class="qty form-control" value='1' name='qty[]'>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select class="selectunit form-control units" name="units[]">
                                                @foreach($units as $a)
                                                <option value="{{$a->id}}">
                                                    {{$a->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <input onClick="this.select();" type="text" class="unit_price_display2 form-control" required>
                                        <input type="text" class="unit_price2 form-control form-control-sm" name="harga_nota[]" hidden>
                                    </td>
                                    <td>
                                        <input onClick="this.select();" type="text" class="unit_price_display form-control" required>
                                        <input type="text" class="unit_price form-control form-control-sm" name="unit_price[]" hidden>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select class="taxes form-control selecttax" name="tax[]">
                                                @foreach($taxes as $a)
                                                <option value="{{$a->id}}" rate="{{$a->rate}}">
                                                    {{$a->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="amount_display form-control" name="total_price_display[]" style="text-align: right;" readonly>
                                        <input type="text" class="amount" name="total_price[]" hidden>
                                        <input type="text" class="amounttax" name="total_price_tax[]" hidden>
                                        <input type="text" class="amountsub" name="total_price_sub[]" hidden>
                                        <input type="text" class="amountgrand" name="total_price_grand[]" hidden>
                                    </td>
                                    <td>
                                        <input type="button" class="btn btn-danger delete" value="x">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="button" class="btn btn-dark add" value="+ Add More Item">
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
                                        <h4> Sub Total </h4>
                                        <h4> Tax Total </h4>
                                        <br>
                                        <h3><b> Total Amount </b></h3>
                                    </div>
                                    <div class="col-md-4 float-right">
                                        <input class="subtotal form-control" readonly>
                                        <input type="text" class="subtotal_input" name="subtotal" hidden>
                                        <input class="total form-control" readonly>
                                        <input type="text" class="total_input" name="taxtotal" hidden>
                                        <br>
                                        <input class="balance form-control" readonly>
                                        <input type="text" class="balance_input" name="balance" hidden>
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
                            <a href="{{ url('/sales_order') }}" class="btn btn-danger">Cancel</a>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">Create </button>
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a id="clicknew">Create & New </a>
                                    </li>
                                    <li><a id="click">Create</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/request/sukses/sales/order/createForm.js?v=5-20200302-1755') }}" charset="utf-8"></script>
<script src="{{asset('js/request/sukses/sales/order/addmoreitem.js?v=5-20200302-1755') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200302-1755') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200302-1755') }}" charset="utf-8"></script>
<script src="{{asset('js/other/duedate_format.js?v=5-20200302-1755') }}" charset="utf-8"></script>
@endpush