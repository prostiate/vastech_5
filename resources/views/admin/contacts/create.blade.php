@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Create Contact</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate">
                    <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel">
                            <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h4 class="panel-title"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> General Information</h4>
                            </a>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <div id="demo-form2" class="form-horizontal form-label-left">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="display_name"><span class="required">*</span> Display Name
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input placeholder="Display Name" type="text" id="display_name" name="display_name" required="required" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="contact_type"><span class="required">*</span> Contact Type
                                            </label>
                                            <div class="col-md-1 col-sm-1 col-xs-4">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" id="contact_type1" name="contact_type1" value="1"> Customer
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-sm-1 col-xs-4">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" id="contact_type2" name="contact_type2" value="1"> Vendor
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-sm-1 col-xs-4">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" id="contact_type3" name="contact_type3" value="1"> Employee
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-sm-1 col-xs-4">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" id="contact_type4" name="contact_type4" value="1"> Others
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="contact_name">Contact Name
                                            </label>
                                            <div class="col-lg-2 col-sm-2 col-xs-12">
                                                <input placeholder="First Name" type="text" id="first_name" name="first_name" class="form-control col-md-7 col-xs-12">
                                            </div>
                                            <div class="col-lg-2 col-sm-2 col-xs-12">
                                                <input placeholder="Middle Name" type="text" id="middle_name" name="middle_name" class="form-control col-md-7 col-xs-12">
                                            </div>
                                            <div class="col-lg-2 col-sm-2 col-xs-12">
                                                <input placeholder="Last Name" type="text" id="last_name" name="last_name" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="handphone">Handphone
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input placeholder="Handphone" type="text" id="handphone" name="handphone" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="identity">Identity
                                            </label>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <select id="identity_type" name="identity_type" class="form-control col-md-7 col-xs-12 selectidenfitytype">
                                                    <option></option>
                                                    <option value="KTP">KTP</option>
                                                    <option value="SIM">SIM</option>
                                                    <option value="Passport">Passport</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <input placeholder="Identity Number" type="text" id="identity_number" name="identity_number" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input placeholder="Email" type="email" id="email" name="email" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="another_info">Another Info
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input placeholder="Another Info" type="text" id="another_info" name="another_info" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="company_name">Company Name
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input placeholder="Company Name" type="text" id="company_name" name="company_name" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Telephone
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input placeholder="Telephone" type="text" id="telephone" name="telephone" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fax">Fax
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input placeholder="Fax" type="text" id="fax" name="fax" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="npwp">NPWP
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input placeholder="(99.999.999.9-999.999)" type="text" id="npwp" name="npwp" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="billing_address">Billing Address
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input placeholder="Billing Address" type="text" id="billing_address" name="billing_address" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="shipping_address">Shipping Address
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input placeholder="Shipping Address" type="text" id="shipping_address" name="shipping_address" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel">
                            <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <h4 class="panel-title"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> List of Bank</h4>
                            </a>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bank_name">Bank Name
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select id="bank_name" name="bank_name" class="form-control col-md-7 col-xs-12 selectbankname">
                                                    <option></option>
                                                    <option value="BCA">BCA</option>
                                                    <option value="BRI">BRI</option>
                                                    <option value="BNI">BNI</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bank_branch">Bank Branch
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input placeholder="Bank Branch" type="text" id="bank_branch" name="bank_branch" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bank_holder_name">Bank Holder Name
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input placeholder="Bank Holder Name" type="text" id="bank_holder_name" name="bank_holder_name" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="account_number">Account Number
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input placeholder="Account Number" type="text" id="account_number" name="account_number" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel">
                            <a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <h4 class="panel-title"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Chart of Account</h4>
                            </a>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body">
                                    <div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="account_receivable">Account Receivable
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control selectaccount" name="account_receivable">
                                                    <option></option>
                                                    @foreach($coa_receive as $a)
                                                    <option value="{{$a->id}}">
                                                        ({{$a->code}}) - {{$a->name}} ({{$a->coa_category->name}})
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="account_payable">Account Payable
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control selectaccount" name="account_payable">
                                                    <option></option>
                                                    @foreach($coa_payable as $a)
                                                    <option value="{{$a->id}}">
                                                        ({{$a->code}}) - {{$a->name}} ({{$a->coa_category->name}})
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="default_payment_terms">Default Payment Terms
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control selectterm" name="default_term">
                                                    <option></option>
                                                    @foreach($term as $a)
                                                    <option value="{{$a->id}}">
                                                        {{$a->name}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="col-md-3 center-margin">
                            <div class="form-group">
                                <a href="{{ url('/contacts_all') }}" class="btn btn-danger">Cancel</a>
                                <div class="btn-group">
                                    <button id="click" type="button" class="btn btn-success">Create </button>
                                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a id="clicknew">Create & New </a>
                                        </li>
                                        <li><a id="click">Create </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/contacts/createForm.js')}}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js')}}" charset="utf-8"></script>
@endpush