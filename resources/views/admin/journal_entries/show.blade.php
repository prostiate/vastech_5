@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3><b>Journal Entry #{{$je->number}}</b></h3>
                <a>Status: </a>
                @if($je->status == 1)
                <span class="label label-warning" style="color:white;">Open</span>
                @elseif($je->status == 2)
                <span class="label label-success" style="color:white;">Closed</span>
                @elseif($je->status == 3)
                <span class="label label-success" style="color:white;">Paid</span>
                @elseif($je->status == 4)
                <span class="label label-warning" style="color:white;">Partial</span>
                @elseif($je->status == 5)
                <span class="label label-danger" style="color:white;">Overdue</span>
                @elseif($je->status == 6)
                <span class="label label-success" style="color:white;">Sent</span>
                @elseif($je->status == 7)
                <span class="label label-success" style="color:white;">Active</span>
                @elseif($je->status == 8)
                <span class="label label-success" style="color:white;">Sold</span>
                @elseif($je->status == 9)
                <span class="label label-success" style="color:white;">Disposed</span>
                @endif
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Transaction Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$je->transaction_date}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Transaction No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$je->number}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group tiles"></div>
                    <br>
                    <div class="table-responsive my-5">
                        <table id="example" class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title" style="width: 400px">Account Number</th>
                                    <th class="column-title">Description</th>
                                    <th class="column-title">Debit</th>
                                    <th class="column-title">Credit</th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                @foreach($je_item as $item)
                                <tr>
                                    <td>
                                        {{$item->coa->code}} - {{$item->coa->name}} ({{$item->coa->coa_category->name}})
                                    </td>
                                    <td>
                                        {{$item->desc}}
                                    </td>
                                    <td>
                                        <?php echo 'Rp ' . number_format($item->debit, 2, ',', '.') ?>
                                    </td>
                                    <td>
                                        <?php echo 'Rp ' . number_format($item->credit, 2, ',', '.') ?>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">Memo</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$je->memo}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="text-center">Total Debit</h5>
                                        <h5 class="text-center"><?php echo 'Rp ' . number_format($je->total_debit, 2, ',', '.') ?></h5>
                                    </div>
                                    <div class="col-md-4 float-right">
                                        <h5 class="text-center">Total Credit</h5>
                                        <h5 class="text-center"><?php echo 'Rp ' . number_format($je->total_credit, 2, ',', '.') ?></h5>
                                        <div class="form-group tile"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-3 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/chart_of_accounts') }}" class="btn btn-dark">Cancel</a>
                            <div class="btn-group">
                                @if(Auth::user()->company_id == 5)
                                @if(Auth::user()->id == 999999)
                                @endif
                                @endif
                                <button class="btn btn-success" type="button" onclick="window.location.href = '/journal_entry/edit';">Edit
                                </button>
                            </div>
                            <input type="text" value="" id="form_id" hidden>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection