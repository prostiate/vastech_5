@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Production One #{{$pro->number}}</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Transaction No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$pro->number}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Transaction Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$pro->transaction_date}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Result Product</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/products/{{$pro->id}}">{{$pro->product->name}}</a></h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Contact</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/contacts/{{$pro->contact_id}}">{{$pro->contact->display_name}}</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Result Qty</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$pro->result_qty}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Warehouse</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/warehouses/{{$pro->warehouse_id}}">{{$pro->warehouse->name}}</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Result Unit</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$pro->unit->name}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">Description</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$pro->desc}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group tiles"></div>
                    <br>
                    <div class="table-responsive my-5">
                        <table id="example" class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title" style="width: 450px">Raw Material</th>
                                    <th class="column-title">Quantity</th>
                                    <th class="column-title" style="width: 350px">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                @foreach($pro_item as $a)
                                <tr>
                                    <td>
                                        <h5><a href="/products/{{$a->id}}">{{$a->product->name}}</a></h5>
                                    </td>
                                    <td>
                                        <h5>{{$a->qty}}</h5>
                                    </td>
                                    <td>
                                        <h5>Rp @number($a->amount)</h5>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-right">
                                        <h5><strong>Total</strong></h5>
                                    <td colspan="1">
                                        <h5>Rp @number($pro->subtotal_raw)</h5>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <br>
                    <div class="table-responsive my-5">
                        <table id="example" class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title" style="width: 450px">Cost</th>
                                    <th class="column-title">Estimated Cost</th>
                                    <th class="column-title">Multiplier </th>
                                    <th class="column-title" style="width: 350px">Amount </th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody2">
                                @foreach($pro_cost as $a)
                                <tr>
                                    <td>
                                        <h5><a href="/chart_of_accounts/{{$a->coa_id}}">({{$a->coa->code}}) - {{$a->coa->name}} ({{$a->coa->coa_category->name}})</a></h5>
                                    </td>
                                    <td>
                                        <h5>Rp @number($a->estimated_cost)</h5>
                                    </td>
                                    <td>
                                        <h5>{{$a->multiplier}}</h5>
                                    </td>
                                    <td>
                                        <h5>Rp @number($a->amount)</h5>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right">
                                        <h5><strong>Total</strong></h5>
                                    <td colspan="1">
                                        <h5>Rp @number($pro->subtotal_cost)</h5>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm">Grand Total</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <h5>Rp @number($pro->grandtotal)</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/production_one') }}" class="btn btn-danger">Cancel</a>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success" onclick="window.location.href = '/production_one/edit/' + {{$pro->id}};">Edit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection