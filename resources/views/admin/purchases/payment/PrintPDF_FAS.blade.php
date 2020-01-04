<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Purchase Payment #{{$pp->number}}</title>
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
            border: solid 1px;
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

        .column-20 {
            float: left;
            width: 20%;
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

        .table-foot {
            padding: 50px 100px;
            border-top: 3px solid #000;
            border-spacing: 8px 10px
        }

        .table-data {
            width: 100%;
            border: solid 1px;
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
        <br>
        <div class="row">
            <div class="column-50">
                <div class="card card-costumer align-mid">
                    <h2><strong> TAGIHAN PEMBAYARAN No.{{$pp->number}} </strong></h2>
                </div>
            </div>
            <div class="column-50">
                <div class="card card-costumer align-mid">
                    <?php $date = date('d F Y', strtotime($pp->transaction_date)) ?>
                    <p>{{$date}}</p>
                    <p></p>
                    <p>{{$pp->contact->display_name}}</p>
                    <p></p>
                </div>
            </div>
        </div>
        <div class="row">
        </div>
        <table class="table-data">
            <thead class="table-head">
                <tr>
                    <th>No</th>
                    <th colspan="2">Transaction Number </th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $number = 1;
                ?>
                @foreach($pp_item as $a)
                <tr>
                    <td>{{$number}}</td>
                    <td style="text-align: right; border-right: 0px;">Purchase Invoice #{{$a->purchase_invoice->number}}</td>
                    <td style="border-left: 0px"></td>
                    <td style="text-align: center;">Rp @number($a->payment_amount)</td>
                </tr>
                <?php $number++ ?>
                @endforeach
                <tr>
                    <td colspan="3" style="text-align: center;"><strong>Grand Total</strong></td>
                    </td>
                    <td style="text-align: center;"><strong>Rp @number($pp->grandtotal)</strong></td>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <br>
        <div class="row">
            <div class="column-50">
                <p>Hormat Kami, </p>
                <br>
                <br>
                <br>
                <br>
                <p><u><strong> {{Auth::user()->name}} </strong></u></p>
            </div>
        </div>
        <br>
    </div>
</body>

</html>