<table class="table table-hover">
    <thead>
        <tr>
            <th colspan="6" style="text-align: center;">
                <strong>{{$company->name}}</strong>
            </th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center;">
                <strong>Customer Balance</strong>
            </th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center;">
                <strong>{{$start}} / {{$end}}</strong>
            </th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center;">
                <strong>{{$today}}</strong>
            </th>
        </tr>
        <tr class="btn-dark">
            <th style="width:auto;">Customer</th>
            <th class="text-center">Total</th>
            <th class="text-center">1 - 30 Days</th>
            <th class="text-center">31 - 60 Days</th>
            <th class="text-center">61 - 90 Days</th>
            <th class="text-center">> 90 Days</th>
        </tr>
    </thead>
    <tfoot>
        <?php $periode1 = 0 ?>
        <?php $periode2 = 0 ?>
        <?php $periode3 = 0 ?>
        <?php $periode4 = 0 ?>
        <?php $total = 0 ?>
        @foreach($si as $k => $c)
        <tr>
            <td>{{$c->contact->display_name}}</td>
            <td class="text-right">@number($c->balance_due)</td>
            <?php $total += $c->balance_due ?>
            <td class="text-right">
                @if(isset($group1[$c->contact->display_name]))
                @number($group1[$c->contact->display_name]->sum('balance_due'))
                <?php $periode1 += $group1[$c->contact->display_name]->sum('balance_due') ?>
                @else
                0.00
                @endif</td>
            <td class="text-right">
                @if(isset($group2[$c->contact->display_name]))
                @number($group2[$c->contact->display_name]->sum('balance_due'))
                <?php $periode2 += $group2[$c->contact->display_name]->sum('balance_due') ?>
                @else
                0.00
                @endif</td>
            <td class="text-right">
                @if(isset($group3[$c->contact->display_name]))
                @number($group3[$c->contact->display_name]->sum('balance_due'))
                <?php $periode3 += $group3[$c->contact->display_name]->sum('balance_due') ?>
                @else
                0.00
                @endif</td>
            <td class="text-right">
                @if(isset($group4[$c->contact->display_name]))
                @number($group4[$c->contact->display_name]->sum('balance_due'))
                <?php $periode4 += $group4[$c->contact->display_name]->sum('balance_due') ?>
                @else
                0.00
                @endif</td>
        </tr>
        @isset($group1[$c->contact->display_name] )
        <tr>
            <td class="text-center" colspan="6"><strong> 1 - 30 Days </strong></td>
        </tr>
        @foreach($group1[$c->contact->display_name] as $k)
        <tr>
            <td>
                Purchse Invoice {{$k->number}}
            </td>
            <td class="text-center">
                {{$k->transaction_date}}
            </td>
            <td class="text-right">
                @number($k->balance_due)
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @endforeach
        @endisset
        @isset($group2[$c->contact->display_name] )
        <tr>
            <td class="text-center" colspan="6"><strong> 31 - 60 Days </strong></td>
        </tr>
        @foreach($group2[$c->contact->display_name] as $k)
        <tr>
            <td>
                Purchse Invoice {{$k->number}}
            </td>
            <td class="text-center">
                {{$k->transaction_date}}
            </td>
            <td></td>
            <td class="text-right">
                @number($k->balance_due)
            </td>
            <td></td>
            <td></td>
        </tr>
        @endforeach
        @endisset
        @isset($group3[$c->contact->display_name] )
        <tr>
            <td class="text-center" colspan="6"><strong> 61 - 90 </strong></td>
        </tr>
        @foreach($group3[$c->contact->display_name] as $k)
        <tr>
            <td>
                Purchase Invoice {{$k->number}}
            </td>
            <td class="text-center">
                {{$k->transaction_date}}
            </td>
            <td></td>
            <td></td>
            <td class="text-right">
                @number($k->balance_due)
            </td>
            <td></td>
        </tr>
        @endforeach
        @endisset
        @isset($group4[$c->contact->display_name] )
        <tr>
            <td class="text-center" colspan="6"><strong> > 90 Days </strong></td>
        </tr>
        @foreach($group4[$c->contact->display_name] as $k)
        <tr>
            <td>
                Purchse Invoice {{$k->number}}
            </td>
            <td class="text-center">
                {{$k->transaction_date}}
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">
                @number($k->balance_due)
            </td>
        </tr>
        @endforeach
        @endisset
        @endforeach
        <tr>
            <td class="text-left"><b>Total Payable</b></td>
            <td class="text-right"><b>@number($total)</b></td>
            <td class="text-right"><b>@number($periode1)</b></td>
            <td class="text-right"><b>@number($periode2)</b></td>
            <td class="text-right"><b>@number($periode3)</b></td>
            <td class="text-right"><b>@number($periode4)</b></td>
        </tr>
    </tfoot>
</table>