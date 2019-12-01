@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Create New Account</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <form id="formCreate" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">* Account Number
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="code" name="code" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">* Account Name
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Parent</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="parent" name="parent" class="form-control col-md-7 col-xs-12 selectcategory" type="text" onchange="getval(this);">
                                <option value="1">Parent</option>
                                <option value="0">Child</option>
                            </select>
                        </div>
                    </div>
                    <div id="show_parent_account" class="form-group" hidden>
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Parent Account</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="parent_account" name="parent_account" class="form-control col-md-7 col-xs-12 selectcategory" type="text">
                                @foreach($coa as $a)
                                <option value="{{$a->id}}">
                                    {{$a->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Category</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="coa_category_id" name="coa_category_id" class="form-control col-md-7 col-xs-12 selectcategory" type="text">
                                @foreach($coac as $a)
                                <option value="{{$a->id}}">
                                    {{$a->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Default Tax</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="default_tax" name="default_tax" class="form-control col-md-7 col-xs-12 selecttax" type="text" name="middle-name">
                                <option></option>
                                @foreach($taxes as $a)
                                <option value="{{$a->id}}">
                                    {{$a->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Start Balance</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="balance" value="0" name="balance" class="form-control col-md-7 col-xs-12" placeholder="Rp 0,00">
                        </div>
                    </div>
                    <!--<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Description
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea id="description" name="description" class="date-picker form-control col-md-7 col-xs-12" type="text"></textarea>
                        </div>
                    </div>-->
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-primary" type="button" onclick="window.location.href = '/chart_of_accounts';">Cancel</button>
                            <button id="click" type="submit" class="btn btn-success">Create Account</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/accounts/createForm.js')}}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js')}}" charset="utf-8"></script>
<script>
    function getval(sel) {
        if (sel.value == 1) {
            $('#show_parent_account').prop('hidden', true);
        } else {
            $('#show_parent_account').prop('hidden', false);
        }
    }
</script>
@endpush