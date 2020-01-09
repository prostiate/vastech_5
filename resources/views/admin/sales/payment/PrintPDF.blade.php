<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sales Payment {{$pp->number}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body{
            font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            color:#333;
            text-align:left;
            font-size:14px;
            margin:0;
        }
        .container{
            margin:0 auto;
            margin-top:35px;
            height:auto;
            background-color:#fff;
        }
        caption{
            font-size:28px;
            margin-bottom:15px;
        }
        table{
            border:1px solid #333;
            border-collapse:collapse;
            margin:0 auto;
			border-left: 0px solid;
    		border-right: 0px solid;
        }
        td, tr, th{
            padding:12px;
            width:170px;
			border-left: 0px solid;
    		border-right: 0px solid;
        }
        th{
            background-color: #f0f0f0;
        }
        h4, p{
            margin:0px;
        }
    </style>
</head>
<body>
    <div class="container">
        <table>
            <caption>
                CASH RECEIPT
            </caption>
            <thead>
                <tr>
                    <td colspan="6" style="text-align: center">Payment No. <strong>{{$pp->number}}</strong></td>
                    <?php $date = date('d F Y', strtotime($pp->transaction_date)) ?>
                </tr>
                <!--<tr>
                    <td>
						<h4>Received From</h4>
						<br>
						<h4>Cash Amount</h4>
						<br>
						<h4>Payment For</h4>
                    </td>
                    <td colspan="2">
						<h4>: testetsestestestestestesteseste</h4>
						<br>
						<h4>: testetsestestestestestesteseste</h4>
						<br>
						<h4>: testetsestestestestestesteseste</h4>
						<br>
                    </td>
                    <td colspan="1" >
                        <h4></h4>
                    </td>
                </tr>-->
            </thead>
            <tbody>
                <!--<tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
                <tr>
                    <td>Received From</td>
                    <td>Cash Amount</td>
                    <td>Payment For</td>
                    <td>Rp </td>
				</tr>-->
				@foreach ($pp_item as $po)
                <tr>
                    <td>Received From</td>
                    <td colspan="5">: {{$pp->contact->display_name}}</td>
                </tr>
                <tr>
                    <td>Cash Amount</td>
                    <td colspan="5">: Rp {{$pp->grandtotal}}</td>
                </tr>
                <tr>
                    <td>Payment For</td>
                    <td colspan="5">: Sales Invoice #{{$po->sale_invoice->number}}</td>
                </tr>
                <tr>
                    <td>Information</td>
                    <td colspan="5">: {{$pp->memo}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: center">{{$date}}<br><br>{{$company->name}}</td>
				</tr>
				@endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td style="border-top:1px solid #333;"><strong>Amount</strong></td>
                    <th style="text-align: center; border-top:1px solid #333; background-color: #f8a978;"><strong>Rp {{$pp->grandtotal}}</strong></th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>