@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Settings</h3>
    </div>
    <!--<div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Go!</button>
                </span>
            </div>
        </div>
    </div>-->
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <!--<div class="x_title">
                <h2>Company Settings</h2>
                <div class="clearfix"></div>
            </div>-->
            <div class="x_content">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="{{ (request()->is('settings/company')) ? 'active' : '' }}"><a href="{{route('company.index')}}">Company</a>
                        </li>
                        <li role="presentation" class="{{ (request()->is('settings/account')) ? 'active' : '' }}"><a href="{{route('acc_map.index')}}">Account Mapping</a>
                        </li>
                        <li role="presentation" class="{{ (request()->is('settings/user')) ? 'active' : '' }}"><a href="{{route('user')}}">User Management</a>
                        </li>

                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1"
                            aria-labelledby="satu-tab">
                            @yield('contentTab')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/other/select2.js?v=5-26012020') }}" charset="utf-8"></script>
@endpush