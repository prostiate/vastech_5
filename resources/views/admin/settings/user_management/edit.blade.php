@extends('layouts.admin')
​​
@section('content')
<div class="x_panel">
        <div class="x_header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Edit user</h1>
                    </div>
                </div>
            </div>
        </div>
​
        <section class="x-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                            <div class="x_content">
                            @slot('title')
                            
                            @endslot
                            
                            @if (session('error'))
                                @alert(['type' => 'danger'])
                                    {!! session('error') !!}
                                @endalert
                            @endif
                            
                            <form action="{{ route('user.update', $user->id) }}" method="post">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <input type="text" name="name" 
                                        value="{{ $user->name }}"
                                        class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" required>
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" name="email" 
                                        value="{{ $user->email }}"
                                        class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}" 
                                        required readonly>
                                    <p class="text-danger">{{ $errors->first('email') }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" name="password" 
                                        class="form-control {{ $errors->has('password') ? 'is-invalid':'' }}">
                                    <p class="text-danger">{{ $errors->first('password') }}</p>
                                    <p class="text-warning">Biarkan kosong, jika tidak ingin mengganti password</p>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fa fa-send"></i> Update
                                    </button>
                                </div>
                            </form>
                            @slot('footer')
​
                            @endslot
                            </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection