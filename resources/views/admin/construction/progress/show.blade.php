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
                            <li><a href="#">Create Bill Quantities</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Archive</a></li>
                        </ul>
                    </li>
                </ul>
                <h3>
                    <b>Form Order #{{$header->number}}</b>
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
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Number</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$header->number}}" class="form-control" type="text" name="trans_no" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$header->date}}" type="text" class="form-control" name="date" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Form Order Name</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$header->name}}" class="form-control" type="text" name="name" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Address</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$header->address}}" class="form-control" type="text" name="address" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Budget Plan No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/construction/budget_plan/{{$header->id}}">{{$header->number}}</a></h5>
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
                                        <th class="column-title" style="width: 350px; text-align: center">{{$item[0]->budget_plan_detail->offering_letter_detail->name}}</th>
                                        <th class="column-title" style="width: 350px; text-align: center"></th>
                                        <th class="column-title" style="width: 350px; text-align: center"></th>
                                        <th class="column-title" style="width: 50px"></th>
                                        <th class="column-title" style="width: 50px"></th>
                                    </tr>
                                </thead>
                                <tr class="headings">
                                    <th class="column-title" style="width: 350px">Pekerjaan</th>
                                    <th class="column-title" style="width: 150px">Durasi (bulan)</th>
                                    <th class="column-title" style="width: 150px">Waktu (bulan)</th>
                                    <th class="column-title" style="width: 350px">Progress Real (%)</th>
                                    <th class="column-title" style="width: 350px">Keterlambatan (%)</th>
                                </tr>
                                @foreach($item as $item)
                                <tbody class="neworderbody">
                                    <tr>
                                        <td>
                                            {{$item->budget_plan_detail->name}}
                                        </td>
                                        <td>
                                            {{$item->budget_plan_detail->duration}}
                                        </td>
                                        <td>
                                            {{$item->progress_current_in_month}}
                                        </td>
                                        <td>
                                            {{$item->progress_current_in_percent}}
                                        </td>
                                        <td>
                                            {{$item->progress_lateness_in_percent}}
                                        </td>
                                    </tr>
                                </tbody>
                                @endforeach
                                <tr>
                                    <td colspan="3" style="text-align: right">

                                    </td>
                                    <td colspan="2">

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{--
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                                <button class="btn btn-primary" type="button" onclick="window.location.href = '/construction/bill_quantities/{{$header->id}}';">Cancel</button>
                                <div class="btn-group">
                                    <button id="click" type="button" class="btn btn-success">Create</button>
                                </div>
                            </div>
                        </div>
                    --}}
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/construction/budget_plans/addmoreitem.js?v=5-20200221-1431') }}" charset="utf-8"></script>
<script src="{{asset('js/construction/budget_plans/createForm.js?v=5-20200221-1431') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200221-1431') }}" charset="utf-8"></script>
@endpush
