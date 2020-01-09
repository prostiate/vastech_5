<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Purchase Order #{{$pp->number}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        @font-face {
            font-family: SourceSansPro;
            src: url(SourceSansPro-Regular.ttf);
        }

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #0087C3;
            text-decoration: none;
        }

        body {
            position: relative;
            color: #555555;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 14px;
            font-family: SourceSansPro;
        }

        header {
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #AAAAAA;
        }

        #logo {
            float: left;
            margin-top: 8px;
        }

        #logo img {
            height: 70px;
        }

        #company {
            float: right;
            text-align: left;
        }


        #details {
            margin-bottom: 50px;
        }

        #client {
            padding-left: 6px;
            border-left: 6px solid #0087C3;
            float: left;
        }

        #client .to {
            color: #777777;
        }

        h2.name {
            font-size: 1.4em;
            font-weight: normal;
            margin: 0;
        }

        #invoice {
            float: right;
            text-align: left;
        }

        #invoice h1 {
            color: #0087C3;
            font-size: 2.4em;
            line-height: 1em;
            font-weight: normal;
            margin: 0 0 10px 0;
        }

        #invoice .date {
            font-size: 1.1em;
            color: #777777;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 20px;
            background: #EEEEEE;
            text-align: center;
            border-bottom: 1px solid #FFFFFF;
        }

        table th {
            white-space: nowrap;
            font-weight: normal;
        }

        table td {
            text-align: right;
        }

        table td h3 {
            color: #57B223;
            font-size: 1.2em;
            font-weight: normal;
            margin: 0 0 0.2em 0;
        }

        table .no {
            color: #FFFFFF;
            font-size: 1.6em;
            background: #57B223;
        }

        table .desc {
            text-align: left;
        }

        table .unit {
            background: #DDDDDD;
        }

        table .qty {}

        table .total {
            background: #57B223;
            color: #FFFFFF;
        }

        table td.unit,
        table td.total {
            font-size: 1.2em;
        }

        table td.qty {
            font-size: 1.1em;
            padding: 10px;
        }

        table tbody tr:last-child td {
            border: none;
        }

        table tfoot td {
            padding: 10px 20px;
            background: #FFFFFF;
            border-bottom: none;
            font-size: 1.2em;
            white-space: nowrap;
            border-top: 1px solid #AAAAAA;
        }

        table tfoot tr:first-child td {
            border-top: none;
        }

        table tfoot tr:last-child td {
            color: #57B223;
            font-size: 1.4em;
            border-top: 1px solid #57B223;

        }

        table tfoot tr td:first-child {
            border: none;
        }

        #thanks {
            font-size: 2em;
            margin-bottom: 50px;
        }

        #notices {
            padding-left: 6px;
            border-left: 6px solid #0087C3;
        }

        #notices .notice {
            font-size: 1.2em;
        }

        footer {
            color: #777777;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #AAAAAA;
            padding: 8px 0;
            text-align: center;
        }
    </style>
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img src="">
        </div>
        <div id="company">
            <h2 class="name">{{$company->name}}</h2>
            <?php $company_address = wordwrap($company->address, 30, "<br>\n", true) ?>
            <div><?php echo $company_address ?></div>
            <div>{{$company->phone}}</div>
            <div><a href="mailto:{{$company->email}}">{{$company->email}}</a></div>
        </div>
        </div>
    </header>
    <main>
        <div id="details" class="clearfix">
            <div id="client">
                <div class="to">ORDER FROM:</div>
                <h2 class="name">{{$pp->contact->display_name}}</h2>
                @if(!$pp->address)
                <?php $address = $pp->contact->billing_address ?>
                @else
                <?php $address = $pp->address ?>
                @endif
                <div class="address">@if($address) {{$address}} @else - @endif</div>
                @if(!$pp->email)
                <?php $email = $pp->contact->email ?>
                @else
                <?php $email = $pp->email ?>
                @endif
                <div class="email"><a href="mailto:{{$email}}">{{$email}}</a></div>
            </div>
            <div id="invoice">
                <h1>ORDER #{{$pp->number}}</h1>
                <?php $date = date('d/m/Y', strtotime($pp->transaction_date)) ?>
                <div class="date">Date of Order: {{$date}}</div>
                <?php $date = date('d/m/Y', strtotime($pp->due_date)) ?>
                <div class="date">Due Date: {{$date}}</div>
            </div>
        </div>
        <table border="0" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th class="no">#</th>
                    <th class="desc">PRODUCT NAME</th>
                    <th class="unit">UNIT PRICE</th>
                    <th class="qty">QTY</th>
                    <th class="total">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $number = 0;
                $total = 0;
                $qty = 0;
                ?>
                @foreach($pp_item as $pi)
                <?php $number += 1 ?>
                <tr>
                    <td class="no">{{$number}}</td>
                    <td class="desc">
                        <h3>{{$pi->product->name}}</h3>{{$pi->desc}}
                    </td>
                    <td class="unit"><?php echo 'Rp ' . number_format($pi->unit_price, 2, ',', '.') ?></td>
                    <td class="qty">{{$pi->qty}} - {{$pi->unit->name}}</td>
                    <td class="total"><?php echo 'Rp ' . number_format($pi->amount, 2, ',', '.') ?></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2">SUBTOTAL</td>
                    <td><?php echo 'Rp ' . number_format($pp->subtotal, 2, ',', '.') ?></td>
                </tr>
                @if($pp->taxtotal > 0)
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2">TAXTOTAL</td>
                    <td><?php echo 'Rp ' . number_format($pp->taxtotal, 2, ',', '.') ?></td>
                </tr>
                @endif
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2">GRAND TOTAL</td>
                    <td><?php echo 'Rp ' . number_format($pp->grandtotal, 2, ',', '.') ?></td>
                </tr>
            </tfoot>
        </table>
        <div id="thanks">Thank you!</div>
        @if($pp->memo)
        <div id="notices">
            <div>NOTICE:</div>
            <div class="notice">{{$pp->memo}}</div>
        </div>
        @endif
    </main>
    <footer>
        Order #{{$pp->number}}
    </footer>
</body>

</html>