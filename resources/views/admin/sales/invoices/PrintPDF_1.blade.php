<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sales Invoice #{{$pp->number}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #5D6975;
            text-decoration: underline;
        }

        body {
            position: relative;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-family: Arial;
        }

        header {
            padding: 10px 0;
            margin-bottom: 30px;
        }

        #logo {
            text-align: center;
            margin-bottom: 10px;
        }

        #logo img {
            width: 90px;
        }

        h1 {
            border-top: 1px solid #5D6975;
            border-bottom: 1px solid #5D6975;
            color: #5D6975;
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 20px 0;
            background: url(dimension.png);
        }

        #project {
            float: left;
        }

        #project span {
            color: #5D6975;
            text-align: right;
            width: 52px;
            margin-right: 10px;
            display: inline-block;
            font-size: 0.8em;
        }

        #company {
            float: right;
        }

        #project div,
        #company div {
            white-space: nowrap;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table tr:nth-child(2n-1) td {
            background: #F5F5F5;
        }

        table th,
        table td {
            text-align: center;
        }

        table th {
            padding: 5px 20px;
            color: #5D6975;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: normal;
        }

        table .service,
        table .desc {
            text-align: left;
        }

        table td {
            padding: 20px;
            text-align: right;
        }

        table td.service,
        table td.desc {
            vertical-align: top;
        }

        table td.unit,
        table td.total {
            font-size: 1.2em;
        }
        
        table td.qty {
            font-size: 1.2em;
            padding: 0px;
        }

        table td.grand {
            border-top: 1px solid #5D6975;
            ;
        }

        #notices .notice {
            color: #5D6975;
            font-size: 1.2em;
        }

        footer {
            color: #5D6975;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #C1CED9;
            padding: 8px 0;
            text-align: center;
        }
    </style>
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img src="logo.png">
        </div>
        <h1>INVOICE #{{$pp->number}}</h1>
        <div id="company" class="clearfix">
            <div>{{$company->name}}</div>
            <?php $company_address = wordwrap($company->address, 25, "<br>\n", true) ?>
            <div><?php echo $company_address ?></div>
            <div>{{$company->phone}}</div>
            <div><a href="mailto:{{$company->email}}">{{$company->email}}</a></div>
        </div>
        <div id="project">
            @if($pp->warehouse_id != 1)
            <div><span>PROJECT</span> {{$pp->warehouse->name}}</div>
            @endif
            <div><span>CUSTOMER</span> {{$pp->contact->display_name}}</div>
            @if(!$pp->address)
            <?php $address = $pp->contact->billing_address ?>
            @else
            <?php $address = $pp->address ?>
            @endif
            <div><span>ADDRESS</span> @if($address) {{$address}} @else - @endif</div>
            @if(!$pp->email)
            <?php $email = $pp->contact->email ?>
            @else
            <?php $email = $pp->email ?>
            @endif
            <div><span>EMAIL</span> <a href="mailto:{{$email}}">{{$email}} </a></div>
            <?php $date = date('d F Y', strtotime($pp->transaction_date)) ?>
            <div><span>DATE</span> {{$date}}</div>
            <?php $date = date('d F Y', strtotime($pp->due_date)) ?>
            <div><span>DUE DATE</span> {{$date}}</div>
        </div>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th class="service">PRODUCT NAME</th>
                    <th class="desc">DESCRIPTION</th>
                    <th>PRICE</th>
                    <th>QTY</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $number = 1;
                $total = 0;
                $qty = 0;
                ?>
                @foreach($pp_item as $pi)
                <tr>
                    <td class="service">{{$pi->product->name}}</td>
                    <td class="desc">@if($pi->desc) {{$pi->desc}} @else - @endif</td>
                    <td class="unit"><?php echo 'Rp ' . number_format($pi->unit_price, 2, ',', '.') ?></td>
                    <td class="qty">{{$pi->qty}} - {{$pi->unit->name}}</td>
                    <td class="total"><?php echo 'Rp ' . number_format($pi->amount, 2, ',', '.') ?></td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="4">SUBTOTAL</td>
                    <td class="total"><?php echo 'Rp ' . number_format($pp->subtotal, 2, ',', '.') ?></td>
                </tr>
                @if($pp->taxtotal > 0)
                <tr>
                    <td colspan="4">TAXTOTAL</td>
                    <td class="total"><?php echo 'Rp ' . number_format($pp->taxtotal, 2, ',', '.') ?></td>
                </tr>
                @endif
                <tr>
                    <td colspan="4" class="grand total">GRAND TOTAL</td>
                    <td class="grand total"><?php echo 'Rp ' . number_format($pp->grandtotal, 2, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>
        @if($pp->memo)
        <div id="notices">
            <div>NOTICE:</div>
            <div class="notice">{{$pp->memo}}</div>
        </div>
        @endif
    </main>
    <footer>
        Invoice #{{$pp->number}}
    </footer>
</body>

</html>