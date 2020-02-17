<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sales Delivery #{{$pp->number}}</title>
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
            border: 1px dotted black;
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

        .table-head {
            ;
            text-align: center;
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
            <div class="column-33">
                <div class="card card-costumer">
                    <a>Kepada Yth.</a><br><br>
                    <a><strong> {{$pp->contact->display_name}} </strong></a>
                </div>
            </div>
            <div class="column-33">
                <div class="card    ">
                    <strong>
                        <a>TANDA TERIMA BARANG</a><br><br>
                        <a>No : {{$pp->number}} </a>
                    </strong>
                </div>
            </div>
            <div class="column-33">
                <div class="card" style="text-align: right;">
                    <a>Surabaya, <?php echo date_format($pp->transaction_date,"d F y"); ?></a><br>
                    <a>No. Sales Order @if($pp->selected_so_id){{$pp->sale_order->number}}@endif</a><br>
                    <!--<a>No. Purchase Order @if($pp->selected_so_id){{$pp->sale_order->vendor_ref_no}}@endif</a><br>
                    <a>POCust <span style="visibility: hidden;">@if($pp->selected_so_id){{$pp->sale_order->number}}@endif</a><br>-->
                </div>
            </div>
        </div>
        <table style="width: 100%;  border: 1px solid #ddd">
            <thead class="table-head">
                <tr>
                    <th>NO</th>
                    <th>KODE BARANG</th>
                    <th>NAMA BARANG</th>
                    <th>QTY</th>
                    <th>UNIT</th>
                    <th>KET</th>
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
                    <td style="text-align: left;">{{$a->product->code}}</td>
                    <td style="text-align: left;">{{$a->product->name}}</td>
                    <td style="text-align: right;">{{$a->qty}}</td>
                    <td>{{$a->unit->name}}</td>
                    <td>{{$a->desc}}</td>
                    <?php $number++;$total += $a->amount; $qty += $a->qty?>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;">
                        Total
                    </td>
                    <td style="text-align: right;">
                        {{$qty}}
                    </td>
                    <td colspan="2">

                    </td>
                </tr>
            </tfoot>
        </table>
        <br>
        <br>
        <div class="row">
            <div class="column-20">
                <div class="card">
                    <a>Ka.Gudang</a>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <a> (................................)</a>
                </div>
            </div>
            <div class="column-20">
                <div class="card">
                    <a>Mengetahui</a>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <a> (................................)</a>
                </div>
            </div>
            <div class="column-20">
                <div class="card">
                    <a>Sopir</a>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <a> (................................)</a>
                </div>
            </div>
            <div class="column-20">
                <div class="card">
                    <a>Security</a>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <a> (................................)</a>
                </div>
            </div>
            <div class="column-20">
                <div class="card">
                    <a>Penerima</a>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <a> (................................)</a>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>