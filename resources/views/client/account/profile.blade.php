@extends('client.layouts.app')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('client.profile')}}">My Account</a></li>
                    <li class="breadcrumb-item">Personal Information</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-11 ">
        <div class="container  mt-5">
            <div class="row">
                @if(\Illuminate\Support\Facades\Session::has('success'))
                    <div class="col-md-12">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {!! \Illuminate\Support\Facades\Session::get('success') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
                <div class="col-md-3">
                    @include('client.account.common.sidebar')
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">Personal Information</h2>
                        </div>
                        <form action="" id="profileForm" name="profileForm">
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" value="{{$user->name}}" name="name" id="name" placeholder="Enter Your Name" class="form-control">
                                        <p></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" value="{{$user->email}}" name="email" id="email" placeholder="Enter Your Email" class="form-control">
                                        <p></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone">Phone</label>
                                        <input type="text" value="{{ optional($user->profile)->phone }}" name="phone" id="phone" placeholder="Enter Your Phone" class="form-control">
                                        <p></p>
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone">Gender</label>
                                        <select name="gender" id="gender" class="form-control">
                                            @if($user->profile)
                                                <option {{($user->profile->gender === 1) ? 'selected' : ''}} value="1">Male</option>
                                                <option {{($user->profile->gender === 0) ? 'selected' : ''}} value="0">Female</option>
                                            @else
                                                <option selected value="1">Male</option>
                                                <option value="0">Female</option>
                                            @endif
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="birthday">Birthday</label>
                                        <input type="date" value="{{ optional($user->profile)->birthday }}" name="birthday" id="birthday" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone">Address</label>
                                        <textarea name="address" id="address" class="form-control" cols="30" rows="5" placeholder="Enter Your Address">{{ optional($user->profile)->address }}</textarea>
                                    </div>

                                    <div class="d-flex">
                                        <button class="btn btn-dark">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script>
        $("#profileForm").submit(function (e){
           e.preventDefault();
            $.ajax({
                url: '{{route('client.updateProfile')}}',
                type: 'POST',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function (response){
                    var errors = response.errors;
                    if (response.status == false){
                        if (errors.name){
                            $("#name").addClass('is-invalid')
                                .siblings("p")
                                .addClass('invalid-feedback')
                                .html(errors.name);
                        }
                        else {
                            $("#name").removeClass('is-invalid')
                                .siblings("p")
                                .removeClass('invalid-feedback')
                                .html('');
                        }

                        if (errors.email){
                            $("#email").addClass('is-invalid')
                                .siblings("p")
                                .addClass('invalid-feedback')
                                .html(errors.email);
                        }
                        else {
                            $("#email").removeClass('is-invalid')
                                .siblings("p")
                                .removeClass('invalid-feedback')
                                .html('');
                        }

                        if (errors.phone){
                            $("#phone").addClass('is-invalid')
                                .siblings("p")
                                .addClass('invalid-feedback')
                                .html(errors.phone);
                        }
                        else {
                            $("#phone").removeClass('is-invalid')
                                .siblings("p")
                                .removeClass('invalid-feedback')
                                .html('');
                        }

                        $("#name, #phone, #email").on("input", function() {
                            $(this).removeClass('is-invalid')
                                .siblings("p")
                                .removeClass('invalid-feedback')
                                .html('');
                        });
                    }
                    else {
                        window.location.href = '{{route('client.profile')}}';
                    }
                }
            });
        });
    </script>
@endsection
