@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>@lang("contact.index.title3")</h3>
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
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>@lang("contact.index.list_transaction3")</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        @hasrole('Owner|Ultimate|Contact')
                        @can('Create')
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/contacts/new';">@lang("contact.index.new_btn")
                        </button>
                        @endcan
                        @endrole
                        <button data-toggle="dropdown" class="btn btn-dark mr-5 dropdown-toggle" type="button" aria-expanded="false"><span class="glyphicon glyphicon-wrench"></span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="/contacts/export_excel">@lang("contact.index.action.action_1")</a>
                            </li>
                            <li><a href="/contacts/export_csv">@lang("contact.index.action.action_2")</a>
                            </li>
                            <li><a target="_blank" href="/contacts/export_pdf">@lang("contact.index.action.action_3")</a>
                            </li>
                            <li class="divider"></li>
                            @hasrole('Owner|Ultimate|Contact')
                            @can('Create')
                            <li><a data-toggle="modal" data-target="#importExcel">@lang("contact.index.action.action_4")</a>
                            </li>
                            @endcan
                            @endrole
                        </ul>
                        <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form method="post" action="/contacts/import_excel" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">@lang("contact.index.action.action_4")</h5>
                                        </div>
                                        <div class="modal-body">
                                            {{ csrf_field() }}
                                            <label>@lang("contact.index.upload")</label>
                                            <div class="form-group">
                                                <input type="file" name="file" required="required">
                                            </div>
                                            <a href="{{ url('/file_contact/SampleContact.xlsx') }}">@lang("contact.index.sample")</a>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang("contact.index.close")</button>
                                            <button type="submit" class="btn btn-primary">@lang("contact.index.import")</button>
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
                                <th class="column-title">@lang("contact.index.table.col_1")</th>
                                <th class="column-title">@lang("contact.index.table.col_2")</th>
                                <th class="column-title">@lang("contact.index.table.col_3")</th>
                                <th class="column-title">@lang("contact.index.table.col_4")</th>
                                <th class="column-title">@lang("contact.index.table.col_5")</th>
                                <th class="column-title">@lang("contact.index.table.col_6")</th>
                                <th class="column-title">@lang("contact.index.table.col_7")</th>
                                <th class="column-title">@lang("contact.index.table.col_8")</th>
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
<script src="{{ asset('js/contacts/employee/dataTable.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<!--{{--<script src="{{ asset('js/contacts/all/chartdiindex.js?v=5-20200319-0916') }}" charset="utf-8"></script>--}}-->
@endpush