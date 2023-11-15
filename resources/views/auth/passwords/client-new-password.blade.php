@extends('client.layouts.app')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <!-- ... (Code for the breadcrumb section) ... -->
    </section>

    <section class="section-10">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center mb-4">Forgot Your Password?</h4>
                            <form action="{{route('client.resetPasswordPost')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <input type="text" name="token" hidden value="{{$token}}">
                                <div class="form-group mb-4">
                                    <input type="email" class="form-control" name="email" placeholder="Email">
                                    @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group mb-4">
                                    <input type="password" class="form-control" name="password" placeholder="New password">
                                    @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group mb-4">
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                                    @error('password_confirmation')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-dark">Reset Password</button>
                                </div>
                            </form>
                            @error('errorLogin')
                            <div class="text-danger mt-3">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="card-footer text-center">
                            <div class="small">Don't have an account? <a href="{{ route('client.register') }}">Sign up</a></div>
                            <div class="small">Already have an account? <a href="{{ route('client.login') }}">Login</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
