@extends('layouts.main')
@section('contents')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Create Product</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('adminHome')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">List Product</a></li>
                            <li class="breadcrumb-item active">Create Product</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <form action="{{route('product.store')}}" method="post" id="form-data" name="productForm">
                @csrf
                @method('POST')
            <div class="row">
                <div class="col-md-8">
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
                            <div class="form-group required">
                                <label for="inputName">Product Name</label>
                                <input type="text" name="name" id="input-name" class="form-control">
                                <span id="name-error" class="error invalid-feedback"></span>
                            </div>
                            <div class="form-group required">
                                <label for="inputDescription">Product Description</label>
                                <textarea id="summernote" name="description"></textarea>
                            </div>
                            <div class="form-group required">
                                <label for="inputStatus">Gender</label>
                                <select id="input-gender" name="gender" class="form-control custom-select">
                                    <option value="1">Male</option>
                                    <option value="0">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="sizes">Sizes</label>
                                <select name="sizeIds[]" class="select2" id="input-size" multiple="multiple"
                                        data-placeholder="Select sizes" style="width: 100%;">
                                    @if($sizes->isNotEmpty())
                                        @foreach($sizes as $size)
                                            <option value="{{$size->id}}">{{$size->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span id="size-error" class="error invalid-feedback"></span>
                            </div>
                            <div class="form-group">
                                <label for="colors">Colors</label>
                                <select name="colorIds[]" class="select2" id="input-color" multiple="multiple"
                                        data-placeholder="Select colors" style="width: 100%;">
                                    @if($colors->isNotEmpty())
                                        @foreach($colors as $color)
                                            <option value="{{$color->id}}">{{$color->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span id="color-error" class="error invalid-feedback"></span>
                            </div>
                            <div class="form-group">
                                <label for="inputStatus">Status</label>
                                <select id="inputStatus" name="status" class="form-control custom-select">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputStatus">Featured product</label>
                                <select id="inputStatus" name="is_featured" class="form-control custom-select">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-4">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Category</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group required">
                                <label for="inputStatus">Category</label>
                                <select id="input-category" name="category_id" class="form-control custom-select">
                                    <option>Select a Category</option>
                                    @if($categories->isNotEmpty())
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span id="category-error" class="error invalid-feedback"></span>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Pricing & Qty</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputEstimatedBudget">Price</label>
                                <input type="text" name="price" id="input-price" class="form-control">
                                <span id="price-error" class="error invalid-feedback"></span>
                            </div>
                            <div class="form-group">
                                <label for="inputSpentBudget">Compare at Price</label>
                                <input type="text" name="compare_price" id="inputSpentBudget" class="form-control">
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" name="track_qty" type="hidden" value="No">
                                    <input class="form-check-input" name="track_qty" type="checkbox" value="Yes" checked>
                                    <label class="form-check-label">Track Quantity</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputQty">Qty</label>
                                <input type="number" min="0" name="qty" id="input-qty" class="form-control">
                                <span id="qty-error" class="error invalid-feedback"></span>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            </form>
            <div class="row mb-3">
                <div class="col-12">
                    <a href="#" class="btn btn-secondary">Cancel</a>
                    <button type="button" class="btn btn-success float-right btn-save">Create</button>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection
