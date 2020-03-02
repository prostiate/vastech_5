@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Audit List</h3>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
           <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action" id="dataTable" style="width:100%">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">User Id </th>
                                <th class="column-title">Event </th>
                                <th class="column-title">Type Audit </th>
                                <th class="column-title">Old Value </th>
                                <th class="column-title">New Value </th>
                                <th class="column-title">IP Address </th>
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
<script src="{{ asset('js/otherlists/audits/dataTable.js?v=5-20200302-1755') }}" charset="utf-8"></script>
@endpush
