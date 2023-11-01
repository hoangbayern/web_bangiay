@extends('auth.main')
@section('contents')
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form action="{{route('admin.postLogin')}}" method="POST" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="input-group mb-3">
                    <input name="email" value="{{ old('email') }}" type="email" class="form-control"
                           placeholder="Email">
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
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input name="remember" type="checkbox" id="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            @error('errorLogin')
            <span class="input-group mt-3 mb-3" style="margin-top: -12px; color: red">{{ $message }}</span>
            @enderror
            <div class="social-auth-links text-center mb-3">
                <p>- OR -</p>
                <a href="#" class="btn btn-block btn-secondary">
                    <i class="fab fa-github mr-2"></i> Sign in using Github
                </a>
            </div>
            <!-- /.social-auth-links -->
            <p class="mb-1">
                <a href="{{route('admin.forgetPassword')}}">I forgot my password</a>
            </p>
            <p class="mb-0">
                <a href="{{route('admin.register')}}" class="text-center">Register a new membership</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
@endsection
