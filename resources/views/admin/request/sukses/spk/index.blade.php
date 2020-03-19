@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>@lang("spk.index.title")</h3>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>@lang("spk.index.list_transaction")</h2>
                @hasrole('Owner|Ultimate|Production')
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/spk/new';">@lang("spk.index.new_btn")
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
                                <th class="column-title">@lang("spk.index.table.col_1")</th>
                                <th class="column-title">@lang("spk.index.table.col_2")</th>
                                <th class="column-title">@lang("spk.index.table.col_3")</th>
                                <th class="column-title">@lang("spk.index.table.col_4")</th>
                                <th class="column-title">@lang("spk.index.table.col_5")</th>
                                <th class="column-title">@lang("spk.index.table.col_6")</th>
                                <th class="column-title">@lang("spk.index.table.col_7")</th>
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
<script src="{{ asset('js/request/sukses/spk/dataTable.js?v=5-20200319-0916') }}" charset="utf-8"></script>
@endpush