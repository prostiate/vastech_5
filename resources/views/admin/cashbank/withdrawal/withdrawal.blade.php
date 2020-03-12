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
                <h1> Bank Withdrawal  </h1>
            </div>
        </div>        
    </div>
    <!-- ============================================================== -->
    <!-- end pageheader  -->
    <!-- ============================================================== -->

    <div class="container-fluid form-content">
        <form method="post" action="">
            <div class="row">
                @csrf
                <div class="col-lg-3">
                    <label class="col-form-label">* Pay From </label>
                    <select class="form-control form-control-sm" name="vendor_name">
                        <option selected>Select...</option>
                                             
                    </select>
                </div>               
                <div class="col-lg-6">
                    <h2 class="float-right"> Total Amount <span class="txt-primary">Rp. 0,00</span></h2>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="descForm">Payer </label>
                        <select class="form-control form-control-sm" name="vendor_name">
                            <option selected>Select...</option>
                                                    
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="descForm">Transaction Date  </label>
                        <input type="date" class="form-control form-control-sm" name="trans_date">
                    </div>                   
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="descForm">Transaction No  </label>
                        <input type="text" class="form-control form-control-sm" name="trans_no" disabled>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="descForm">Tags  </label>
                        <input type="text" class="form-control form-control-sm" name="tags">
                    </div>
                </div>

                <div class="table my-5">
                    <table id="example" class="table table-bordered second">
                        <thead class="bg-primary">
                            <tr>
                                <th style="color:whitesmoke;">Receive From </th>
                                <th style="color:whitesmoke;">Description</th>
                                <th style="color:whitesmoke;">Tax</th>
                                <th style="color:whitesmoke;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control form-control-sm" name="products[]" aria-placeholder="Select Product">
                                            <option>Select Product</option>
                                            
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <textarea class="form-control" name="desc[]" rows="1"></textarea>
                                </td>                                
                                <td>
                                    <div class="form-group">
                                        <select class="form-control form-control-sm" name="tax[]" aria-placeholder="Select Product">
                                            <option>Tax</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" class="total-price form-control form-control-sm" name="total_price[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control form-control-sm" name="products[]" aria-placeholder="Select Product">
                                            <option>Select Product</option>
                                            
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <textarea class="form-control" name="desc[]" rows="1"></textarea>
                                </td>                               
                                <td>
                                    <div class="form-group">
                                        <select class="form-control form-control-sm" name="tax[]" aria-placeholder="Select Product">
                                            <option>Tax</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" class="total-price form-control form-control-sm" name="total_price[]">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-3">                    
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
                            <h3 class="subtotal"> Rp 0,00 </h3>
                            <h3> Rp 0,00 </h3>
                            <h3> Rp 0,00 </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="offset-lg-9 col-lg-3">
                    <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
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

@push('scripts')
    <script type="text/javascript" src="{{asset('js/multiply.js?v=5-20200312-1327') }}" charset="utf-8"></script>
    <script type="text/javascript" src="{{asset('js/sum.js?v=5-20200312-1327') }}" charset="utf-8"></script>
@endpush