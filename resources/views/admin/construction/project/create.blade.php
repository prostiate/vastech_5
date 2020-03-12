@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>@lang('construction.create.title')</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('construction.create.name')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input class="form-control" type="text" name="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('construction.create.number')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input class="form-control" type="text" name="number">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                            <button class="btn btn-primary" type="button" onclick="window.location.href = '/construction/project';">@lang('construction.create.cancel')</button>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">@lang('construction.create.create')</button>
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
<script src="{{asset('js/construction/project/createForm.js?v=5-20200312-1327') }}" charset="utf-8"></script>2
@endpush