@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Bank Transfer #{{$transfer->number}}</h3>
    </div>    
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button"
                            onclick="window.location.href = '/products/edit/';">Edit Profile
                        </button>
                    </li>
                    <li>
                        <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button"
                            aria-expanded="false"><span class="glyphicon glyphicon-wrench"></span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="#">Archive</a>
                            <li><a href="#">Delete</a>
                            </li>
                        </ul>
                    </li>
                </ul>   

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate">
                    <div class="panel-body">
                        <div id="demo-form2" class="form-horizontal form-label-left">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="asset_name">Transfers From
                                </label>
                                <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                    for="asset_name">{{$transfer->coa_t->name}}
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="asset_number">Deposit to
                                </label>
                                <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                    for="asset_number">{{$transfer->coa_d->name}}
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="asset_account">Transaction Date:
                                    
                                </label>
                                <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                    for="asset_account">{{$transfer->date}}
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="asset_desc">Amount
                                </label>
                                <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                    for="asset_desc">{{$transfer->amount}}
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="asset_date">Date
                                </label>
                                <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                    for="asset_date">{{$transfer->date}}
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection