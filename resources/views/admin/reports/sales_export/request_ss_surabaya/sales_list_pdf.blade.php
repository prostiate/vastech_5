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
        <table class="table table-border">
            <thead>
                <tr>
                    <th colspan="8" style="text-align: center;">
                        <strong>{{$company->name}}</strong>
                    </th>
                </tr>
                <tr>
                    <th colspan="8" style="text-align: center;">
                        <strong>Sales List</strong>
                    </th>
                </tr>
                <tr>
                    <th colspan="8" style="text-align: center;">
                        <strong>{{$start}} / {{$end}}</strong>
                    </th>
                </tr>
                <tr>
                    <th colspan="8" style="text-align: center;">
                        <strong>{{$today}}</strong>
                    </th>
                </tr>
            </thead>
            <thead>
                <tr style="backgroud-color: green;">
                    <th rowspan="2" style="width:100px;">Date</th>
                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Transaction Type</th>
                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Transaction Number</th>
                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Customer</th>
                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Status</th>
                    <th rowspan="2" style="vertical-align: middle; text-align: center; width:150px;">Memo</th>
                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Total</th>
                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Balance Due</th>
                </tr>
            </thead>
            <tbody>
                <?php $grand_total = 0 ?>
                <?php $grand_balance_due = 0 ?>
                @forelse($customer as $ot)
                <tr>
                    <td colspan="8"><b>{{$ot->first()->ot_contact->display_name}} </b></td>
                </tr>
                <?php $sub_total = 0 ?>
                <?php $sub_balance_due = 0 ?>
                @foreach($ot as $ot)
                <?php $sub_total += $ot->total ?>
                <?php $sub_balance_due += $ot->balance_due ?>
                <tr>
                    <td>{{$ot->transaction_date}}</td>
                    <td><?php echo ucwords($ot->type) ?></td>
                    <td>{{$ot->number}}</td>
                    @if($ot->type == 'closing book')
                    <td>-</td>
                    @else
                    <td>{{$ot->ot_contact->display_name}}</td>
                    @endif
                    <td>{{$ot->ot_status->name}}</td>
                    <td>{{$ot->memo}}</td>
                    <td style="text-align: right;">@number($ot->total)</td>
                    <td style="text-align: right;">@number($ot->balance_due)</td>
                </tr>
                @endforeach
                <?php $grand_total += $sub_total ?>
                <?php $grand_balance_due +=  $sub_balance_due ?>
                <tr>
                    <td colspan="5" class="text-center"></td>
                    <td style="text-align: right;"><b>SUB TOTAL</b></td>
                    <td style="text-align: right;"><b>@number($sub_total)</b></td>
                    <td style="text-align: right;"><b>@number($sub_balance_due)</b></td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Data is not found</td>
                </tr>
                @endforelse
            </tbody>
            @if(count($customer) >= 1)
            <tfoot>
                <tr style="backgroud-color: green;">
                    <td colspan="5" class="text-center"></td>
                    <td style="text-align: right;"><b>TOTAL</b></td>
                    <td style="text-align: right;"><b>@number($grand_total)</b></td>
                    <td style="text-align: right;"><b>@number($grand_balance_due)</b></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</body>

</html>