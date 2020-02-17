@extends('layouts.admin')
@section('content')

<div class="dashboard-wrapper">

    <!-- ============================================================== -->
    <!-- pageheader  -->
    <!-- ============================================================== -->
    <div class="row form-page-header">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
            <div id="top">
                <small>Transaction </small>
                <h1>Edit Purchase Invoice</h1>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end pageheader  -->
    <!-- ============================================================== -->

    <div class="container-fluid form-content">
        <form method="post" action="{{ route('pi.update',$pi->purchase_detail->purchase_id) }}">
            <div class="row">
                @csrf
                @method('PUT')

                <div class="col-lg-3">
                    <label class="col-form-label">* Vendor </label>
                    <select class="form-control form-control-sm" name="vendor_name" required>
                        <option>Select vendor</option>
                        @foreach ($vendors as $vendor)
                        <option {{$pi->pi_vendor_id = $vendor->display_name ? 'selected' : ''}}>{{$vendor->display_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3">
                    <label for="emailForm" class="col-form-label">Email</label>
                    <input type="email" class="form-control form-control-sm" name="vendor_email" value="{{$pi->pi_email}}">
                </div>
                <div class="col-lg-6">
                    <h2 class="float-right"> Total Rp. <span class="balance txt-primary">{{$pi->pi_grandtotal}}</span></h2>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="descForm">Vendor Address </label>
                        <textarea class="form-control" name="vendor_address" rows="2">{{$pi->pi_address}}</textarea>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="descForm">Transaction Date </label>
                        <input type="date" class="form-control form-control-sm datepicker" name="trans_date" value="{{$pi->pi_transaction_date}}" required>
                    </div>
                    <div class="form-group">
                        <label for="descForm">Due Date </label>
                        <input type="date" class="form-control form-control-sm" name="due_date" value="{{$pi->pi_due_date}}" required>
                    </div>
                    <div class="form-group">
                        <label for="categoryForm"> Term </label>
                        <select class="form-control form-control-sm" name="term">
                            <option selected>Select...</option>
                            @foreach ($terms as $term)
                            <option {{$pi->term_id = $term->name ? 'selected' : ''}}>{{$term->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="descForm">Transaction No </label>
                        <input type="text" class="form-control form-control-sm" name="trans_no" value="{{$pi->pi_number}}"
                            disabled>
                    </div>
                    <div class="form-group">
                        <label for="descForm">Vendor Ref No </label>
                        <input type="text" class="form-control form-control-sm" name="vendor_no" value="{{$pi->pi_vendor_ref_no}}">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="descForm">Tags </label>
                        <input type="text" class="form-control form-control-sm" name="tags" value="{{$pi->pi_tag}}">
                    </div>
                    <div class="form-group">
                        <label for="categoryForm"> Warehouse </label>
                        <select class="form-control form-control-sm" name="warehouse">
                            <option selected>Select...</option>
                            @foreach ($warehouses as $warehouse)
                            <option {{$pi->warehouse_id = $warehouse->warehouse_name ? 'selected' : ''}}>{{$warehouse->warehouse_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="include-tax float-right">
                    <p class="float-right"> Price Include Tax </p>
                </div>
                <div class="table my-5">
                    <table id="example" class="table table-bordered second">
                        <thead class="bg-primary">
                            <tr>
                                <th style="color:whitesmoke;">Product</th>
                                <th style="color:whitesmoke;">Description</th>
                                <th style="color:whitesmoke;">Qty</th>
                                <th style="color:whitesmoke;">Units</th>
                                <th style="color:whitesmoke;">Unit Price</th>
                                <th style="color:whitesmoke;">Tax</th>
                                <th style="color:whitesmoke;">Amount</th>
                                <th style="color:whitesmoke;"></th>
                            </tr>
                        </thead>
                        <tbody class="neworderbody">
                            @foreach($pp as $p)
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <select class="select2 form-control form-control-sm product_id"
                                            name="products[]" aria-placeholder="Select Product" required>
                                            @foreach ($products as $product)
                                            <option value="{{$product->id}}" {{$p->product_id = $product->id ? 'selected' : ''}}>{{$product->product_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td>
                                <textarea class="form-control desc" name="desc[]" rows="1">{{$p->desc}}</textarea>
                                </td>
                                <td>
                                <input type="number" class="qty form-control form-control-sm" value='{{$p->qty}}'
                                        name='qty[]'>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <select class="select2 form-control form-control-sm units" name="units[]"
                                            aria-placeholder="Select Product" required>
                                            <option value="" selected>Select Unit</option>
                                            @foreach ($units as $unit)
                                            <option value="{{$unit->id}}" {{$p->unit = $unit->id ? 'selected' : ''}}>{{$unit->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" class="unit_price form-control form-control-sm"
                                        name="unit_price[]" value={{$p->unit_price}} required>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <select class="select2 form-control form-control-sm taxes" name="tax[]">
                                            <option value="" selected>Select Tax</option>
                                            @foreach ($taxes as $tax)
                                            <option>{{$tax->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" class="amount form-control form-control-sm"
                                        name="total_price[]" value="{{$p->amount}}" readonly>
                                </td>
                            </tr>    
                            @endforeach                       
                        </tbody>
                    </table>
                    
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="messageForm">Message </label>
                    <textarea class="form-control" name="message" rows="2" >{{$pi->pi_message}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="memoForm">Memo </label>
                        <textarea class="form-control" name="memo" rows="2">{{$pi->pi_memo}}</textarea>
                    </div>
                </div>
                <div class="col-lg-3">

                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-4">

                        </div>
                        <div class="col-lg-4">
                            <h3> Sub Total </h3>
                            <h3> Total </h3>
                            <h3 class="font-weight-bold"> Balance Due</h3>
                        </div>
                        <div class="col-lg-4 float-right">
                            <h3 class="subtotal"> Rp {{$pi->pi_subtotal}} </h3>
                        <input type="text" class="subtotal_input" name="subtotal" value="{{$pi->pi_subtotal}}" hidden>
                            <h3 class="total"> Rp {{$pi->pi_grandtotal}} </h3>
                            <input type="text" class="total_input" name="total" hidden>
                            <h3 class="balance"> Rp {{$pi->pi_grandtotal}} </h3>
                            <input type="text" class="balance_input" name="balance" value="{{$pi->pi_grandtotal}}" hidden>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="offset-lg-9 col-lg-3">
                    <a href="{{ url('/purchases') }}" class="btn btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-success">Update </button>
                </div>
            </div>
        </form>
    </div>

</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{asset('js/sum.js?v=5-20200217-1409') }}" charset="utf-8"></script>
<script type="text/javascript" src="{{asset('js/add_field.js?v=5-20200217-1409') }}" charset="utf-8"></script>
<script type="text/javascript" src="{{asset('js/render_select2.js?v=5-20200217-1409') }}" charset="utf-8"></script>
<script type="text/javascript" src="{{asset('js/render_datepicker.js?v=5-20200217-1409') }}" charset="utf-8"></script>
@endpush