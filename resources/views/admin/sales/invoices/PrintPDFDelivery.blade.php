<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delivery Slip #{{$pp->number}}</title>
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
            width: 100px;
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
            Delivery Slip
        </caption>
        <br>
        <br>
        <br>
        <table style="width: 100%">
            <thead>
                <tr>
                    <th colspan="4" style="text-align: right;"><strong>Delivery #{{$pp->number}}</strong></th>
                    <!--<th colspan="2" style="border-left: 1px solid;"></th>-->
                </tr>
                <tr>
                    <td colspan="2" style="border-top: 1px solid;">
                        <h4>{{$pp->contact->display_name}}</h4>
                        <br>
                        <p>{{$pp->email}}<br></p>
                    </td>
                    <td style="width: 116px; border-left: 1px solid; border-top: 1px solid;">
                        <p>Delivery Date</p>
                        <br>
                        <p>Customer Reference<br></p>
                    </td>
                    <td style="border-top: 1px solid;">
                        <p>{{$pp->transaction_date}}</p>
                        <br>
                        <p>{{$pp->vendor_ref_no}}<br></p>
                    </td>
                </tr>
                <tr>
                    <th colspan="3" style="width: 150px; border-top: 1px solid;">Product</th>
                    <th style="width: 50px; border-left: 1px solid; border-top: 1px solid; text-align: center;">Qty</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pp_item as $a)
                <tr>
                    <td colspan="3">{{$a->product->name}}</td>
                    <td style="border-left: 1px solid; text-align: right;">{{$a->qty}} - {{$a->unit->name}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <a style="margin-left: 15px;">PLEASE NOTE</a>
        <br>
        <br>
        <a style="margin-left: 15px;">{{$pp->message}}</a>
    </div>
    <div class="footer"><small><i>Sales Invoice #{{$pp->number}}</i></small></div>
</body>

</html>