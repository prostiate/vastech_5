@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Edit Payment Method</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <div id="demo-form2" class="form-horizontal form-label-left">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Name
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input value="{{$unit->name}}" type="text" name="name" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                    </div>
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                            <button class="btn btn-dark" type="button" onclick="window.location.href = '/other/payment_methods/' + {{$unit->id}};">Cancel
                            </button>
                            <div class="btn-group">
                                <button id="click" class="btn btn-success" type="button">Edit Payment Method
                                </button>
                                <input value="{{$unit->id}}" type="hidden" name="hidden_id" id="hidden_id" />
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
<script src="{{asset('js/otherlists/payment_methods/updateForm.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200319-0916') }}" charset="utf-8"></script>
@endpush