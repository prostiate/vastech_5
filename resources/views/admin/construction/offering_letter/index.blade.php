@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Offering Letter</h3>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>List of Offering Letter</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/construction/offering_letter/new';">New Offering Letter
                        </button>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action" id="dataTable" style="width:100%">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Name</th>
                                <th class="column-title">Address</th>
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
<script src="{{ asset('js/construction/offering_letters/dataTable.js?v=5-20200221-1431') }}" charset="utf-8"></script>
@endpush