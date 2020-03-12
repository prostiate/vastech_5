@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>@lang('construction.index_bp.title')</h3>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>@lang('construction.index_bp.list_transaction')</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '#';" data-toggle="modal" data-target=".bs-example-modal-lg-create">@lang('construction.index_bp.new_btn')
                        </button>
                        <div id="create_modal" class="modal fade bs-example-modal-lg-create" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <form method="post" id="formCreate">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                            </button>
                                            <h3 class="modal-title" id="myModalLabel"><strong>@lang('construction.index_bp.title_choose')</strong></h3>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-md-12">
                                                <div class="form-horizontal form-label-left">
                                                    <div class="form-group row">
                                                        <label>@lang('construction.index_bp.name')</label>
                                                        <?php

                                                        use App\Model\construction\project_con;

                                                        $project = project_con::get();
                                                        ?>
                                                        <select name="project_name" id="project_name" class="form-control selectproject">
                                                            @foreach($project as $a)
                                                            <option value="{{$a->id}}">{{$a->name}} - ({{$a->number}})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="col-md-1 center-margin">
                                                <div class="form-horizontal">
                                                    <div class="form-group row">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-dark" data-dismiss="modal">@lang('construction.index_bp.close')</button>
                                            <button type="button" class="btn btn-dark" onclick="next()">@lang('construction.index_bp.next')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action" id="dataTable" style="width:100%">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">@lang('construction.index_bp.table.col_1')</th>
                                <th class="column-title">@lang('construction.index_bp.table.col_2')</th>
                                <th class="column-title">@lang('construction.index_bp.table.col_3')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/other/select2.js?v=5-20200312-1327') }}" charset="utf-8"></script>
<script src="{{ asset('js/construction/budget_plans/dataTable.js?v=5-20200312-1327') }}" charset="utf-8"></script>
<script>
    function next() {
        var id = $('#project_name').val();
        window.location.href = "/construction/budget_plan/newArea/project_id=" + id;
    }
</script>
@endpush