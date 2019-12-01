@extends('layouts.admin') 
@section('content')

<div class="dashboard-wrapper">

    <!-- ============================================================== -->
    <!-- pageheader  -->
    <!-- ============================================================== -->
    <div class="row page-header">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
            <div id="top">
                <small> Product Unit </small>
                <h2 class="pageheader-title">Create New Product Unit </h2>
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
         <form method="post" action="{{route('product_units.store')}}">
            <div class="card">
            @csrf
            <div class="card-body">
                <div class="row my-1">
                    <div class="col-sm-2">
                        Name
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" name="name" required>
                    </div>
                </div>                
            </div>
            <div class="form-group row">
                <div class="offset-lg-2 col-lg-3">
                    <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-success">Create Product Unit</button>
                </div>
            </div>
        </div>       
        </form>
    </div>
    <!-- ============================================================== -->
    <!-- end simple cards  -->
    <!-- ============================================================== -->
</div>

</div>
</div>
@endsection