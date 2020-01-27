@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Contact Others</h3>
    </div>
    {{-- notifikasi form validasi --}}
    @if ($errors->has('file'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('file') }}</strong>
    </span>
    @endif
    {{-- notifikasi form error --}}
    @if ($error = Session::get('error'))
    <div class="alert alert-error alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $error }}</strong>
    </div>
    @endif
    {{-- notifikasi sukses --}}
    @if ($sukses = Session::get('sukses'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $sukses }}</strong>
    </div>
    @endif
    <!--<div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Go!</button>
                </span>
            </div>
        </div>
    </div>-->
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>List of Contacts</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        @hasrole('Owner|Ultimate|Contact')
                        @can('Create')
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/contacts/new';">New Contact
                        </button>
                        @endcan
                        @endrole
                        <button data-toggle="dropdown" class="btn btn-dark mr-5 dropdown-toggle" type="button" aria-expanded="false"><span class="glyphicon glyphicon-wrench"></span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="/contacts/export_excel">Export as Excel</a>
                            </li>
                            <li><a href="/contacts/export_csv">Export as CSV</a>
                            </li>
                            <li><a target="_blank" href="/contacts/export_pdf">Export as PDF</a>
                            </li>
                            <li class="divider"></li>
                            @hasrole('Owner|Ultimate|Contact')
                            @can('Create')
                            <li><a data-toggle="modal" data-target="#importExcel">Import from Excel</a>
                            </li>
                            @endcan
                            @endrole
                        </ul>
                        <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form method="post" action="/contacts/import_excel" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                                        </div>
                                        <div class="modal-body">
                                            {{ csrf_field() }}
                                            <label>Pilih file excel</label>
                                            <div class="form-group">
                                                <input type="file" name="file" required="required">
                                            </div>
                                            <a href="{{ url('/file_contact/SampleContact.xlsx') }}">Download Sample</a>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Import</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action" id="dataTable" style="width:100%">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Company Name</th>
                                <th class="column-title">Name</th>
                                <th class="column-title">Billing Address</th>
                                <th class="column-title">Shipping Address</th>
                                <th class="column-title">Email</th>
                                <th class="column-title">Phone</th>
                                <th class="column-title">Limit Balance</th>
                                <th class="column-title">Current Limit Balance</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/contacts/other/dataTable.js?v=5-27012020') }}" charset="utf-8"></script>
@endpush