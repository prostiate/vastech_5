@extends('layouts.admin')

@section('content')
<div class="row">
    <form method="post" id="formCreate" class="form-horizontal">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Journal Entry</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Transaction No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$trans_no}}" type="text" class="form-control" readonly name="trans_no">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Transaction Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$today}}" type="date" class="form-control trans_date" id="datepicker1" name="trans_date">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group tiles"></div>
                    <br>
                    <div class="table-responsive my-5">
                        <table id="example" class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title" style="width: 400px">Account</th>
                                    <th class="column-title">Description</th>
                                    <th class="column-title" style="width: 250px">Debit</th>
                                    <th class="column-title" style="width: 250px">Credit</th>
                                    <th class="column-title" style="width: 50px"></th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control account_id selectaccount" name="account[]">
                                                <option></option>
                                                @foreach ($coa as $a)
                                                <option value="{{$a->id}}">
                                                    ({{$a->code}}) - {{$a->name}} ({{$a->coa_category->name}})
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <textarea class="form-control" rows="1" name="desc[]"></textarea>
                                    </td>
                                    <td>
                                        <input onClick="this.select();" type="text" class="debita_display form-control">
                                        <input type="text" class="debita form-control" name="debit[]" hidden>
                                        <input type="text" class="deb" hidden>
                                    </td>
                                    <td>
                                        <input onClick="this.select();" type="text" class="credita_display form-control">
                                        <input type="text" class="credita form-control" name="credit[]" hidden>
                                        <input type="text" class="cre" hidden>
                                    </td>
                                    <td>
                                        <input type="button" class="btn btn-danger delete" value="x">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="button" class="btn btn-dark add" value="+ Add More Item">
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">Memo</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea class="form-control" name="memo" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="text-center">Total Debit</h5>
                                        <h5 class="total_debit text-center">0.00</h5>
                                        <input type="text" class="total_debit_input" name="total_debit" hidden>
                                    </div>
                                    <div class="col-md-4 float-right">
                                        <h5 class="text-center">Total Credit</h5>
                                        <h5 class="total_credit text-center">0.00</h5>
                                        <input type="text" class="total_credit_input" name="total_credit" hidden>
                                        <div class="form-group tile"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-3 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/journal_entry/show') }}" class="btn btn-danger">Cancel</a>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/journal_entry/createForm.js?v=5-20200302-1755') }}" charset="utf-8"></script>
<script src="{{asset('js/journal_entry/addmoreitem_journal_entry.js?v=5-20200302-1755') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200302-1755') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200302-1755') }}" charset="utf-8"></script>
@endpush