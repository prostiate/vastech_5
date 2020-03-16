@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>@lang('construction.edit_bp_area.title')</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('construction.edit_bp_area.number')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$header->number}}" class="form-control" type="text" name="trans_no" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('construction.edit_bp_area.date')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$header->date}}" type="text" class="form-control" name="date" id="datepicker1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('construction.edit_bp_area.project_name')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$header->project->name}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('construction.edit_bp_area.address')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$header->address}}" class="form-control" type="text" name="address">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="table-responsive">
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title text-center">@lang('construction.edit_bp_area.table.col_1')</th>
                                    <th class="column-title" style="width: 50px"></th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                @foreach($header->budget_plan_area as $item)
                                @if($loop->first)
                                <tr>
                                    <td>
                                        <input value="{{$item->name}}" onClick="this.select();" type="text" class="form-control" name="name[]">
                                    </td>
                                    <td>
                                        <input type="button" class="btn btn-dark add" value="+">
                                    </td>
                                </tr>
                                @else
                                <tr>
                                    <td>
                                        <input value="{{$item->name}}" onClick="this.select();" type="text" class="form-control" name="name[]">
                                    </td>
                                    <td>
                                        <input type="button" class="btn btn-danger delete" value="x">
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                            <button class="btn btn-primary" type="button" onclick="window.location.href = '/construction/budget_plan';">@lang('construction.edit_bp_area.cancel')</button>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">@lang('construction.edit_bp_area.update')</button>
                                <input type="text" name="hidden_id" value="{{$header->id}}" hidden>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/construction/budget_plans/addmoreitemArea.js?v=5-20200315-0243') }}" charset="utf-8"></script>
<script src="{{asset('js/construction/budget_plans/updateFormArea.js?v=5-20200315-0243') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200315-0243') }}" charset="utf-8"></script>
@endpush