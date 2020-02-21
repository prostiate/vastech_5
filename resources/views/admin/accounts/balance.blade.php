@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <div class="row">
                    <div class="nav navbar-right panel_toolbox">
                        <h3>{{$ob->status}}</h3>
                        <input name="status" value="{{$ob->status}}" hidden>
                    </div>
                    <h3>Opening Balance</h3>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="x_content">
                <form id="formCreate" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                    <div class="row">
                        <div class="col-lg-12 col-md-8 col-sm-8">
                            <h5 class="text-center medium-text">
                                Please enter your opening balances as at
                                <a href="/conversion/setup" style="text-decoration: underline;" data-turbolinks="false">{{$ob->opening_date}}</a>
                                <input name="date" value="{{$ob->opening_date}}" hidden>
                            </h5>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped jambo_table bulk_action" style="width:100%; margin-bottom:0px">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title" style="width:150px; text-align: center;">Account</th>
                                    <th class="column-title" style="width:50px; text-align: center;">
                                        Debit
                                        <span data-toggle="tooltip" data-placement="top" title data-original-title="Faded amount will indicate positive balance">
                                            <i class="fa fa-info-circle"></i>
                                        </span>
                                    </th>
                                    <th class="column-title" style="width:50px; text-align: center;">
                                        Credit
                                        <span data-toggle="tooltip" data-placement="top" title data-original-title="Faded amount will indicate negative balance">
                                            <i class="fa fa-info-circle"></i>
                                        </span>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="form-group" style="max-height: 600px; overflow-x: auto; overflow-y: scroll;">
                        <div class="table-responsive">
                            <table id="dataTable2" class="table table-striped jambo_table bulk_action" style="width:100%">
                                <tbody class="headings">
                                    @foreach ($coas as $i => $coa)
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <input type="input" type="hidden" name="coa_id[]" value="{{$coa->id}}" hidden>
                                                <h5>{{$coa->code}} - {{$coa->name}} ({{$coa->coa_category->name}})</h5>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input onClick="this.select();" type="input" class="form-control debit_display" value="0">
                                                <input type="input" class="form-control debit" name="debit_opening_balance[]" placeholder="0" @foreach ($obd as $a=>
                                                $k)
                                                @if($k->account_id == $coa->id)
                                                value="{{$k->debit}}"
                                                @endif
                                                @endforeach
                                                hidden
                                                >
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input onClick="this.select();" type="input" class="form-control credit_display" value="0">
                                                <input type="input" class="form-control credit" name="credit_opening_balance[]" placeholder="0" @foreach ($obd as $a=>
                                                $k)
                                                @if($k->account_id == $coa->id)
                                                value="{{$k->credit}}"
                                                @endif
                                                @endforeach
                                                hidden
                                                >
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                        <table class="table table-hover jambo_table bulk_action" style="width:100%">
                            <tfoot>
                                {{--
                                <tr>
                                    <td class="medium-text" colspan="3" style="color: #428bca;">
                                        <a data-turbolinks="false" href="#" id="new_conversion_account"
                                        style="cursor: pointer;">
                                        <i class="fa fa-plus-circle"></i>
                                        Add New Account
                                    </a>
                                </td>
                            </tr>
                            --}}
                                <tr class="headings">
                                    <th class="column-title" style="width:150px; text-align: center;">
                                        <h4>Total</h4>
                                    </th>
                                    <th class="column-title" style="width:50px; text-align: center; padding-right:21px">
                                        <input type="input" class="form-control total-debit-display" readonly value="0">
                                        <input type="input" class="total-debit" name="total_debit" value="0" hidden>
                                    </th>
                                    <th class="column-title" style="width:50px; text-align: center; padding-right:21px">
                                        <input type="input" class="form-control total-credit-display" readonly value="0">
                                        <input type="input" class="total-credit" name="total_credit" value="0" hidden>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="action-group-conversion">
                        <input type="hidden" value="false" name="conversion[is_draft]" id="conversion_is_draft">
                        <input type="hidden" name="conversion[check_point]" id="conversion_check_point">
                        <div class="col-md-3 col-lg-3 reset-actions" style="visibility:hidden">
                            <a href="#" id="reset">
                                <button class="btn-soft">Reset to Last Saved</button>
                            </a>
                        </div>
                        <div class="col-md-12 col-lg-12 save-actions" style="text-align: center">
                            <input value="{{$ob->id}}" type="text" id="hidden_id" name="hidden_id" hidden>

                            <!--<button class="btn btn-danger" id="redirect_back" >Back</button>-->

                            <button class="btn btn-danger" type="button" onclick="window.location.href = '/conversion/setup'">Back</button>
                            @if($ob->status == "Draft")
                            <button class="btn btn-primary" id="draft_btn">Draft</button>
                            @endif
                            <button class="btn btn-success" type="button" data-target="#modal_confirm" data-toggle="modal">Publish</button>
                        </div>
                    </div>

                    <div id="modal_confirm" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                    </button>
                                    <h3>Opening Balance</h3>
                                </div>
                                <div class="modal-body">
                                    <h4 style="margin: 20px">Opening does not balance between debit and credit. To continue the difference will be entered into the <strong> Opening Balance Equity</strong> account
                                        as a <span id="type"></span> of <span id="selisih"></span>
                                    </h4>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    @if($ob->status == "Draft")
                                    <button class="btn btn-primary" id="modal_draft_btn">Draft</button>
                                    @endif
                                    <button class="btn btn-success" id="publish_btn">Publish Now</button>
                                </div>
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
<script src="{{asset('js/accounts/opening_balance/draftForm.js?v=5-20200221-1431') }}" charset="utf-8"></script>
<script src="{{asset('js/accounts/opening_balance/publishForm.js?v=5-20200221-1431') }}" charset="utf-8"></script>
<script src="{{asset('js/accounts/opening_balance/totalBalance.js?v=5-20200221-1431') }}" charset="utf-8"></script>
@endpush