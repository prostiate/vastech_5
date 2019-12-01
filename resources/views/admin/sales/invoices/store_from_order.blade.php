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
                <h1>Create Purchase Invoice</h1>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
            <div class="btn-group float-right">
                <button type="button" class="btn btn-success">Purchase Invoice </button>
                <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">                
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{url('purchases/new')}}">Purchase Invoice</a>
                    <a class="dropdown-item" href="{{url('purchases_order/new')}}">Purchase Order </a>
                    <a class="dropdown-item" href="{{url('purchases_quote/new')}}">Purchase Quote </a>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end pageheader  -->
    <!-- ============================================================== -->

    <div class="container-fluid form-content">
        <form method="post" action="{{ route('pi.storeFrom',[$pq->purchase_detail->purchase_id]) }}">
            <div class="row">
                @csrf
                    <input type="hidden" value="{{$pq->pq_number}}" name="number">
                    <input type="hidden" value="{{$pq->pq_vendor_id}}" name="vendor_name">
                    <input type="hidden" value="{{$pq->pq_email}}" name="vendor_email">
                    <input type="hidden" value="{{$pq->pq_address}}" name="vendor_address">
                <div class="col-lg-3">
                    <label class="col-6 col-form-label">* Vendor </label>
                    <label class="col-6 col-form-label" name="vendor_name" value="{{$pq->pq_vendor_id}} ">{{$pq->pq_vendor_id}} </label>
                </div>
                <div class="col-lg-3">
                    <label for="emailForm" class="col-form-label">Email</label>
                    <input type="email" class="form-control form-control-sm" name="vendor_email" value="{{$pq->pq_email}}">
                </div>
                <div class="col-lg-6">
                    <h2 class="float-right"> Total <span class="txt-primary">Rp. 0,00</span></h2>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="descForm">Vendor Address </label>
                        <textarea class="form-control" name="vendor_address" rows="2" value="{{$pq->pq_address}}"></textarea>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="descForm">Transaction Date  </label>
                        <input type="date" class="form-control form-control-sm" name="trans_date" value="{{$pq->pq_transaction_date}}">
                    </div>
                    <div class="form-group">
                        <label for="descForm">Due Date   </label>
                        <input type="date" class="form-control form-control-sm" name="due_date" value="{{$pq->pq_due_date}}">
                    </div>
                    <div class="form-group">
                        <label for="categoryForm"> Term  </label>
                        <select class="form-control form-control-sm" name="term">
                                <option selected>{{$pq->pq_term_id}}</option>
                                @foreach ($terms as $term)
                                <option>{{$term->name}}</option>
                                @endforeach  
                            </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="descForm">Transaction No  </label>
                        <input type="text" class="form-control form-control-sm" name="trans_no" value="{{$pq->pq_number}}">
                    </div>
                    <div class="form-group">
                        <label for="descForm">Vendor Ref No  </label>
                        <input type="text" class="form-control form-control-sm" name="vendor_no" value="{{$pq->pq_vendor_ref_no}}">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="descForm">Tags  </label>
                        <input type="text" class="form-control form-control-sm" name="tags">
                    </div>
                    <div class="form-group">
                        <label for="categoryForm"> Warehouse  </label>
                        <select class="form-control form-control-sm" name="warehouse">
                                <option selected>selected</option>
                                @foreach ($warehouses as $warehouse)
                                <option>{{$warehouse->warehouse_name}}</option>
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product) 
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm" value='{{$product->product_id}}' name='products[]' readonly>
                                    </div>
                                </td>
                                <td>
                                    <textarea class="form-control" value='{{$product->desc}}' name="desc[]" rows="1"></textarea>
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" value='{{$product->qty}}' name='qty[]' readonly>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm" value='{{$product->unit}}' name='units[]' readonly> 
                                    </div>
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" value='{{$product->unit_price}}' name="unit_price[]" readonly>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm" value='{{$product->tax_id}}' name="tax[]" readonly>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" value='{{$product->amount}}' name="total_price[]" readonly>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="messageForm">Message  </label>
                        <textarea class="form-control" name="message" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="memoForm">Memo  </label>
                        <textarea class="form-control" name="memo" rows="2"></textarea>
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
                            <h3> Rp 0,00 </h3>
                            <h3> Rp 0,00 </h3>
                            <h3> Rp 0,00 </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="offset-lg-9 col-lg-3">
                    <button type="submit" class="btn btn-danger">Cancel</button>
                    <div class="btn-group dropup">
                        <button type="submit" class="btn btn-success">Create </button>
                        <button type="submit" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">                
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Create & New</a>
                            <a class="dropdown-item" href="#">Create </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
</div>
@endsection