@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Chart of Accounts</h3>
    </div>
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
                <h2>List of Accounts</h2>
                <ul class="nav navbar-right panel_toolbox">
                    @role('Owner|Ultimate|Chart of Account')
                    @can('Create')
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/chart_of_accounts/journal_entry/new';">New Journal Entry
                        </button>
                    </li>
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/chart_of_accounts/new';">New Account
                        </button>
                    </li>
                    @endcan
                    @endrole
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action" id="dataTable" style="width:100%">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Account Number </th>
                                <th class="column-title">Account Name </th>
                                <th class="column-title">Category </th>
                                <th class="column-title">Default Tax </th>
                                <th class="column-title" style="text-align: right">Balance </th>
                                <!--<th class="column-title no-link last"><span class="nobr">Action</span>
                                </th>
                                <th class="bulk-actions" colspan="8">
                                    <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                </th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total = 0 ?>
                            <?php $debit = 0 ?>
                            <?php $credit = 0 ?>
                            @foreach ($coa as $a)
                            @foreach($coa_detail as $cd)
                            @if($cd->coa_id == $a->id)
                            <?php $debit += $cd->debit ?>
                            <?php $credit += $cd->credit ?>
                            @endif
                            @endforeach
                            <tr>
                                <td>
                                    <a>{{$a->code}}</a>
                                </td>
                                <td>
                                    <a href="/chart_of_accounts/{{$a->id}}">{{$a->name}}</a>
                                </td>
                                <td>
                                    <a>{{$a->coa_category->name}}</a>
                                </td>
                                <td>
                                    <a>{{$a->default_tax}}</a>
                                </td>
                                <td style="text-align: right">
                                    @if($a->coa_category_id == 8 or $a->coa_category_id == 10 or $a->coa_category_id == 11 or $a->coa_category_id == 12 or $a->coa_category_id == 13 or $a->coa_category_id == 14)
                                    <?php $total = $credit - $debit ?>
                                    @else
                                    <?php $total = $debit - $credit ?>
                                    @endif
                                    @if($total < 0) <a>Rp (@number(abs($total)))</a>
                                        @else
                                        <a>Rp @number($total)</a>
                                        @endif
                                </td>
                            </tr>
                            <?php $total = 0 ?>
                            <?php $debit = 0 ?>
                            <?php $credit = 0 ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!--<script src="{{ asset('js/accounts/dataTableindex.js') }}" charset="utf-8"></script>-->
@endpush