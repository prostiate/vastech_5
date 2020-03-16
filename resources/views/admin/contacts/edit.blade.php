@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>@lang('contact.edit.title')</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate">
                    <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel">
                            <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h4 class="panel-title"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>@lang('contact.edit.general')</h4>
                            </a>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <div id="demo-form2" class="form-horizontal form-label-left">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="display_name">@lang('contact.edit.display_name')
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input value="{{$contact->display_name}}" placeholder="Display Name" type="text" id="display_name" name="display_name" required="required" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="contact_type">@lang('contact.edit.contact_type.contact_type')
                                            </label>
                                            <div class="col-md-1 col-sm-1 col-xs-4">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" id="contact_type1" name="contact_type1" @if($contact->type_customer == 1) value="{{$contact->type_customer}}" checked @else value="1" @endif>@lang('contact.edit.contact_type.contact_type_1')
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-sm-1 col-xs-4">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" id="contact_type2" name="contact_type2" @if($contact->type_vendor == 1) value="{{$contact->type_vendor}}" checked @else value="1" @endif>@lang('contact.edit.contact_type.contact_type_2')
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-sm-1 col-xs-4">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" id="contact_type3" name="contact_type3" @if($contact->type_employee == 1) value="{{$contact->type_employee}}" checked @else value="1" @endif>@lang('contact.edit.contact_type.contact_type_3')
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-sm-1 col-xs-4">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" id="contact_type4" name="contact_type4" @if($contact->type_other == 1) value="{{$contact->type_other}}" checked @else value="1" @endif>@lang('contact.edit.contact_type.contact_type_4')
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @if($check_transaction == 0)
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="limit">@lang('contact.edit.limit')
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input onClick="this.select();" value="{{$contact->limit_balance}}" type="text" class="form-control col-md-7 col-xs-12 limit_balance_display">
                                                <input value="{{$contact->limit_balance}}" type="text" name="limit_balance" class="hidden_limit_balance" hidden>
                                            </div>
                                        </div>
                                        @else
                                        <input value="{{$contact->limit_balance}}" type="text" name="limit_balance" class="hidden_limit_balance" hidden>
                                        @endif
                                        @if($contact->sales_type == 'GT' or $contact->sales_type == 'MT' or $contact->sales_type == 'WS')
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="limit">Sales Type
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select id="sales_type" name="sales_type" class="form-control selectunit">
                                                    <option value="GT" @if($contact->sales_type == 'GT') selected @endif>General Trade</option>
                                                    <option value="MT" @if($contact->sales_type == 'MT') selected @endif>Modern Trade</option>
                                                    <option value="WS" @if($contact->sales_type == 'WS') selected @endif>Wholesaler</option>
                                                </select>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="contact_name">@lang('contact.edit.contact_name.contact_name')
                                            </label>
                                            <div class="col-lg-2 col-sm-2 col-xs-12">
                                                <input value="{{$contact->first_name}}" placeholder="First Name" type="text" id="first_name" name="first_name" class="form-control col-md-7 col-xs-12">
                                            </div>
                                            <div class="col-lg-2 col-sm-2 col-xs-12">
                                                <input value="{{$contact->middle_name}}" placeholder="Middle Name" type="text" id="middle_name" name="middle_name" class="form-control col-md-7 col-xs-12">
                                            </div>
                                            <div class="col-lg-2 col-sm-2 col-xs-12">
                                                <input value="{{$contact->last_name}}" placeholder="Last Name" type="text" id="last_name" name="last_name" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="handphone">@lang('contact.edit.handphone')
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input value="{{$contact->handphone}}" placeholder="Handphone" type="text" id="handphone" name="handphone" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="identity">@lang('contact.edit.identity')
                                            </label>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <select id="identity_type" name="identity_type" class="form-control col-md-7 col-xs-12 selectidenfitytype">
                                                    <option></option>
                                                    <option value="KTP" @if($contact->identity_type == 'KTP') selected = "selected" @endif</option>KTP</option>
                                                    <option value="SIM" @if($contact->identity_type == 'SIM') selected = "selected" @endif>SIM</option>
                                                    <option value="Passport" @if($contact->identity_type == 'Passport') selected = "selected" @endif>Passport</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <input value="{{$contact->identity_id}}" placeholder="Identity Number" type="text" id="identity_number" name="identity_number" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">@lang('contact.edit.email')
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input value="{{$contact->email}}" placeholder="Email" type="email" id="email" name="email" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="another_info">@lang('contact.edit.another_info')
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input value="{{$contact->another_info}}" placeholder="Another Info" type="text" id="another_info" name="another_info" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="company_name">@lang('contact.edit.company_name')
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input value="{{$contact->company_name}}" placeholder="Company Name" type="text" id="company_name" name="company_name" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">@lang('contact.edit.telephone')
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input value="{{$contact->telephone}}" placeholder="Telephone" type="text" id="telephone" name="telephone" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fax">@lang('contact.edit.fax')
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input value="{{$contact->fax}}" placeholder="Fax" type="text" id="fax" name="fax" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="npwp">@lang('contact.edit.npwp')
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input value="{{$contact->npwp}}" placeholder="(99.999.999.9-999.999)" type="text" id="npwp" name="npwp" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="billing_address">@lang('contact.edit.billing_address')
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input value="{{$contact->billing_address}}" placeholder="Billing Address" type="text" id="billing_address" name="billing_address" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="shipping_address">@lang('contact.edit.shipping_address')
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input value="{{$contact->shipping_address}}" placeholder="Shipping Address" type="text" id="shipping_address" name="shipping_address" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<div class="panel">
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
                        </div>-->
                        <div class="panel">
                            <a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <h4 class="panel-title"><span class="glyphicon glyphicon-book" aria-hidden="true"></span>@lang('contact.edit.coa')</h4>
                            </a>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body">
                                    <div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="account_receivable">@lang('contact.edit.ar')
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control selectaccount" name="account_receivable">
                                                    <option></option>
                                                    @foreach($coa_receive as $a)
                                                    <option value="{{$a->id}}" @if($contact->account_receivable_id == $a->id) selected = "selected" @endif>
                                                        ({{$a->code}}) - {{$a->name}} ({{$a->coa_category->name}})
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="account_payable">@lang('contact.edit.ap')
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control selectaccount" name="account_payable">
                                                    <option></option>
                                                    @foreach($coa_payable as $a)
                                                    <option value="{{$a->id}}" @if($contact->account_payable_id == $a->id) selected = "selected" @endif>
                                                        ({{$a->code}}) - {{$a->name}} ({{$a->coa_category->name}})
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="default_payment_terms">@lang('contact.edit.term')
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control selectterm" name="default_term">
                                                    <option></option>
                                                    @foreach($term as $a)
                                                    <option value="{{$a->id}}" @if($contact->term_id == $a->id) selected = "selected" @endif>
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
                        <div class="ln_solid"></div>
                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <a href="{{ url('/contacts/'.$contact->id) }}" class="btn btn-primary">@lang('contact.edit.cancel')</a>
                                    <button type="button" id="click" class="btn btn-success">@lang('contact.edit.update')</button>
                                    <input value="{{$contact->id}}" type="hidden" name="hidden_id" id="hidden_id" />
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
<script src="{{asset('js/contacts/updateForm.js?v=5-20200315-0243') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200315-0243') }}" charset="utf-8"></script>
<script>
    function inputMasking() {
        Inputmask.extendAliases({
            numeric: {
                prefix: "Rp",
                digits: 2,
                digitsOptional: false,
                decimalProtect: true,
                groupSeparator: ",",
                radixPoint: ".",
                radixFocus: true,
                autoGroup: true,
                autoUnmask: true,
                removeMaskOnSubmit: true
            }
        });
        Inputmask.extendAliases({
            IDR: {
                alias: "numeric",
                prefix: "Rp "
            }
        });
        $(".limit_balance_display").inputmask("IDR");
    }
    $(document).ready(function() {
        inputMasking();
        $(".limit_balance_display").on("keyup change", function() {
            if ($(this).val() < 0) {
                $(this).val('0');
            } else {
                var limit_balance_display = $(".limit_balance_display").val();
                $(".hidden_limit_balance").val(limit_balance_display);
            }
        });
    });
</script>
@endpush