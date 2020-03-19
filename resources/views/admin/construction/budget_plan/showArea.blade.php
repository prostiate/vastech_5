@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false">@lang('construction.show_bp_area.action.action')
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a id="{{$header->id}}" onclick="modalSelectedArea(this.id);">@lang('construction.show_bp_area.action.col_5')</a></li>
                            <li><a id="clickApprove">@lang('construction.show_bp_area.action.col_4')</a></li>
                            <li class="divider"></li>
                            <li><a id="clickArchive">@lang('construction.show_bp_area.action.col_3')</a></li>
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
                            <div class="modal fade modal_selected_area" id="modal_selected_area" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                            </button>
                                            <h3 class="modal-title" id="myModalLabel"><strong><span id="span_title"></span></strong></h3>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-horizontal form-label-left">
                                                <div class="form-group row">
                                                    <label>@lang('construction.index_project.name')</label>
                                                    <input type="text" id="input_id_selected_area" name="input_id_selected_area">
                                                    <input type="text" id="input_id_budget_plan" name="input_id_budget_plan">
                                                    <input type="text" id="input_name_selected_area" name="input_name_selected_area" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-dark" data-dismiss="modal">@lang('construction.show_bp_area.close')</button>
                                            <button type="button" class="btn btn-primary" id="clickExecute"><span id="span_execute"></span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @foreach($header->budget_plan_area as $item)
                            <thead>
                                <tr class="headings">
                                    <th colspan="4" class="column-title text-center">
                                        <h4><a href="/construction/budget_plan/new/area_id={{$item->id}}" style="color:whitesmoke;border-bottom: 1px dotted white;">{{$item->name}}</a></h4>
                                    </th>
                                    <th class="column-title text-center">
                                        <ul class="nav navbar-right panel_toolbox">
                                            @if($item->budget_plan_detail->count() > 0)
                                            <li><a href='/construction/budget_plan/new/area_id={{$item->id}}' class="btn btn-dark">
                                                    @lang('construction.show_bp_area.table.col_3')
                                                </a>
                                            </li>
                                            <li>
                                                <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false"><span class="glyphicon glyphicon-wrench"></span>
                                                </button>
                                                <ul role="menu" class="dropdown-menu">
                                                    <li><a id="{{$item->id}}" name="{{$item->name}}" onclick="modalSelectedArea(this.id, this.name);">@lang('construction.show_bp_area.action.col_1')</a></li>
                                                    <li class="divider"></li>
                                                    <li><a id="{{$item->id}}" onclick="emptySelectedArea(this.id);">@lang('construction.show_bp_area.action.col_6')</a></li>
                                                </ul>
                                            </li>
                                            @else
                                            <li><a href='/construction/budget_plan/new/area_id={{$item->id}}' class="btn btn-dark">
                                                    @lang('construction.show_bp_area.table.col_2')
                                                </a>
                                            </li>
                                            <li>
                                                <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false"><span class="glyphicon glyphicon-wrench"></span>
                                                </button>
                                                <ul role="menu" class="dropdown-menu">
                                                    <li><a id="{{$item->id}}" name="{{$item->name}}" onclick="modalSelectedArea(this.id, this.name);">@lang('construction.show_bp_area.action.col_1')</a></li>
                                                    <li class="divider"></li>
                                                    <li><a id="clickDeleteSelectedArea" value="{{$item->id}}">@lang('construction.show_bp_area.action.col_2')</a></li>
                                                </ul>
                                            </li>
                                            @endif
                                        </ul>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th class="text-center" style="width: 350px">@lang('construction.create_bp.table.col_1')</th>
                                    <th class="text-center" style="width: 350px">@lang('construction.create_bp.table.col_2')</th>
                                    <th class="text-center" style="width: 350px">@lang('construction.create_bp.table.col_3')</th>
                                    <th class="text-center" style="width: 350px">@lang('construction.create_bp.table.col_4')</th>
                                    <th class="text-center" style="width: 350px">@lang('construction.create_bp.table.col_5')</th>
                                </tr>
                                @if($item->budget_plan_detail->count() > 0)
                                <?php $subtotal = 0; ?>
                                @foreach($item->budget_plan_detail as $item2)
                                <tr>
                                    <td class="text-center"><a href="/products/{{$item2->product_id}}">{{$item2->product->name}}</a></td>
                                    <td class="text-center"><a href="/other/units/{{$item2->unit_id}}">{{$item2->unit->name}}</a></td>
                                    <td class="text-center">{{$item2->qty}}</td>
                                    <td class="text-center"><?php echo 'Rp ' . number_format($item2->amount, 2, ',', '.') ?></td>
                                    <td class="text-center"><?php echo 'Rp ' . number_format($item2->amounttotal, 2, ',', '.') ?></td>
                                    <?php $subtotal += $item2->amounttotal; ?>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-center"><strong>@lang('construction.create_bp.table.col_6')</strong></td>
                                    <td class="text-center"><strong><?php echo 'Rp ' . number_format($subtotal, 2, ',', '.') ?></strong></td>
                                </tr>
                                @else
                                <tr>
                                    <td colspan="5" class="text-center">Data is not available.</td>
                                </tr>
                                @endif
                            </tbody>
                            @endforeach
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
<script src="{{asset('js/construction/budget_plans/showAreaForm.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script>
    function modalSelectedArea(id, name) {
        $("#modal_selected_area").modal("show");
        if (name) {
            $("#input_id_selected_area").val(id);
            $("#input_name_selected_area").val(name);
            $("#input_id_budget_plan").val('');
            $("#span_title").html("@lang('construction.show_bp_area.span_title2')");
            $("#span_execute").html("@lang('construction.show_bp_area.update')");
        } else {
            $("#input_id_selected_area").val('');
            $("#input_name_selected_area").val('');
            $("#input_id_budget_plan").val(id);
            $("#span_title").html("@lang('construction.show_bp_area.span_title1')");
            $("#span_execute").html("@lang('construction.show_bp_area.add')");
        }
    };
</script>
@endpush