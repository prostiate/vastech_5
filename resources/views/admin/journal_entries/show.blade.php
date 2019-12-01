@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3><b>Journal Entry #</b></h3>
                <a>Status: </a>
                <span class="label label-success" style="color:white;">Closed</span>
                <div class="clearfix"></div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Transaction Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5></h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Transaction No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5></h5>
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
                                    <th class="column-title" style="width: 400px">Account Number</th>
                                    <th class="column-title">Account</th>
                                    <th class="column-title">Description</th>
                                    <th class="column-title text-right">Debit</th>
                                    <th class="column-title text-right">Credit</th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <h5></h5>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <h5></h5>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <h5></h5>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <h5></h5>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <h5></h5>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">Memo</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5></h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="text-center">Total Debit</h5>
                                        <h5 class="text-center">0.00</h5>
                                    </div>
                                    <div class="col-md-4 float-right">
                                        <h5 class="subtotal text-center">Total Credit</h5>
                                        <input type="text" class="subtotal_input" name="subtotal" hidden>
                                        <h5 class="subtotal text-center">0.00</h5>
                                        <input type="text" class="subtotal_input" name="subtotal" hidden>
                                        <div class="form-group tile"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-3 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/chart_of_accounts') }}" class="btn btn-dark">Cancel</a>
                            <div class="btn-group">
                                <button class="btn btn-success" type="button" onclick="window.location.href = '/journal_entry/edit';">Edit
                                </button>
                            </div>
                            <input type="text" value="" id="form_id" hidden>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection