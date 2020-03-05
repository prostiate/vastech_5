@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
                <div class="x_title">
                    <h2>Opening Balance</h2>
                    <div class="clearfix"></div>
                </div>
            <div class="x_content">
                <form id="formCreate" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                    <div class="col-md-3 col-sm-2 col-xs-2">
                    </div>
                    <div class="col-md-6 col-sm-2 col-xs-2" style="text-align:center">
                        <p> Please set the date of your migration or the day you will start using Vastech Cloud </p>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label col-md-3">Conversion Date</label>
                                <div class="col-md-7" style="text-align:center">
                                    @if($ob)
                                    <input type="text" class="form-control date" name="date" id="datepicker1" value="{{$ob->opening_date}}">
                                    @else
                                    <input type="text" class="form-control date" name="date" id="datepicker1" value="{{$now->format('d-M-Y')}}">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
                                <p> How will conversion date affect your Vastechcloud account? <br>
                                    * You will still be able to enter transactions before conversion date and it will not
                                    affect
                                    your
                                    current balances (balance as at after conversion date) <br>
                                    * You can edit this date as long as you do not have closing book yet
                                </p>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
                                <button class="btn btn-primary" type="button" onclick="window.location.href = '/chart_of_accounts';">Cancel</button>
                                <button id="click" type="submit" class="btn btn-success">View Conversion Balances</button>
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
<!--<script src="{{ asset('js/accounts/dataTableindex.js?v=5-20200305-1546') }}" charset="utf-8"></script>-->
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200305-1546') }}" charset="utf-8"></script>
<script src="{{asset('js/accounts/opening_balance/createForm.js?v=5-20200305-1546') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200305-1546') }}" charset="utf-8"></script>
<script src="{{asset('js/other/duedate_format.js?v=5-20200305-1546') }}" charset="utf-8"></script>
@endpush
