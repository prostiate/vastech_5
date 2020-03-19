@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        @if($closing_book && $closing_book->status == 7)
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/closing_book/{{$closing_book->id }}/setup';">Start Closing Book
                        </button>
                        @else
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/closing_book/setup';">Start Closing Book
                        </button>
                        @endif
                    </li>
                </ul>
                <h3>Closing Book</h3>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action" id="dataTable">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Period </th>
                                <th class="column-title">Memo </th>
                                <th class="column-title">Net Profit Loss </th>
                                <th class="column-title no-link last"><span class="nobr">Action</span></th>
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
<script src="{{ asset('js/accounts/closing_book/dataTable.js?v=5-20200319-0916') }}" charset="utf-8"></script>
@endpush
