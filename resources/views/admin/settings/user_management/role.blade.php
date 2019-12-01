@extends('layouts.admin')
​
@section('title')
<title>Set Role</title>
@endsection
​
@section('content')
<div class="x-panel">
    <div class="x-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Set Role</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
                        <li class="breadcrumb-item active">Set Role</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    ​
    <section class="x-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('user.roles', $user->id) }}" method="post">
                        @csrf
                        <div class="x-content">
                            @slot('title')
                            @endslot

                            @if (session('success'))
                            @alert(['type' => 'success'])
                            {{ session('success') }}
                            @endalert
                            @endif

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <td>:</td>
                                            <td>{{ $user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>:</td>
                                            <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                        </tr>
                                        <tr>
                                            <th>Role</th>
                                            <td>:</td>
                                            <td>
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="tab_1">
                                                        @php $no = 1; @endphp
                                                        @foreach ($roles as $key => $row)
                                                        <input type="checkbox" name="role[]" value="{{ $row }}"
                                                            {{ $user->hasRole($row) ? 'checked':'' }}
                                                            {{--  CHECK, JIKA PERMISSION TERSEBUT SUDAH DI SET, MAKA CHECKED --}}>
                                                        {{ $row }} <br>
                                                        @if ($no++%4 == 0)
                                                        <br>
                                                        @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="x-footer">
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm float-right">
                                    Set Role
                                </button>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection