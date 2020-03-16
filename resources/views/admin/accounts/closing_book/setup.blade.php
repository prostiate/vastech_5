@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3>Closing Book</h3>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="formCreate" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                    <div class="col-md-3 col-sm-2 col-xs-2">
                    </div>
                    <div class="col-md-6 col-sm-2 col-xs-2">
                        <h4 style="text-align: center"> You will close the book for the financial period: </h4>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">From Date</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <input type="text" class="form-control date" name="start_period" id="datepicker1" value="{{$start_period}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">To
                                    </label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <input type="text" class="form-control date" name="end_period" id="datepicker2" value="{{$end_period}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <h4 style="text-align: center"> After closing the book, you cannot make changes to your book on BEFORE the following dates
                                </h4>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-12 col-sm-6 col-xs-12" style="text-align: center">
                                <button class="btn btn-danger" type="button" onclick="window.location.href = '/chart_of_accounts';">Cancel</button>
                                <button id="click" type="submit" class="btn btn-success">Next</button>
                                @if($id)
                                <input hidden name="hidden_id" value="{{$id}}">
                                @endif
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
<!--<script src="{{ asset('js/accounts/dataTableindex.js?v=5-20200315-0243') }}" charset="utf-8"></script>-->
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200315-0243') }}" charset="utf-8"></script>
<script src="{{asset('js/accounts/closing_book/createForm.js?v=5-20200315-0243') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200315-0243') }}" charset="utf-8"></script>
<script src="{{asset('js/other/duedate_format.js?v=5-20200315-0243') }}" charset="utf-8"></script>
@endpush
