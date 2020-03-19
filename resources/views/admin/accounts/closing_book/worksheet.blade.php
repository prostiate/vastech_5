@extends('layouts/admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <h5>From <strong>{{$start_period}}</strong> To <strong>{{$end_period}}</strong></h5>
                    </li>
                </ul>
                <h3>Closing Book</h3>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="formCreate" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                                    <input name="end_period" value="{{$end_period}}" hidden>
                                    <input name="start_period" value="{{$start_period}}" hidden>
                                    <div class="col-12 table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="btn-dark">
                                                    <th colspan="2" rowspan="2" style="width: 250px; text-align: center">
                                                        Daftar Akun</th>
                                                    <th colspan="2" style="width: 100px; text-align: center">Trial
                                                        Balance
                                                    </th>
                                                    <th colspan="2" style="width: 100px; text-align: center">Income
                                                        Statement</th>
                                                    <th colspan="2" style="width: 100px; text-align: center">Balance
                                                        Sheet
                                                    </th>
                                                </tr>
                                                <tr class="btn-dark">
                                                    <th style="width: 120px; text-align: center">Debit</th>
                                                    <th style="width: 120px; text-align: center">Credit</th>
                                                    <th style="width: 120px; text-align: center">Debit</th>
                                                    <th style="width: 120px; text-align: center">Credit</th>
                                                    <th style="width: 120px; text-align: center">Debit</th>
                                                    <th style="width: 120px; text-align: center">Credit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="8"><strong>Asset</strong></td>
                                                </tr>
                                                <?php $asset_debit = 0 ?>
                                                <?php $asset_credit = 0 ?>
                                                @foreach($coa_assets as $j => $coa)
                                                @if($coa->coa_category_id == 7)
                                                @foreach($coa_detail_credit as $i => $detail)
                                                @if($coa->id == $detail->coa_id)
                                                @if($detail->total < 0) <?php $debit = $detail->total; ?> <?php $credit = 0 ?> @else <?php $debit = 0 ?> <?php $credit = $detail->total; ?> @endif @break @else <?php $debit = 0 ?> <?php $credit = 0 ?> @endif @endforeach @else @foreach($coa_detail_debit as $i=> $detail)
                                                    @if($coa->id == $detail->coa_id)
                                                    @if($detail->total > 0)
                                                    <?php $debit = $detail->total; ?>
                                                    <?php $credit = 0 ?>
                                                    @else
                                                    <?php $debit = 0 ?>
                                                    <?php $credit = $detail->total; ?>
                                                    @endif
                                                    @break
                                                    @else
                                                    <?php $debit = 0 ?>
                                                    <?php $credit = 0 ?>
                                                    @endif
                                                    @endforeach
                                                    @endif
                                                    <?php $debit = abs($debit) ?>
                                                    <?php $credit = abs($credit) ?>
                                                    <?php $asset_debit += $debit ?>
                                                    <?php $asset_credit += $credit ?>
                                                    <tr>
                                                        <td colspan="2">
                                                            <a href="{{route('coa.show', ['id' => $coa->id])}}">({{$coa->code}})
                                                                {{$coa->name}}</a>
                                                            <input hidden class="tb_coa" name="tb_coa[]" value="{{$coa->id}}">
                                                        </td>
                                                        <td class="text-right">
                                                            <a class="tb_debit_display"><?php echo number_format($debit, 2, ',', '.') ?></a>
                                                            <input hidden class="tb_debit" name="tb_debit[]" value="{{$debit}}">
                                                        </td>
                                                        <td class="text-right">
                                                            <a class="tb_credit_display"><?php echo number_format($credit, 2, ',', '.') ?></a>
                                                            <input hidden class="tb_credit" name="tb_credit[]" value="{{$credit}}">
                                                        </td>
                                                        <td>
                                                            <a></a>
                                                        </td>
                                                        <td>
                                                            <a></a>
                                                        </td>
                                                        <td class="text-right">
                                                            <a class="bs_debit_display"><?php echo number_format($debit, 2, ',', '.') ?></a>
                                                            <input hidden class="bs_debit" name="bs_debit[]" value="{{$debit}}">
                                                        </td>
                                                        <td class="text-right">
                                                            <a class="bs_credit_display"><?php echo number_format($credit, 2, ',', '.') ?></a>
                                                            <input hidden class="bs_credit" name="bs_credit[]" value="{{$credit}}">
                                                        </td>
                                                    </tr>
                                                    @endforeach

                                                    <tr>
                                                        <td colspan="8">Liability</td>
                                                    </tr>
                                                    <?php $liability_debit = 0 ?>
                                                    <?php $liability_credit = 0 ?>
                                                    @foreach($coa_liabilities as $j => $coa)
                                                    @foreach($coa_detail_credit as $i => $detail)
                                                    @if($coa->id == $detail->coa_id)
                                                    @if($detail->total < 0) <?php $debit = $detail->total; ?> <?php $credit = 0 ?> @else <?php $debit = 0 ?> <?php $credit = $detail->total; ?> @endif @break @else <?php $debit = 0 ?> <?php $credit = 0 ?> @endif @endforeach <?php $debit = abs($debit) ?> <?php $credit = abs($credit) ?> <?php $liability_debit += $debit ?> <?php $liability_credit += $credit ?> <tr>
                                                        <td colspan="2">
                                                            <a href="{{route('coa.show', ['id' => $coa->id])}}">({{$coa->code}})
                                                                {{$coa->name}}</a>
                                                            <input hidden class="tb_coa" name="tb_coa[]" value="{{$coa->id}}">
                                                        </td>
                                                        <td class="text-right">
                                                            <a class="tb_debit_display"><?php echo number_format($debit, 2, ',', '.') ?></a>
                                                            <input hidden class="tb_debit" name="tb_debit[]" value="{{$debit}}">
                                                        </td>
                                                        <td class="text-right">
                                                            <a class="tb_credit_display"><?php echo number_format($credit, 2, ',', '.') ?></a>
                                                            <input hidden class="tb_credit" name="tb_credit[]" value="{{$credit}}">
                                                        </td>
                                                        <td>
                                                            <a></a>
                                                        </td>
                                                        <td>
                                                            <a></a>
                                                        </td>
                                                        <td class="text-right">
                                                            <a class="bs_debit_display"><?php echo number_format($debit, 2, ',', '.') ?></a>
                                                            <input hidden class="bs_debit" name="bs_debit[]" value="{{$debit}}">
                                                        </td>
                                                        <td class="text-right">
                                                            <a class="bs_credit_display"><?php echo number_format($credit, 2, ',', '.') ?></a>
                                                            <input hidden class="bs_credit" name="bs_credit[]" value="{{$credit}}">
                                                        </td>
                                                        </tr>
                                                        @endforeach

                                                        <tr>
                                                            <td colspan="8">Equity</td>
                                                        </tr>
                                                        <?php $equity_debit = 0 ?>
                                                        <?php $equity_credit = 0 ?>
                                                        @foreach($coa_equities as $j => $coa)
                                                        @foreach($coa_detail_credit as $i => $detail)
                                                        @if($coa->id == $detail->coa_id)
                                                        @if($detail->total < 0) <?php $debit = $detail->total; ?> <?php $credit = 0 ?> @else <?php $debit = 0 ?> <?php $credit = $detail->total; ?> @endif @break @else <?php $debit = 0 ?> <?php $credit = 0 ?> @endif @endforeach <?php $debit = abs($debit) ?> <?php $credit = abs($credit) ?> <?php $equity_debit += $debit ?> <?php $equity_credit += $credit ?> <tr>
                                                            <td colspan="2">
                                                                <a href="{{route('coa.show', ['id' => $coa->id])}}">({{$coa->code}})
                                                                    {{$coa->name}}</a>
                                                                <input hidden class="tb_coa" name="tb_coa[]" value="{{$coa->id}}">
                                                            </td>
                                                            <td class="text-right">
                                                                <a class="tb_debit_display"><?php echo number_format($debit, 2, ',', '.') ?></a>
                                                                <input hidden class="tb_debit" name="tb_debit[]" value="{{$debit}}">
                                                            </td>
                                                            <td class="text-right">
                                                                <a class="tb_credit_display"><?php echo number_format($credit, 2, ',', '.') ?></a>
                                                                <input hidden class="tb_credit" name="tb_credit[]" value="{{$credit}}">
                                                            </td>
                                                            <td>
                                                                <a></a>
                                                            </td>
                                                            <td>
                                                                <a></a>
                                                            </td>
                                                            <td class="text-right">
                                                                <a class="bs_debit_display"><?php echo number_format($debit, 2, ',', '.') ?></a>
                                                                <input hidden class="bs_debit" name="bs_debit[]" value="{{$debit}}">
                                                            </td>
                                                            <td class="text-right">
                                                                <a class="bs_credit_display"><?php echo number_format($credit, 2, ',', '.') ?></a>
                                                                <input hidden class="bs_credit" name="bs_credit[]" value="{{$credit}}">
                                                            </td>
                                                            </tr>
                                                            @endforeach

                                                            <tr>
                                                                <td colspan="8">Income</td>
                                                            </tr>
                                                            <?php $income_debit = 0 ?>
                                                            <?php $income_credit = 0 ?>
                                                            @foreach($coa_incomes as $j => $coa)
                                                            @foreach($coa_detail_credit as $i => $detail)
                                                            @if($coa->id == $detail->coa_id)
                                                            @if($detail->total < 0) <?php $debit = $detail->total; ?> <?php $credit = 0 ?> @else <?php $debit = 0 ?> <?php $credit = $detail->total; ?> @endif @break @else <?php $debit = 0 ?> <?php $credit = 0 ?> @endif @endforeach <?php $debit = abs($debit) ?> <?php $credit = abs($credit) ?> <?php $income_debit += $debit ?> <?php $income_credit += $credit ?> <tr>
                                                                <td colspan="2">
                                                                    <a href="{{route('coa.show', ['id' => $coa->id])}}">({{$coa->code}})
                                                                        {{$coa->name}}</a>
                                                                    <input hidden class="tb_coa" name="tb_coa[]" value="{{$coa->id}}">
                                                                    <input hidden class="in_coa" name="in_coa[]" value="{{$coa->id}}">
                                                                </td>
                                                                <td class="text-right">
                                                                    <a class="tb_debit_display"><?php echo number_format($debit, 2, ',', '.') ?></a>
                                                                    <input hidden class="tb_debit" name="tb_debit[]" value="{{$debit}}">
                                                                </td>
                                                                <td class="text-right">
                                                                    <a class="tb_credit_display"><?php echo number_format($credit, 2, ',', '.') ?></a>
                                                                    <input hidden class="tb_credit" name="tb_credit[]" value="{{$credit}}">
                                                                </td>
                                                                <td class="text-right">
                                                                    <a><?php echo number_format($debit, 2, ',', '.') ?></a>
                                                                    <input hidden class="in_debit" name="in_debit[]" value="{{$debit}}">
                                                                </td>
                                                                <td class="text-right">
                                                                    <a><?php echo number_format($credit, 2, ',', '.') ?></a>
                                                                    <input hidden class="in_credit" name="in_credit[]" value="{{$credit}}">
                                                                </td>
                                                                <td>
                                                                    <a></a>
                                                                </td>
                                                                <td>
                                                                    <a></a>
                                                                </td>
                                                                </tr>
                                                                @endforeach

                                                                <tr>
                                                                    <td colspan="8">Expense</td>
                                                                </tr>
                                                                <?php $expense_debit = 0 ?>
                                                                <?php $expense_credit = 0 ?>
                                                                @foreach($coa_expenses as $j => $coa)
                                                                @foreach($coa_detail_debit as $i => $detail)
                                                                @if($coa->id == $detail->coa_id)
                                                                @if($detail->total > 0)
                                                                <?php $debit = $detail->total; ?>
                                                                <?php $credit = 0 ?>
                                                                @else
                                                                <?php $debit = 0 ?>
                                                                <?php $credit = $detail->total; ?>
                                                                @endif
                                                                @break
                                                                @else
                                                                <?php $debit = 0 ?>
                                                                <?php $credit = 0 ?>
                                                                @endif
                                                                @endforeach
                                                                <?php $debit = abs($debit) ?>
                                                                <?php $credit = abs($credit) ?>
                                                                <?php $expense_debit += $debit ?>
                                                                <?php $expense_credit += $credit ?>

                                                                <tr>
                                                                    <td colspan="2">
                                                                        <a href="{{route('coa.show', ['id' => $coa->id])}}">({{$coa->code}})
                                                                            {{$coa->name}}</a>
                                                                        <input hidden class="tb_coa" name="tb_coa[]" value="{{$coa->id}}">
                                                                        <input hidden class="in_coa" name="in_coa[]" value="{{$coa->id}}">
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <a class="tb_debit_display"><?php echo number_format($debit, 2, ',', '.') ?></a>
                                                                        <input hidden class="tb_debit" name="tb_debit[]" value="{{$debit}}">
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <a class="tb_credit_display"><?php echo number_format($credit, 2, ',', '.') ?></a>
                                                                        <input hidden class="tb_credit" name="tb_credit[]" value="{{$credit}}">
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <a><?php echo number_format($debit, 2, ',', '.') ?></a>
                                                                        <input hidden class="in_debit" name="in_debit[]" value="{{$debit}}">
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <a><?php echo number_format($credit, 2, ',', '.') ?></a>
                                                                        <input hidden class="in_credit" name="in_credit[]" value="{{$credit}}">
                                                                    </td>
                                                                    <td>
                                                                        <a></a>
                                                                    </td>
                                                                    <td>
                                                                        <a></a>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <?php $tb_debit     = $asset_debit + $liability_debit + $equity_debit + $income_debit + $expense_debit ?>
                                                <?php $tb_credit    = $asset_credit + $liability_credit + $equity_credit + $income_credit + $expense_credit ?>
                                                <?php $in_debit     = $income_debit + $expense_debit ?>
                                                <?php $in_credit    = $income_credit + $expense_credit ?>
                                                <?php $bs_debit     = $asset_debit + $liability_debit + $equity_debit ?>
                                                <?php $bs_credit    = $asset_credit + $liability_credit + $equity_credit ?>
                                                <tr>
                                                    <td colspan="2" class="text-left"><strong>Total</strong></td>
                                                    <th class="text-right" style="width: 120px">
                                                        <?php echo number_format($tb_debit, 2, ',', '.') ?></th>
                                                    <th class="text-right" style="width: 120px">
                                                        <?php echo number_format($tb_credit, 2, ',', '.') ?></th>
                                                    <th class="text-right" style="width: 120px" id="income_debit">
                                                        <?php echo number_format($in_debit, 2, ',', '.') ?></th>
                                                    <th class="text-right" style="width: 120px" id="income_credit">
                                                        <?php echo number_format($in_credit, 2, ',', '.') ?></th>
                                                    <th class="text-right" style="width: 120px" id="balance_debit">
                                                        <?php echo number_format($bs_debit, 2, ',', '.') ?></th>
                                                    <th class="text-right" style="width: 120px" id="balance_credit">
                                                        <?php echo number_format($bs_credit, 2, ',', '.') ?></th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input hidden class="tb_debit_total" name="tb_debit_total" value="{{$tb_debit}}">
                                                        <input hidden class="tb_credit_total" name="tb_credit_total" value="{{$tb_credit}}">
                                                        <input hidden class="in_debit_total" name="in_debit_total" value="{{$in_debit}}">
                                                        <input hidden class="in_credit_total" name="in_credit_total" value="{{$in_credit}}">
                                                        <input hidden class="balance_debit_total" name="balance_debit_total" value="{{$bs_debit}}">
                                                        <input hidden class="balance_credit_total" name="balance_credit_total" value="{{$bs_credit}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="text-left btn-success"><strong>Net Profit
                                                            Loss</strong></td>
                                                    <td class="btn-success text-right" style="width: 120px"></td>
                                                    <td class="btn-success text-right" style="width: 120px"></td>
                                                    <td class="btn-success text-right" style="width: 120px" id="net_debit">
                                                    </td>
                                                    <td class="btn-success text-right" style="width: 120px" id="net_credit">
                                                    </td>
                                                    <td class="btn-success text-right" style="width: 120px"></td>
                                                    <td class="btn-success text-right" style="width: 120px"></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="net_debit" name="net_debit" value="0" hidden>
                                                        <input class="net_credit" name="net_credit" value="0" hidden>
                                                        <input class="sub_net_debit" name="sub_net_debit" value="0" hidden>
                                                        <input class="sub_net_credit" name="sub_net_credit" value="0" hidden>
                                                    </td>
                                                </tr>
                                                <!--{{--
                                            <tr>
                                                <td colspan="2" class="text-left "><strong>Tax Expense</strong></td>
                                                <td colspan="2" class="text-right" style="width: 120px">
                                                    Tax expense account
                                                    <select type="select" class="form-control selectaccount" id="tax_expense_acc" name="tax_expense_acc">
                                                        @foreach ($coa_tax_expense as $account)
                                                        <option value="{{$account->id}}">
                                                ({{$account->code}}) - {{$account->name}} ({{$account->coa_category->name}})
                                                </option>
                                                @endforeach
                                                </select>

                                                Tax payable account
                                                <select type="select" class="form-control selectaccount" id="tax_payable_acc" name="tax_payable_acc">
                                                    @foreach ($coa_tax_payable as $account)
                                                    <option value="{{$account->id}}">
                                                        ({{$account->code}}) - {{$account->name}}
                                                        ({{$account->coa_category->name}})
                                                    </option>
                                                    @endforeach
                                                </select>

                                                </td>
                                                <td class=" text-right" style="width: 120px"></td>
                                                <td colspan="2" class=" text-right" style="width: 120px">
                                                    Tax amount
                                                    <input hidden class="form-group" id="tax_amount_acc">
                                                </td>
                                                <td class=" text-right" style="width: 120px"></td>
                                                </tr>
                                                --}}-->
                                                <tr>
                                                    <td colspan="2" class="text-center" style="padding-top:35px; margin: 0 auto"><strong>Net Profit
                                                            Loss</strong></td>
                                                    <td colspan="2" class="text-right" style="width: 120px">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-12 col-sm-12 col-xs-12" style="text-align: center;">Retained Earnings
                                                                Account</label>
                                                            <select type="select" class="form-control selectaccount" id="retained_earning_acc" name="retained_earning_acc" @if($closing_book->retained_acc)
                                                                data-last={{$closing_book->retained_acc}} @else
                                                                data-last="0" @endif>
                                                                @foreach ($coa_equities as $account)
                                                                <option value="{{$account->id}}" @if($closing_book->
                                                                    retained_acc == $account->id) selected @endif>
                                                                    ({{$account->code}}) - {{$account->name}}
                                                                    ({{$account->coa_category->name}})
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td class=" text-right" style="width: 120px"></td>
                                                    <td colspan="2" class=" text-right" style="width: 120px"></td>
                                                    <td class=" text-right" style="width: 120px"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <input type="text" name="hidden_id" id="hidden_id" value="{{$closing_book->id}}" hidden>
                                </form>
                            </div>
                            <br>
                            <div class="col-md-12 text-center">
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                        <button class="btn btn-primary" type="button" onclick="window.location.href = '/chart_of_accounts';">Cancel</button>
                                        <button id="click" type="submit" class="btn btn-success">Save and Continue</button>
                                    </div>
                                    <br>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/accounts/closing_book/worksheet.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{ asset('js/accounts/closing_book/createForm_worksheet.js?v=5-20200319-0916') }}" charset="utf-8">
</script>
<script src="{{asset('js/other/select2.js?v=5-20200319-0916') }}" charset="utf-8"></script>
@endpush