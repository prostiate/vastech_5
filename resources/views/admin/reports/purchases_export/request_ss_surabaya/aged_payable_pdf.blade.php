<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        table,
        th,
        td {
            border-collapse: collapse;
            border: none;
            padding: 10px 5px;
        }

        /* Float four columns side by side */
        .column-50 {
            float: left;
            width: 50%;
        }

        .column-33 {
            float: left;
            width: 33.33%;
        }

        .column-25 {
            float: left;
            width: 25%;
        }

        /* Remove extra left and right margins, due to padding in columns */
        .row {
            margin: 0 -5px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Style the counter cards */
        .card {
            padding: 16px;
            text-align: center;
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid transparent;
            border-radius: 4px;
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
        }

        .card.card-costumer {
            text-align: left;
        }

        .card-body {
            padding: 15px;
        }

        .card-heading {
            padding: 10px 15px;
            border-bottom: 1px solid transparent;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
        }

        .card-heading>.dropdown .dropdown-toggle {
            color: inherit;
        }

        .card-title {
            margin-top: 0;
            margin-bottom: 0;
            font-size: 16px;
            color: inherit;
        }

        .card-title>a,
        .card-title>small,
        .card-title>.small,
        .card-title>small>a,
        .card-title>.small>a {
            color: inherit;
        }

        .card-footer {
            padding: 10px 15px;
            background-color: #f5f5f5;
            border-top: 1px solid #ddd;
            border-bottom-right-radius: 3px;
            border-bottom-left-radius: 3px;
        }

        .align-mid {
            margin-bottom: 0;
            text-align: center;
        }

        .table-head {
            padding: 50px 100px;
            border-bottom: 3px solid #000;
            border-spacing: 8px 10px
        }

        .table-foot {
            padding: 50px 100px;
            border-top: 3px solid #000;
            border-spacing: 8px 10px
        }

        .table-data {
            width: 100%;
        }

        .table-none tr td {
            padding: 2px;
            border: none;
        }

        .table-body>tr>td,
        .table-head>tr>th {
            text-align: center;
        }


        /* Responsive columns - one column layout (vertical) on small screens */
        @media screen and (max-width: 600px) {
            .column {
                width: 100%;
                display: block;
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
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
    </div>
</body>

</html>