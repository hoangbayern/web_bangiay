@extends('auth.main')
@section('contents')
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

            <form action="{{route('admin.resetPasswordPost')}}" method="post">
                @method('POST')
                @csrf
                <input type="text" name="token" hidden value="{{$token}}">
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                @error('email')
                <span class="input-group mb-3" style="margin-top: -12px; color: red">{{ $message }}</span>
                @enderror
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="New password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                @error('password')
                <span class="input-group mb-3" style="margin-top: -12px; color: red">{{ $message }}</span>
                @enderror
                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                @error('password_confirmation')
                <span class="input-group mb-3" style="margin-top: -12px; color: red">{{ $message }}</span>
                @enderror
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <p class="mt-3 mb-1">
                <a href="{{route('admin.login')}}">Login</a>
            </p>
            <p class="mb-0">
                <a href="{{route('admin.register')}}" class="text-center">Register a new membership</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
@endsection
