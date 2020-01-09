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
        <table class="table table-striped table-condensed">
            <thead>
                <tr class="headings btn-dark">
                    <th class="column-title text-left">Product Code</th>
                    <th class="column-title text-left">Product Name</th>
                    <th class="column-title text-left">Qty</th>
                    <th class="column-title text-center">Buffer Qty</th>
                    <th class="column-title text-left">Units</th>
                    <th class="column-title text-right" style="width: 150px">Average Cost</th>
                    <th class="column-title text-right" style="width: 150px">Value</th>
                </tr>
            </thead>
            <tbody>
                <?php $total_val = 0 ?>
                <?php $grand_total_val = 0 ?>
                @foreach($products as $a)
                <tr>
                    <td>
                        <a>{{$a->code}}</a>
                    </td>
                    <td>
                        <a href="/products/{{$a->id}}">{{$a->name}}</a>
                    </td>
                    <td>
                        <a>{{$a->qty}}</a>
                    </td>
                    <td class="text-center">
                        <a>-</a>
                    </td>
                    <td>
                        <a>{{$a->other_unit->name}}</a>
                    </td>
                    <td class="text-right">
                        <a>@number($a->avg_price)</a>
                    </td>
                    <td class="text-right">
                        <?php $total_val = $a->avg_price * $a->qty ?>
                        <a>@number($total_val)</a>
                    </td>
                </tr>
                <?php $grand_total_val += $total_val ?>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="6" style="text-align: right"><strong>Total Value</strong></th>
                    <th class="text-right"><strong>@number($grand_total_val)</strong></th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>