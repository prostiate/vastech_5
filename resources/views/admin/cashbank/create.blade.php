@extends('layouts.admin')
@section('content')

<div class="dashboard-wrapper">

    <!-- ============================================================== -->
    <!-- pageheader  -->
    <!-- ============================================================== -->
    <div class="row form-page-header">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
            <div id="top">
                <small>Register</small>
                <h1>New Account</h1>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end pageheader  -->
    <!-- ============================================================== -->

    <div class="container-fluid form-content">
        @csrf
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <form>
                    <div class="form-group row">
                        <label for="emailForm" class="col-lg-4 col-form-label">Email</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control form-control-sm" id="emailForm">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="numberForm" class="col-lg-4 col-form-label">Number</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control form-control-sm" id="numberForm">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="descForm" class="col-lg-4">Description</label>
                        <div class="col-lg-8">
                            <textarea class="form-control" id="descForm" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="categoryForm" class="col-lg-4"> Category </label>
                        <div class="col-lg-8">
                            <select class="form-control" id="categoryForm">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="detailForm" class="col-lg-4"> Details </label>
                        <div class="col-lg-8">
                            <select class="form-control" id="detailForm">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="taxForm" class="col-lg-4"> Default Account Tax </label>
                        <div class="col-lg-8">
                            <select class="form-control" id="taxForm">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bankForm" class="col-lg-4"> Bank Name </label>
                        <div class="col-lg-8">
                            <select class="form-control" id="bankForm">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-lg-4 col-lg-8">
                            <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
                            <div class="btn-group dropup">
                                <button type="button" class="btn btn-success">Create & New</button>
                                <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Create & New</a>
                                    <a class="dropdown-item" href="#">Create Account</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">

            </div>
        </div>

    </div>

</div>
</div>
@endsection