@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false">Actions
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            @if($header->is_approved == 1)
                                @if($check_bill_quantities)
                                    @if($check_bill_quantities->is_approved == 0)
                                    <li><a href="/construction/bill_quantities/edit/budget_plan={{$header->id}}">Edit Draft Bill Quantities</a></li>
                                    <li class="divider"></li>
                                    @endif
                                @else
                                    <li><a href="/construction/bill_quantities/new/budget_plan={{$header->id}}">Create Bill Quantities</a></li>
                                    <li class="divider"></li>
                                @endif
                            @else
                            <li><a id="click" href="">Approve this</a></li>
                            <li class="divider"></li>
                            @endif
                            <li><a href="#">Archive</a></li>
                        </ul>
                    </li>
                </ul>
                <h3>
                    <b>Budget Plan #{{$header->number}}</b>
                    - @if($header->is_approved == 1)
                    <span class="label label-success" style="color:white;">Approved</span>
                    @else
                    <span class="label label-warning" style="color:white;">Not Approved</span>
                    @endif
                </h3>
                <a>Status: </a>
                @if($header->status == 1)
                <span class="label label-warning" style="color:white;">Open</span>
                @elseif($header->status == 2)
                <span class="label label-success" style="color:white;">Closed</span>
                @elseif($header->status == 3)
                <span class="label label-success" style="color:white;">Paid</span>
                @elseif($header->status == 4)
                <span class="label label-warning" style="color:white;">Partial</span>
                @elseif($header->status == 5)
                <span class="label label-danger" style="color:white;">Overdue</span>
                @elseif($header->status == 6)
                <span class="label label-success" style="color:white;">Sent</span>
                @elseif($header->status == 7)
                <span class="label label-success" style="color:white;">Active</span>
                @elseif($header->status == 8)
                <span class="label label-success" style="color:white;">Sold</span>
                @elseif($header->status == 9)
                <span class="label label-success" style="color:white;">Disposed</span>
                @endif
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <input type="text" value="{{$header->id}}" id="hidden_id" hidden>
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Number</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$header->number}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Date *</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$header->date}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Budget Plan Name *</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$header->name}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Address *</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$header->address}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Offering Letter No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/construction/offering_letter/{{$header->offering_letter->id}}">{{$header->offering_letter->number}}</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="table-responsive">
                        <table class="table table-striped jambo_table bulk_action">
                            <tbody>
                                @foreach($grouped as $item)
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title" style="width: 350px; text-align: center" data-toggle="tooltip" data-placement="top" data-original-title="Working Description">{{$item[0]->offering_letter_detail->name}}</th>
                                        <th class="column-title" style="width: 350px; text-align: center" data-toggle="tooltip" data-placement="top" data-original-title="Specification">{{$item[0]->offering_letter_detail->specification}}</th>
                                        <th class="column-title" style="width: 350px; text-align: center" data-toggle="tooltip" data-placement="top" data-original-title="Offering Total Price"><?php echo 'Rp ' . number_format($item[0]->offering_letter_detail->amount, 2, ',', '.') ?></th>
                                    </tr>
                                </thead>
                                <tr class="headings">
                                    <th class="column-title" style="width: 350px; text-align: center">Working Detail</th>
                                    <th class="column-title" style="width: 150px; text-align: center">Duration (bulan)</th>
                                    <th class="column-title" style="width: 350px; text-align: center">Price</th>
                                </tr>
                                <?php $subtotal = 0; ?>
                                @foreach($item as $item)
                                <?php $subtotal += $item->amount; ?>
                            <tbody class="neworderbody">
                                <tr>
                                    <td>
                                        {{$item->name}}
                                    </td>
                                    <td style="text-align: center">
                                        {{$item->duration}}
                                    </td>
                                    <td style="text-align: right">
                                        <strong><?php echo 'Rp ' . number_format($item->amount, 2, ',', '.') ?></strong>
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach
                            <tr>
                                <td colspan="2" style="text-align: right">
                                    <strong>Sub Total</strong>
                                </td>
                                <td style="text-align: right">
                                    <strong><?php echo 'Rp ' . number_format($subtotal, 2, ',', '.') ?></strong>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot hidden>
                                <tr>
                                    <td colspan="2" style="text-align: right">
                                        <strong>Grand Total</strong>
                                    </td>
                                    <td style="text-align: center">
                                        <strong><?php echo 'Rp ' . number_format($header->grandtotal, 2, ',', '.') ?></strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @if($header->is_approved == 0)
                    <div class="form-group" style="text-align: center">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input value="{{$header->id}}" type="text" id="form_id" hidden>
                            <button type="button" class="btn btn-danger" id="clickDelete">Delete</button>
                            <button class="btn btn-primary" type="button" onclick="window.location.href = '/construction/offering_letter/{{$header->offering_letter->id}}';">Cancel</button>
                            <div class="btn-group">
                                <button class="btn btn-success" type="button" onclick="window.location.href = '/construction/budget_plan/edit/offering_letter={{$header->offering_letter->id}}';">Edit</button>
                            </div>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/construction/budget_plans/approval.js?v=5-20200302-1755') }}" charset="utf-8"></script>
<script src="{{asset('js/construction/budget_plans/deleteForm.js?v=5-20200302-1755') }}" charset="utf-8"></script>
@endpush