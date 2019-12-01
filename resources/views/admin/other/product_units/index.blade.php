@extends('layouts.admin')
@section('content')

<div class="dashboard-wrapper">
    <!-- ============================================================== -->
    <!-- pageheader  -->
    <!-- ============================================================== -->
    <div class="row page-header">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
            <div id="top">
                <small>Other List </small>
                <h2 class="pageheader-title">Product Units</h2>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
            <div class="float-right">
                <a class="btn btn-success" href=" {{url('/product_units/create')}}">
                    <i class="fas fa-plus"> </i>
                    Create Product Unit
                </a>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end pageheader  -->
    <!-- ============================================================== -->


    <!-- ============================================================== -->
    <!-- simple cards  -->
    <!-- ============================================================== -->
    <div class="container-fluid dashboard-content">
        <div class="card">
            <div class="card-body ">
                <div class="table mt-4">
                    <table id="example" class="table table-striped second">
                        <thead class="bg-primary">
                            <tr>
                                <th style="color:whitesmoke;">Name</th>
                                <th style="color:whitesmoke;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($units as $unit)
                            <tr>
                                <td>{{$unit->name}}</td>
                                <td><a href="" style="color:#876;">Sales Invoice
                                    </a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>

</div>
<!-- ============================================================== -->
<!-- end simple cards  -->
<!-- ============================================================== -->
</div>

</div>
</div>

@endsection