@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3>Update User Privilege</h3>
                <!--{{--<a>roles {{$user->roles}}</a>
                <a>permissions {{$user->permissions}}</a>
                <a>get permission {{$user->getPermissionNames()}}</a>
                <a>get role {{$user->getRoleNames()}}</a>--}}-->
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <br>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-4">
                                <label class="control-label col-md-4" style="text-align: left;">Name</label>
                            </div>
                            <div class="col-md-6">
                                <h5>: {{$user->name}}</h5>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">
                                <label class="control-label col-md-4" style="text-align: left;">Email</label>
                            </div>
                            <div class="col-md-6">
                                <h5>: {{$user->email}}</h5>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">
                                <label class="control-label col-md-4" style="text-align: left;">Roles</label>
                            </div>
                            <div class="col-md-6">
                                @if($user->roles->first()->id == 1)
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="role[]" value="1"> Owner
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="role[]" value="2"> Ultimate
                                    </label>
                                </div>
                                @endif
                                @if($user->roles->first()->id == 2)
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="role[]" value="2"> Ultimate
                                    </label>
                                </div>
                                @endif
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="sales" id="all_sales"> Sales
                                    </label><a> <i onclick="sales_collapse()" class="fa_sales fa fa-chevron-down down" id="sales_collapse"></i></a>
                                </div>
                                <div class="col-md-12 hidden_sales_div" hidden>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="sales" name="role[]" value="4"> Quote
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="sales" name="role[]" value="5"> Order
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="sales" name="role[]" value="6"> Delivery
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="sales" name="role[]" value="7"> Invoice
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="sales" name="role[]" value="8"> Payment
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="sales" name="role[]" value="9"> Return
                                        </label>
                                    </div>
                                    <br>
                                </div>
                                @if($user->company_id == 4)
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="role[]" value="28"> Sales GT
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="role[]" value="29"> Sales MT
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="role[]" value="30"> Sales WS
                                    </label>
                                </div>
                                @endif
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="purchase" id="all_purchase"> Purchase
                                    </label><a> <i onclick="purchase_collapse()" class="fa_purchase fa fa-chevron-down down" id="purchase_collapse"></i></a>
                                </div>
                                <div class="col-md-12 hidden_purchase_div" hidden>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="purchase" name="role[]" value="10"> Quote
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="purchase" name="role[]" value="11"> Order
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="purchase" name="role[]" value="12"> Delivery
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="purchase" name="role[]" value="13"> Invoice
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="purchase" name="role[]" value="14"> Payment
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="purchase" name="role[]" value="15"> Return
                                        </label>
                                    </div>
                                    <br>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="role[]" value="16"> Expense
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="role[]" value="17"> Production
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="role[]" value="18"> Contact
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="role[]" value="19"> Goods & Services
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="role[]" value="20"> Stock Adjustment
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="role[]" value="21"> Warehouses
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="role[]" value="22"> Warehouse Transfer
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="role[]" value="23"> Cash & Bank
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="role[]" value="24"> Chart of Account
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="role[]" value="25"> Other List
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="role[]" value="26"> Report Reader
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="role[]" value="27"> Settings
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">
                                <label class="control-label col-md-4" style="text-align: left;">Higher Roles</label>
                            </div>
                            <div class="col-md-6">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="permission[]" value="1"> Create
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="permission[]" value="2"> Edit
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="permission[]" value="3"> Delete
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-3 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/settings/user') }}" class="btn btn-danger">Cancel</a>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">Update</button>
                                <input type="text" value="{{$user->id}}" id="hidden_id" hidden>
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
<script src="{{asset('js/setting/updateForm.js?v=5-20200211-1624') }}" charset="utf-8"></script>
<script>
    $(document).ready(function() {
        $('#all_sales').change(function() {
            if ($(this).prop('checked')) {
                $('.hidden_sales_div').prop('hidden', false);
                $(".fa_sales").addClass("fa-chevron-up").removeClass("fa-chevron-down");
                $('.sales').prop('checked', true);
            } else {
                $('.hidden_sales_div').prop('hidden', true);
                $(".fa_sales").addClass("fa-chevron-down").removeClass("fa-chevron-up");
                $('.sales').prop('checked', false);
            }
        });
        $('#all_sales').trigger('change');
        $('#all_purchase').change(function() {
            if ($(this).prop('checked')) {
                $('.hidden_purchase_div').prop('hidden', false);
                $(".fa_purchase").addClass("fa-chevron-up").removeClass("fa-chevron-down");
                $('.purchase').prop('checked', true);
            } else {
                $('.hidden_purchase_div').prop('hidden', true);
                $(".fa_purchase").addClass("fa-chevron-down").removeClass("fa-chevron-up");
                $('.purchase').prop('checked', false);
            }
        });
        $('#all_purchase').trigger('change');
    });

    function sales_collapse() {
        if ($('#sales_collapse').prop('down')) {
            $('.hidden_sales_div').prop('hidden', false);
            $(".fa_sales").addClass("fa-chevron-up").removeClass("fa-chevron-down");
            $('#sales_collapse').prop('down', false);
        } else {
            $('.hidden_sales_div').prop('hidden', true);
            $(".fa_sales").addClass("fa-chevron-down").removeClass("fa-chevron-up");
            $('#sales_collapse').prop('down', true);
        }
    }

    function purchase_collapse() {
        if ($('#purchase_collapse').prop('down')) {
            $('.hidden_purchase_div').prop('hidden', false);
            $(".fa_purchase").addClass("fa-chevron-up").removeClass("fa-chevron-down");
            $('#purchase_collapse').prop('down', false);
        } else {
            $('.hidden_purchase_div').prop('hidden', true);
            $(".fa_purchase").addClass("fa-chevron-down").removeClass("fa-chevron-up");
            $('#purchase_collapse').prop('down', true);
        }
    }
</script>
@endpush