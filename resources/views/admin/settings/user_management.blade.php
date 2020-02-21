@extends('layouts.admin')

@section('content')
@hasrole('Owner')
<div class="x_panel">
    <div class="x_content">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Create New User</button>
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="POST" action="{{ route('user.add') }}">
                        @csrf
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Create New User</h4>
                        </div>
                        <div class="modal-body">

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>

                                <div class="col-md-6">
                                    <select class="form-control" name="role">
                                        @foreach($roles as $a)
                                        <option>
                                            {{$a}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Assign New
            Role</button>
        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <h4>Text in a modal</h4>
                        <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis
                            lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
                        <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel
                            scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus
                            auctor fringilla.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action" style="width:100%">
            <thead>
                <tr class="headings">
                    <th class="column-title">Name</th>
                    <th class="column-title">Email</th>
                    <th class="column-title">Roles</th>
                    <th class="column-title">Status</th>
                    <th class="column-title">Type</th>
                    <th class="column-title">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr>
                    <td>{{$u->name}}</td>
                    <td>{{$u->email}}</td>
                    <td>
                        @if(!empty($u->getRoleNames()))
                        @foreach($u->getRoleNames() as $v)
                        <label class="badge badge-success">{{ $v }}</label>
                        @endforeach
                        @endif
                    </td>
                    <td></td>
                    <td></td>
                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endrole
@endsection

@push('scripts')
<script src="{{ asset('js/settings/user/dataTable.js?v=5-20200221-1431') }}" charset="utf-8"></script>
@endpush