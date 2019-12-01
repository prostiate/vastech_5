<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sales Quote #{{$pp->number}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        .footer {
            position: absolute;
        }

        .footer {
            position: fixed;
            width: 100%;
            bottom: 0;
            left: 0;
            right: 0;
        }

        body {
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            color: #333;
            text-align: left;
            font-size: 14px;
            margin: 0;
        }

        .container {
            margin: 0 auto;
            margin-top: 35px;
            height: auto;
            background-color: #fff;
        }

        caption {
            font-size: 28px;
            margin-bottom: 15px;
        }

        table {
            border: 1px solid #333;
            border-collapse: collapse;
            margin: 0 auto;
        }

        td,
        tr,
        th {
            padding: 12px;
            width: auto;
            border-left: 0px solid;
        }

        th {
            background-color: #f0f0f0;
        }

        h4,
        p {
            margin: 0px;
        }
    </style>
</head>

<body>
    <div class="container">
        <caption>
            Sales Quote
        </caption>
        <br>
        <br>
        <br>
        <table style="width: 100%">
            <thead>
                <tr>
                    <th colspan="4" style="text-align: right;"><strong>Quote #{{$pp->number}}</strong></th>
                    <!--<th colspan="2" style="border-left: 1px solid;"></th>-->
                </tr>
                <tr>
                    <td colspan="2" style="border-top: 1px solid;">
                        <p>{{$pp->contact->display_name}}</p>
                        <br>
                        <p>{{$pp->address}}</p>
                        <br>
                        <p>{{$pp->email}}</p>
                    </td>
                    <td style="width: 116px; border-left: 1px solid; border-top: 1px solid;">
                        <p>Transaction Date</p>
                        <br>
                        <p>Expired Date</p>
                        <br>
                        <p>Customer Ref</p>
                    </td>
                    <td style="border-top: 1px solid;">
                        <p>{{$pp->transaction_date}}</p>
                        <br>
                        <p>{{$pp->due_date}}</p>
                        <br>
                        <p>{{$pp->vendor_ref_no}}</p>
                    </td>
                </tr>
                <tr>
                    <th style="width: 150px; border-top: 1px solid;">Product</th>
                    <th style="width: 50px; border-left: 1px solid; border-top: 1px solid; text-align: center;">Qty</th>
                    <th style="width: 120px; border-left: 1px solid; border-top: 1px solid; text-align: right;">Unit Price (Rp)</th>
                    <th style="width: 120px; border-left: 1px solid; border-top: 1px solid; text-align: right;">Amount (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pp_item as $a)
                <tr>
                    <td>{{$a->product->name}}</td>
                    <td style="border-left: 1px solid; text-align: right;">{{$a->qty}} - {{$a->unit->name}}</td>
                    <td style="border-left: 1px solid; text-align: right;">Rp @number($a->unit_price)</td>
                    <td style="border-left: 1px solid; text-align: right;">Rp @number($a->amount)</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="border-top: 1px solid;"><strong>PLEASE NOTE</strong></td>
                    <td style="border-top: 1px solid; border-left: 1px solid;">Subtotal</td>
                    <td style="border-top: 1px solid; border-left: 1px solid; text-align: right;">Rp @number($pp->grandtotal)</td>
                </tr>
                <tr>
                    <td colspan="2">{{$pp->message}}</td>
                    <td style="border-top: 1px solid; border-left: 1px solid;"><strong>TOTAL</strong></td>
                    <th style="border-top: 1px solid; border-left: 1px solid; text-align: right;"><strong>Rp @number($pp->grandtotal)</strong></th>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td style="border-top: 1px solid; border-left: 1px solid;">Balance Due</td>
                    <td style="border-top: 1px solid; border-left: 1px solid; text-align: right;">Rp @number($pp->balance_due)</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="footer"><small><i>Sales Quote #{{$pp->number}}</i></small></div>
</body>

</html>