@extends('layouts.admin')
@section('content')

<div class="dashboard-wrapper">

    <!-- ============================================================== -->
    <!-- pageheader  -->
    <!-- ============================================================== -->
    <div class="row form-page-header">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
            <div id="top">
                <small>Report</small>
                <h1>List Barang </h1>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end pageheader  -->
    <!-- ============================================================== -->

    <div class="container-fluid form-content">
        <div class="row">
            @csrf
            <div class="col-lg-6">
                <h3> Account Transactions </h3>
            </div>
            <div class="col-lg-6">
                <h4>Transaction date between</h4>
            </div>
        </div>

        <div class="table my-5">
            <table id="example" class="table table-bordered second">
                <thead class="bg-primary">
                    <tr>
                        <th style="color:whitesmoke;">Transaction No </th>
                        <th style="color:whitesmoke;">Product</th>
                        <th style="color:whitesmoke;">Qty</th>
                        <th style="color:whitesmoke;">Buy Unit Price (in IDR)</th>
                        <th style="color:whitesmoke;">Sell Credit Price (in IDR)</th>
                        <th style="color:whitesmoke;">Balance (in IDR)</th>
                    </tr>
                </thead>
                <tbody>                    
                    <tr>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{asset('js/multiply.js?v=5-20200217-1409') }}" charset="utf-8"></script>
<script type="text/javascript" src="{{asset('js/sum.js?v=5-20200217-1409') }}" charset="utf-8"></script>
@endpush