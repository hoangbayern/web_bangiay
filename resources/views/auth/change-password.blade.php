@extends('layouts.main')

@section('contents')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Change Password</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('adminHome')}}">Home</a></li>
                            <li class="breadcrumb-item active">Change Password</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            @if(\Illuminate\Support\Facades\Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{\Illuminate\Support\Facades\Session::get('success')}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">General</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="#" method="post" id="changePasswordForm" name="changePasswordForm">
                                @csrf
                                @method('POST')
                                <div class="form-group required">
                                    <label for="inputName">Old Password</label>
                                    <input type="password" id="old_password" name="old_password" class="form-control">
                                    <p></p>
                                </div>
                                <div class="form-group required">
                                    <label for="inputName">New Password</label>
                                    <input type="password" id="new_password" name="new_password" class="form-control">
                                    <p></p>
                                </div>
                                <div class="form-group required">
                                    <label for="inputName">Confirm Password</label>
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control">
                                    <p></p>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <a href="{{route('adminHome')}}" class="btn btn-secondary">Cancel</a>
                                        <button class="btn btn-success float-right">Create</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

@push('scripts')
    <script>
        $("#changePasswordForm").submit(function (e){
            e.preventDefault();
            $.ajax({
                url: '{{route('admin.updatePassword')}}',
                type: 'POST',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function (response){
                    var errors = response.errors;
                    if (response.status == true){
                        window.location.href = '{{route('admin.changePassword')}}';
                    }
                    else {
                        if (errors.old_password){
                            $("#old_password").addClass('is-invalid')
                                .siblings("p")
                                .addClass('invalid-feedback')
                                .html(errors.old_password);
                        }
                        else {
                            $("#old_password").removeClass('is-invalid')
                                .siblings("p")
                                .removeClass('invalid-feedback')
                                .html('');
                        }

                        if (errors.new_password){
                            $("#new_password").addClass('is-invalid')
                                .siblings("p")
                                .addClass('invalid-feedback')
                                .html(errors.new_password);
                        }
                        else {
                            $("#new_password").removeClass('is-invalid')
                                .siblings("p")
                                .removeClass('invalid-feedback')
                                .html('');
                        }

                        if (errors.confirm_password){
                            $("#confirm_password").addClass('is-invalid')
                                .siblings("p")
                                .addClass('invalid-feedback')
                                .html(errors.confirm_password);
                        }
                        else {
                            $("#confirm_password").removeClass('is-invalid')
                                .siblings("p")
                                .removeClass('invalid-feedback')
                                .html('');
                        }

                        $("#old_password, #new_password, #confirm_password").on("input", function() {
                            $(this).removeClass('is-invalid')
                                .siblings("p")
                                .removeClass('invalid-feedback')
                                .html('');
                        });
                    }
                }
            });
        });
    </script>
@endpush
