<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Expense #{{$pp->number}}</title>
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
            Expense Slip
        </caption>
        <br>
        <br>
        <br>
        <table style="width: 100%">
            <thead>
                <tr>
                    <th colspan="4" style="text-align: right;"><strong>Expense #{{$pp->number}}</strong></th>
                    <!--<th colspan="2" style="border-left: 1px solid;"></th>-->
                </tr>
                <tr>
                    <td style="width: 116px; border-left: 1px solid; border-top: 1px solid;">
                        <p>Address</p>
                        <br>
                        <br>
                        <br>
                        <br>
                    </td>
                    <td style="border-top: 1px solid;">
                        <p> : {{$pp->address}}</p>
                        <br>
                        <br>
                        <br>
                        <br>
                    </td>
                    <td style="width: 116px; border-left: 1px solid; border-top: 1px solid;">
                        <p>Transaction No</p>
                        <br>
                        <p>Transaction Date</p>
                        <br>
                        <p>Due Date</p>
                    </td>
                    <td style="border-top: 1px solid;">
                        <p> : {{$pp->number}}</p>
                        <br>
                        <p> : {{$pp->transaction_date}}</p>
                        <br>
                        <p> : {{$pp->due_date}}</p>
                    </td>
                </tr>
                <tr>
                    <th style="width: 100px; border-top: 1px solid;">Account Code</th>
                    <th style="width: 200px; border-left: 1px solid; border-top: 1px solid;">Account Name</th>
                    <th style="width: 180px; border-left: 1px solid; border-top: 1px solid;">Description</th>
                    <th style="width: 120px; border-left: 1px solid; border-top: 1px solid; text-align: right;">Amount (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pp_item as $a)
                <tr>
                    <td>{{$a->coa->code}}</td>
                    <td style="border-left: 1px solid;">{{$a->coa->name}}</td>
                    <td style="border-left: 1px solid;">{{$a->desc}}</td>
                    <td style="border-left: 1px solid; text-align: right;">Rp @number($a->amount)</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="border-top: 1px solid;">Information</td>
                    <td style="border-top: 1px solid; border-left: 1px solid;">Subtotal</td>
                    <td style="border-top: 1px solid; border-left: 1px solid; text-align: right;">Rp @number($pp->grandtotal)</td>
                </tr>
                <tr>
                    <td colspan="2">{{$pp->memo}}</td>
                    <td style="border-top: 1px solid; border-left: 1px solid;"><strong>TOTAL</strong></td>
                    <th style="border-top: 1px solid; border-left: 1px solid; text-align: right;"><strong>Rp @number($pp->grandtotal)</strong></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="footer"><small><i>Expense #{{$pp->number}}</i></small></div>
</body>

</html>