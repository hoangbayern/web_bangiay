@extends('client.layouts.app')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('client.home')}}">Home</a></li>
                    <li class="breadcrumb-item">Register</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-10">
        <div class="container">
            <div class="login-form">
                <form action="{{route('client.postRegisterClient')}}" method="post">
                    @csrf
                    @method('POST')
                    <h4 class="modal-title">Register Now</h4>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Name" id="name" name="name">
                    </div>
                    @error('name')
                    <span class="input-group mb-3" style="margin-top: -12px; color: red">{{ $message }}</span>
                    @enderror
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Email" id="email" name="email">
                    </div>
                    @error('email')
                    <span class="input-group mb-3" style="margin-top: -12px; color: red">{{ $message }}</span>
                    @enderror
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                    </div>
                    @error('password')
                    <span class="input-group mb-3" style="margin-top: -12px; color: red">{{ $message }}</span>
                    @enderror
                    <div class="form-group">
                        <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" id="confirm_password">
                    </div>
                    @error('confirm_password')
                    <span class="input-group mb-3" style="margin-top: -12px; color: red">{{ $message }}</span>
                    @enderror
                    <div class="form-group small">
                        <a href="{{route('client.forgetPassword')}}" class="forgot-link">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn btn-dark btn-block btn-lg" value="Register">Register</button>
                </form>
                @error('errorRegister')
                <span class="input-group mt-3 mb-3" style="color: red">{{ $message }}</span>
                @enderror
                <div class="text-center small pt-3">Already have an account? <a href="{{route('client.login')}}">Login Now</a></div>
            </div>
        </div>
    </section>
@endsection
