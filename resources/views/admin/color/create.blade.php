@extends('layouts.main')
@section('contents')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Create Color</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('adminHome')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('color.list')}}">List Color</a></li>
                            <li class="breadcrumb-item active">Create Color</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
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
                            <form action="" method="post" id="form-data" name="categoryForm">
                                @csrf
                                @method('POST')
                                <div class="form-group required">
                                    <label for="inputName">Color Name</label>
                                    <input type="text" id="input-name" name="name" class="form-control">
                                    <span id="name-error" class="error invalid-feedback"></span>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="inputStatus">Status</label>
                                    <select id="inputStatus" name="status" class="form-control custom-select">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <a href="{{route('color.list')}}" class="btn btn-secondary">Cancel</a>
                    <button type="button" class="btn btn-success float-right btn-save">Create</button>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection
