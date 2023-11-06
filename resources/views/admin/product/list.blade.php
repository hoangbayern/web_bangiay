@extends('layouts.main')
@section('contents')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">List Product</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('adminHome')}}">Home</a></li>
                            <li class="breadcrumb-item active">List Product</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- /.row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline">
                            <div class="card-header">
                                <div class="card-tools float-left">
                                    <div class="input-group input-group-sm" style="width: 200%;">
                                        <form id="form-search" action="{{route('product.search')}}"
                                              style="width: 100%;" method="GET">
                                            @csrf
                                            @method('GET')
                                            <div class="d-flex flex-row mb-3">
                                                <select name="category" id="category"
                                                        class="form-control form-control-sm mr-3 category">
                                                    <option value="">------>Select Category<------</option>
                                                    @foreach($categories as $category)
                                                        <option
                                                            value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                                <input name="name" id="name"
                                                       class="form-control form-control-sm name" type="text"
                                                       placeholder="Name product">
                                            </div>
                                            <div class="d-flex flex-row mb-3">
                                                <input name="price_from" id="price-from"
                                                       class="form-control form-control-sm mr-3 price-from"
                                                       type="number" min="0"
                                                       placeholder="Price from">
                                                <input name="price_to" id="price-to"
                                                       class="form-control form-control-sm price-to" type="number"
                                                       min="0"
                                                       placeholder="Price to">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-tools float-right">
                                    <div class="input-group input-group-sm" style="width: 150%;">
                                        <a href="{{route('product.create')}}"
                                           class="btn btn-sm btn-success">
                                            <i class="fas fa-plus-square mr-2"></i> Create
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <div id="table-data">

                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>

        <!-- /.content -->
    </div>
@endsection
