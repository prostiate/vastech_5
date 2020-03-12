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
                    <b>@lang('construction.show_bp.title'){{$header->number}}</b>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('construction.show_bp.number')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$header->number}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('construction.show_bp.date')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$header->date}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('construction.show_bp.project_name')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$header->project->name}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('construction.show_bp.address')</label>
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
                                    <th class="column-title" style="width: 350px">@lang('construction.show_bp.table.col_1')</th>
                                    <th class="column-title" style="width: 150px">@lang('construction.show_bp.table.col_2')</th>
                                    <th class="column-title" style="width: 150px">@lang('construction.show_bp.table.col_3')</th>
                                    <th class="column-title text-center" style="width: 350px">@lang('construction.show_bp.table.col_4')</th>
                                    <th class="column-title text-center" style="width: 350px">@lang('construction.show_bp.table.col_5')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($header->budget_plan_detail as $item)
                                <tr>
                                    <td>
                                        <h5><a href="/products/{{$item->product_id}}">{{$item->product->name}}</a></h5>
                                    </td>
                                    <td>
                                        <h5>{{$item->unit->name}}</h5>
                                    </td>
                                    <td>
                                        <h5>{{$item->qty}}</h5>
                                    </td>
                                    <td class="text-center">
                                        <h5><?php echo 'Rp ' . number_format($item->amount, 2, ',', '.') ?></h5>
                                    </td>
                                    <td class="text-center">
                                        <h5><?php echo 'Rp ' . number_format($item->amounttotal, 2, ',', '.') ?></h5>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($header->is_approved == 0)
                    <div class="form-group" style="text-align: center">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input value="{{$header->id}}" type="text" id="form_id" hidden>
                            <button type="button" class="btn btn-danger" id="clickDelete">@lang('construction.show_bp.delete')</button>
                            <button class="btn btn-primary" type="button" onclick="window.location.href = '/construction/budget_plan';">@lang('construction.show_bp.cancel')</button>
                            <div class="btn-group">
                                <button class="btn btn-success" type="button" onclick="window.location.href = '/construction/budget_plan/edit/{{$header->id}}';">@lang('construction.show_bp.edit')</button>
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
<script src="{{asset('js/construction/budget_plans/approval.js?v=5-20200312-1327') }}" charset="utf-8"></script>
<script src="{{asset('js/construction/budget_plans/deleteForm.js?v=5-20200312-1327') }}" charset="utf-8"></script>
@endpush