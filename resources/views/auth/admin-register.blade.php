@extends('auth.main')
@section('contents')
    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Register a new membership</p>

            <form action="{{route('admin.postRegister')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="input-group mb-3">
                    <input name="name" type="text" class="form-control" placeholder="Name">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                @error('name')
                <span class="input-group mb-3" style="margin-top: -12px; color: red">{{ $message }}</span>
                @enderror
                <div class="input-group mb-3">
                    <input name="email" type="email" class="form-control" placeholder="Email">
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
                    <input name="password" type="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                @error('password')
                <span class="input-group mb-3" style="margin-top: -12px; color: red">{{ $message }}</span>
                @enderror
                <div class="input-group mb-3">
                    <input name="confirm_password" type="password" class="form-control" placeholder="Confirm password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                @error('confirm_password')
                <span class="input-group mb-3" style="margin-top: -12px; color: red">{{ $message }}</span>
                @enderror
                <div class="row d-flex flex-row-reverse">
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            @error('errorRegister')
            <span class="input-group mt-3 mb-3" style="color: red">{{ $message }}</span>
            @enderror
            <div class="social-auth-links text-center">
                <p>- OR -</p>
                <a href="#" class="btn btn-block btn-secondary">
                    <i class="fab fa-github mr-2"></i>
                    Sign up using Github
                </a>
            </div>

            <a href="{{ route('admin.login') }}" class="text-center">I already have a membership</a>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
@endsection
