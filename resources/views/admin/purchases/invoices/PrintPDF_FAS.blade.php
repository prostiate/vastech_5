<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Purchase Invoice #{{$pp->number}}</title>
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
        <br>
        <div class="row">
            <div class="column-50">
                <div class="card card-costumer align-mid">
                    <h2 class="align-mid"><b> {{$company->name}} </b></h2>
                    <h3 class="align-mid"><b> {{$company->address}} </b></h3>
                    <hr><br>
                    <p class="align-mid"><b><u> INVOICE </u></b></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="column-50">
                <div class="card card-costumer">
                    <table class="table-none">
                        <tr>
                            <td> Kepada </td>
                            <td> : <strong>{{$pp->contact->display_name}}</strong> </td>
                        </tr>
                        <tr>
                            <td> Alamat </td>
                            <td> : {{$pp->address}} </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="column-50">
                <div class="card card-costumer">
                    <table class="table-none">>
                        <tr>
                            <td> No. Faktur </td>
                            <td> : {{$pp->number}} </td>
                        </tr>
                        <tr>
                            <td> Tanggal Invoice </td>
                            <?php $date = date('d F Y', strtotime($pp->transaction_date)) ?>
                            <td> : {{$date}} </td>
                        </tr>
                        <tr>
                            <td> Project </td>
                            <td> : <strong>{{$pp->warehouse->name}}</strong> </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <table class="table-data">
            <thead class="table-head">
                <tr>
                    <th>No</th>
                    <th>Type</th>
                    <th colspan="2">Qty</th>
                    <th colspan="2">Harga/Unit</th>
                    <th colspan="2">Harga Total</th>
                </tr>
            </thead>
            <tbody class="table-body">
                <?php
                $number = 1;
                $total = 0;
                $qty = 0;
                ?>
                @foreach($pp_item as $a)
                <tr>
                    <td>{{$number}}</td>
                    <td style="text-align: left;">{{$a->product->name}}</td>
                    <td style="text-align: right;">{{$a->qty}}</td>
                    <td>{{$a->unit->name}}</td>
                    <td> Rp </td>
                    <td style="text-align: right;"> @number($a->unit_price) <span></td>
                    <td> Rp </td>
                    <td style="text-align: right;"> @number($a->amount) <span></td>
                    <?php $number++;
                    $total += $a->amount;
                    $qty += $a->qty ?>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="table-foot">
                <tr>
                    <td colspan="6">
                    </td>
                    <td style="text-align: center;"><br><strong> Rp </strong></td>
                    <td style="text-align: right; margin-right: 5px;"><br>
                        <strong>@number($total)</strong>
                    </td>
            </tfoot>
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
        @if($pp->memo)
        <div class="row">
            <div class="column-33">
                <p><strong>Note :</strong></p>
                <p> {{$pp->memo}} </p>
            </div>
        </div>
        @endif
    </div>
</body>

</html>