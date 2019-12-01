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
                <h1>Create Purchase Payment</h1>
            </div>
        </div>        
    </div>
    <!-- ============================================================== -->
    <!-- end pageheader  -->
    <!-- ============================================================== -->

    <div class="container-fluid form-content">
        @csrf
        <div class="row">
            <div class="col-lg-3">
                <label class="col-6 col-form-label">Vendor :</label>
            <input type="text" class="form-control form-control-sm" name="vendor" value="{{$pq->pi_vendor_id}}" disabled>
            </div>
            <div class="col-lg-3">
                <label class="col-6 col-form-label">Pay From :</label>
                <select class="select2 form-control form-control-sm " name="pay_from">
                    @foreach($accounts as $account)
                <option>{{$account->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-6">
                <h2 class="float-right" id="vendor_total"> Total <span class="txt-primary">Rp. 0,00</span></h2>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="descForm">Payment Method </label>
                    <select class="select2 form-control form-control-sm " name="pay_method">
                        <option>Cash</option>
                        <option>Check</option>
                        <option>Bank Transfer</option>
                        <option>Credit Card</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="descForm">Payment Date </label>
                <input type="date" class="form-control form-control-sm" name="payment_date" value="{{$today}}">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="descForm">Due Date </label>
                    <input type="date" class="form-control form-control-sm" name="due_date">
                </div>
            </div>
            <div class="col-lg-2">
            </div>
            <div class="col-lg-2 col-lg-offset-2">
                <div class="form-group">
                    <label for="descForm"> Tags </label>
                    <input type="text" class="form-control form-control-sm" name="tags">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="descForm">Transaction No </label>
                    <input type="text" class="form-control form-control-sm" name="transaction">
                </div>
            </div>

            <div class="table my-5">
                <table id="example" class="table table-bordered second">
                    <thead class="bg-primary">
                        <tr>
                            <th style="color:whitesmoke;">Number</th>
                            <th style="color:whitesmoke;">Description</th>
                            <th style="color:whitesmoke;">Due Date</th>
                            <th style="color:whitesmoke;">Total</th>
                            <th style="color:whitesmoke;">Balance Due</th>
                            <th style="color:whitesmoke;">Payment Amount</th>
                        </tr>
                    </thead>
                    <tbody class="neworderbody">
                        <tr>
                            <td>
                                <label for="descForm">Purchase Invoice #{{$pq->pi_number}}  </label>
                            </td>
                            <td>
                                <label for="descForm">{{$pq->pi_desc}} </label>
                            </td>
                            <td>
                                <label for="descForm">{{$pq->pi_due_date}} </label>
                            </td>
                            <td>
                                <label for="descForm">@currency($pq->pi_grandtotal)</label>
                            </td>
                            <td>
                                <label for="descForm">@currency($pq->pi_grandtotal)</label>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="pay_amount">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="memoForm">Memo </label>
                    <textarea class="form-control" name="memo" rows="2"></textarea>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-4">

                    </div>
                    <div class="col-lg-4">
                        <h3> Total </h3>
                    </div>
                    <div class="col-lg-4 float-right">
                        <h3> Rp 0,00 </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="offset-lg-9 col-lg-3">
            <a href="{{ url('/purchases') }}" class="btn btn-danger">Cancel</a>
            <button type="submit" class="btn btn-success"> Create Payment</button>
        </div>
    </div>
</div>
@endsection