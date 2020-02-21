<table class="table table-hover">
    <thead>
        <tr>
            <th colspan="5" style="text-align: center;">
                <strong>{{$company->name}}</strong>
            </th>
        </tr>
        <tr>
            <th colspan="5" style="text-align: center;">
                <strong>Profit Loss</strong>
            </th>
        </tr>
        <tr>
            <th colspan="5" style="text-align: center;">
                <strong>{{$start}} / {{$end}}</strong>
            </th>
        </tr>
        <tr>
            <th colspan="5" style="text-align: center;">
                <strong>(in IDR)</strong>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="5" class="btn-dark"><b>Primary Income</b></td>
        </tr>
    <tbody>
        <tr>
            <td colspan="5" class="btn-dark"><b>Primary Income</b></td>
        </tr>
        @foreach($coa_detail as $c)
            @if($c->total != 0)
                @if($c->coa->coa_category_id == 13)
                    <tr>
                        <td></td>
                        <td colspan="3"><a href="/chart_of_accounts/{{$c->id}}">{{$c->coa->code}} - {{$c->coa->name}}</a></td>
                        <td class="text-right">@number(abs($c->total))</td>
                    </tr>
                @endif
            @endif
        @endforeach
        <tr>
            <td></td>
            <td colspan="3"><strong>Total Primary Income</strong></td>
            <td class="text-right"><strong>@if($total_primary_income < 0) 
                                                ( @number(abs($total_primary_income)) )
                                            @else 
                                                @number($total_primary_income) 
                                            @endif</strong></td>
        </tr>
        <tr>
            <td colspan="5"><b>Cost of Sales</b></td>
        </tr>
        @foreach($coa_detail as $c)
            @if($c->total != 0)
                @if($c->coa->coa_category_id == 15)
                    <tr>
                        <td></td>
                        <td colspan="3"><a href="/chart_of_accounts/{{$c->id}}">{{$c->coa->code}} - {{$c->coa->name}}</a></td>
                        <td class="text-right">@if($c->total < 0) ( @number(abs($c->total)) ) @else @number($c->total) @endif</td>
                    </tr>
                @endif
            @endif
        @endforeach
        <tr>
            <td></td>
            <td colspan="3"><strong>Total Cost of Sales</strong></td>
            <td class="text-right"><strong>@if($total_cost_of_sales < 0) 
                                                ( @number(abs($total_cost_of_sales)) )
                                            @else 
                                                @number($total_cost_of_sales) 
                                            @endif</strong></td>
        </tr>
        <tr>
            <td colspan="4"><b>Gross Profits</b></td>
            <td class="text-right"><strong>@if($gross_profit < 0) 
                                                ( @number(abs($gross_profit)) )
                                            @else 
                                                @number($gross_profit) 
                                            @endif</strong></td>
        </tr>
        <tr>
            <td colspan="5" class="btn-dark"><b>Operational Expense</b></td>
        </tr>
        @foreach($coa_detail as $c)
            @if($c->total != 0)
                @if($c->coa->coa_category_id == 16)
                    <tr>
                        <td></td>
                        <td colspan="3"><a href="/chart_of_accounts/{{$c->id}}">{{$c->coa->code}} - {{$c->coa->name}}</a></td>
                        <td class="text-right">@if($c->total < 0) ( @number(abs($c->total)) ) @else @number($c->total) @endif</td>
                    </tr>
                @endif
            @endif
        @endforeach
        <tr>
            <td></td>
            <td colspan="3">Total Operational Expenses</td>
            <td class="text-right"><strong>@if($total_operational_expense < 0) 
                                                ( @number(abs($total_operational_expense)) )
                                            @else 
                                                @number($total_operational_expense) 
                                            @endif</strong></td>
        </tr>
        <tr>
            <td colspan="4"><b>Net Operating Income</b></td>
            <td class="text-right"><strong>@if($net_operating_income < 0) 
                                                ( @number(abs($net_operating_income)) )
                                            @else 
                                                @number($net_operating_income) 
                                            @endif</strong></td>
        </tr>
        <tr>
            <td colspan="5" class="btn-dark"><b>Other Income</b></td>
        </tr>
        @foreach($coa_detail as $c)
            @if($c->total != 0)
                @if($c->coa->coa_category_id == 14)
                    <tr>
                        <td></td>
                        <td colspan="3"><a href="/chart_of_accounts/{{$c->id}}">{{$c->coa->code}} - {{$c->coa->name}}</a></td>
                        <td class="text-right">@if($c->total < 0) ( @number(abs($c->total)) ) @else @number($c->total) @endif</td>
                    </tr>
                @endif
            @endif
        @endforeach
        <tr>
            <td></td>
            <td colspan="3">Total Other Income</td>
            <td class="text-right"><strong>@if($total_other_income < 0) 
                                                ( @number(abs($total_other_income)) )
                                            @else 
                                                @number($total_other_income) 
                                            @endif</strong></td>
        </tr>
        <tr>
            <td colspan="5" class="btn-dark"><b>Other Expense</b></td>
        </tr>
        @foreach($coa_detail as $c)
            @if($c->total != 0)
                @if($c->coa->coa_category_id == 17)
                    <tr>
                        <td></td>
                        <td colspan="3"><a href="/chart_of_accounts/{{$c->id}}">{{$c->coa->code}} - {{$c->coa->name}}</a></td>
                        <td class="text-right">@if($c->total < 0) ( @number(abs($c->total)) ) @else @number($c->total) @endif</td>
                    </tr>
                @endif
            @endif
        @endforeach
        <tr>
            <td></td>
            <td colspan="3">Total Other Expense</td>
            <td class="text-right"><strong>@if($total_other_expense < 0) 
                                                ( @number(abs($total_other_expense)) )
                                            @else 
                                                @number($total_other_expense) 
                                            @endif</strong></td>
        </tr>
        <tr>
            <td colspan="4" class="btn-dark"><b>Net Income</b></td>
            <td class="text-right btn-dark"><strong>@if($net_income < 0) 
                                                ( @number(abs($net_income)) )
                                            @else 
                                                @number($net_income) 
                                            @endif</strong></td>
        </tr>
    </tbody>
</table>