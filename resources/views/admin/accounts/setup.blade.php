@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Opening Balance</h3>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <form id="formCreate" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                    <div class="col-md-3 col-sm-2 col-xs-2">
                    </div>
                    <div class="col-md-6 col-sm-2 col-xs-2" style="text-align:center">
                        <p> Please set the date of your migration or the day you will start using Vastech Cloud </p>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12">Conversion Date</label>
                                <div class="col-md-6 col-sm-7 col-xs-12">
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
                            <div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-1">
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
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
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
<!--<script src="{{ asset('js/accounts/dataTableindex.js?v=5-20200211-1624') }}" charset="utf-8"></script>-->
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200211-1624') }}" charset="utf-8"></script>
<script src="{{asset('js/accounts/opening_balance/createForm.js?v=5-20200211-1624') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js')}}" charset="utf-8"></script>
<script src="{{asset('js/other/duedate_format.js')}}" charset="utf-8"></script>
@endpush