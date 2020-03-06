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
                            <li><a id="click" href="">Approve this</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Archive</a></li>
                        </ul>
                    </li>
                </ul>
                <h3>
                    <b>@lang('construction.show_bp_area.title'){{$header->number}}</b>
                </h3>
                <a>Status: </a>
                @if($header->is_approved == 1)
                <span class="label label-success" style="color:white;">Approved</span>
                @else
                <span class="label label-warning" style="color:white;">Not Approved</span>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('construction.show_bp_area.number')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$header->number}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('construction.show_bp_area.date')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$header->date}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('construction.show_bp_area.project_name')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$header->project->name}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('construction.show_bp_area.address')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$header->address}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="table-responsive">
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title text-center" style="width: 350px">@lang('construction.show_bp_area.table.col_1')</th>
                                    <th class="column-title" style="width: 50px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($header->budget_plan_area as $item)
                                <tr>
                                    <td class="text-center">
                                        <h5>{{$item->name}}</h5>
                                    </td>
                                    <td class="text-center">
                                        <a href="/construction/budget_plan/new/area_id={{$item->id}}" class="btn btn-dark">@lang('construction.show_bp_area.table.col_2')</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($header->is_approved == 0)
                    <div class="form-group text-center">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input value="{{$header->id}}" type="text" id="form_id" hidden>
                            <button type="button" class="btn btn-danger" id="clickDelete">@lang('construction.show_bp_area.delete')</button>
                            <button class="btn btn-primary" type="button" onclick="window.location.href = '/construction/budget_plan';">@lang('construction.show_bp_area.cancel')</button>
                            <div class="btn-group">
                                <button class="btn btn-success" type="button" onclick="window.location.href = '/construction/budget_plan/editArea/{{$header->id}}';">@lang('construction.show_bp_area.edit')</button>
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
<script src="{{asset('js/construction/budget_plans/approval.js?v=5-20200305-1546') }}" charset="utf-8"></script>
<script src="{{asset('js/construction/budget_plans/deleteFormArea.js?v=5-20200305-1546') }}" charset="utf-8"></script>
@endpush