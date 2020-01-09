@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>{{$coa->name}}</h2>
                @role('Owner|Ultimate|Chart of Account')
                @can('Edit')
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/chart_of_accounts/edit/' + {{$coa->id}};">Edit Account
                        </button>
                    </li>
                </ul>
                @endcan
                @endrole
                @role('Owner|Ultimate|Chart of Account')
                @can('Delete')
                @if($coa->id > 143)
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" id="click">Delete Account
                        </button>
                        <input type="text" value="{{$coa->id}}" id="form_id" hidden>
                    </li>
                </ul>
                @endif
                @endcan
                @endrole
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table id="dataTable2" class="table table-striped jambo_table bulk_action" style="width:100%">
                        <thead>
                            <tr class="headings">
                                <th class="column-title" style="width:200px">Transaction Number</th>
                                <th class="column-title" style="width:150px">Transaction Date</th>
                                <th class="column-title" style="width:150px; text-align: center;">Contact</th>
                                <th class="column-title" style="width:100px; text-align: right;">Debit (Rp)</th>
                                <th class="column-title" style="width:150px; text-align: right;">Credit (Rp)</th>
                                <th class="column-title" style="width:150px; text-align: right;">Balance (Rp)</th>
                            </tr>
                        </thead>
                        <input hidden type="text" value="{{$coa->id}}" name="hidden_id" id="hidden_id">
                        <tbody>
                            @foreach ($coa_detail as $i => $coadetail)
                            <tr>
                                <td>
                                    <a>{{$coadetail->number}}</a>
                                </td>
                                <td>
                                    <a>{{$coadetail->date}}</a>
                                </td>
                                <td class="text-center">
                                    @if($coadetail->contact_id == null)
                                    <a></a>
                                    @else
                                    <a href="/contacts/{{$coadetail->contact_id}}">{{$coadetail->contact->display_name}}</a>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a>@number($coadetail->debit)</a>
                                </td>
                                <td class="text-right">
                                    <a>@number($coadetail->credit)</a>
                                </td>
                                @if($coa->coa_category_id == 8 or $coa->coa_category_id == 10 or $coa->coa_category_id == 11 or $coa->coa_category_id == 12 or $coa->coa_category_id == 13 or $coa->coa_category_id == 14)
                                <?php $balance[$i] = $coadetail->credit - $coadetail->debit ?>
                                @if($i == 0)
                                <td class="text-right">
                                    <a>@number($balance[$i])</a>
                                </td>
                                @else
                                <?php $balance[$i] = $balance[$i - 1] + $balance[$i] ?>
                                <td class="text-right">
                                    <a>@number($balance[$i])</a>
                                </td>
                                @endif
                                @else
                                <?php $balance[$i] = $coadetail->debit - $coadetail->credit ?>
                                @if($i == 0)
                                <td class="text-right">
                                    <a>@number($balance[$i])</a>
                                </td>
                                @else
                                <?php $balance[$i] = $balance[$i - 1] + $balance[$i] ?>
                                <td class="text-right">
                                    <a>@number($balance[$i])</a>
                                </td>
                                @endif
                                @endif
                            </tr>
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
<script src="{{ asset('js/accounts/deleteForm.js') }}" charset="utf-8"></script>
@endpush