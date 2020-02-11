@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Surat Perintah Kerja</h3>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>List of Surat Perintah Kerja</h2>
                @hasrole('Owner|Ultimate|Production')
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/spk/new';">New SPK
                        </button>
                    </li>
                </ul>
                @endrole
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action" id="dataTable" style="width:100%">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Transaction Date</th>
                                <th class="column-title">Number</th>
                                <th class="column-title">SPK Ref No</th>
                                <th class="column-title">Contact</th>
                                <th class="column-title">Warehouse</th>
                                <th class="column-title">Note</th>
                                <th class="column-title">Status</th>
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
<script src="{{ asset('js/request/sukses/spk/dataTable.js?v=5-20200211-1624') }}" charset="utf-8"></script>
@endpush