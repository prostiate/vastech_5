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
                    <li>
                        <button data-toggle="dropdown" class="btn btn-dark mr-5 dropdown-toggle" type="button" aria-expanded="false"><span class="glyphicon glyphicon-wrench"></span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a data-toggle="modal" data-target="#setupAccounts">Setup Accounts</a>
                            </li>
                            <li><a href="/products/export_csv">Set Opening Balance</a>
                            </li>
                            <li><a target="_blank" href="/products/export_pdf">Closing Book</a>
                            </li>
                            <li class="divider"></li>
                            <li><a data-toggle="modal" data-target="#importExcel">Import Journal Entry</a>
                            <li><a data-toggle="modal" data-target="#exportExcel">Export Accounts</a>
                        </ul>
                        <div class="modal fade" id="setupAccounts" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form method="post" action="/products/import_excel" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Setup Accounts</h5>
                                        </div>
                                        <div class="modal-body">
                                            {{ csrf_field() }}
                                            <label>Pilih file excel</label>
                                            <div class="form-group">
                                                <input type="file" name="file" required="required">
                                            </div>
                                            <a href="{{ url('/file_product/SampleProduct.xlsx') }}">Download Sample</a>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Import</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form method="post" action="/products/import_excel" enctype="multipart/form-data">
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
                                            <a href="{{ url('/file_product/SampleProduct.xlsx') }}">Download Sample</a>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Import</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal fade" id="exportExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form method="post" action="/products/import_excel" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Export Account</h5>
                                        </div>
                                        <div class="modal-body">
                                            {{ csrf_field() }}
                                            <label>Pilih file excel</label>
                                            <div class="form-group">
                                                <input type="file" name="file" required="required">
                                            </div>
                                            <a href="{{ url('/file_product/SampleProduct.xlsx') }}">Download Sample</a>
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
<!--<script src="{{ asset('js/accounts/dataTableindex.js?v=5-03022020') }}" charset="utf-8"></script>-->
@endpush