@extends('layouts.main')
@section('contents')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Update Product</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('adminHome')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('product.list')}}">List Product</a></li>
                            <li class="breadcrumb-item active">Update Product</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <form action="{{route('product.update', $data['product']->id)}}" method="post" id="form-data" name="productForm">
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
                                    <input type="text" name="name" value="{{$data['product']->name}}" id="input-name" class="form-control">
                                    <span id="name-error" class="error invalid-feedback"></span>
                                </div>
                                <div class="form-group required">
                                    <label for="inputDescription">Product Description</label>
                                    <textarea id="summernote" name="description">{{$data['product']->description}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="inputImage">Product Image</label>
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            <br>Drop files here or click to upload.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row" id="image-wrapper">
                                        @if($data['productImages']->isNotEmpty())
                                            @foreach ($data['productImages'] as $productImage)

                                                <div class="col-md-3 mb-3" id="product-image-row-{{ $productImage->id }}">
                                                    <div class="card image-card">
                                                        <input type="hidden" name="image_array[]"  value="{{ $productImage->id }}" class="form-control"/>

                                                        <img src="{{ asset('uploads/products/small/'.$productImage->image) }}" alt="" class="w-100 card-img-top">
                                                        <div class="card-body">
                                                            <a href="javascript:void(0)" onclick="deleteImage({{ $productImage->id }});" class="btn btn-danger">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group required">
                                    <label for="inputStatus">Gender</label>
                                    <select id="input-gender" name="gender" class="form-control custom-select">
                                        <option {{($data['product']->gender === 1) ? 'selected' : ''}} value="1">Male</option>
                                        <option {{($data['product']->gender === 0) ? 'selected' : ''}} value="0">Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="sizes">Sizes</label>
                                    <select name="sizeIds[]" class="select2" id="input-size" multiple="multiple"
                                            data-placeholder="Select sizes" style="width: 100%;">
                                        @if($data['sizes']->isNotEmpty())
                                            @foreach($data['sizes'] as $size)
                                                <option value="{{$size->id}}" {{ in_array($size->id, $data['product']->sizes->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                    {{$size->name}}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span id="size-error" class="error invalid-feedback"></span>
                                </div>
                                <div class="form-group">
                                    <label for="colors">Colors</label>
                                    <select name="colorIds[]" class="select2" id="input-color" multiple="multiple"
                                            data-placeholder="Select colors" style="width: 100%;">
                                        @if($data['colors']->isNotEmpty())
                                            @foreach($data['colors'] as $color)
                                                <option value="{{$color->id}}" {{ in_array($color->id, $data['product']->colors->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                    {{$color->name}}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span id="color-error" class="error invalid-feedback"></span>
                                </div>
                                <div class="form-group">
                                    <label for="inputStatus">Status</label>
                                    <select id="inputStatus" name="status" class="form-control custom-select">
                                        <option {{($data['product']->status === 1) ? 'selected' : ''}} value="1">Active</option>
                                        <option {{($data['product']->status === 0) ? 'selected' : ''}} value="0">Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputStatus">Featured product</label>
                                    <select id="inputStatus" name="is_featured" class="form-control custom-select">
                                        <option {{($data['product']->is_featured === 'No') ? 'selected' : ''}} value="No">No</option>
                                        <option {{($data['product']->is_featured === 'Yes') ? 'selected' : ''}} value="Yes">Yes</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="related_products">Related product</label>
                                    <select class="related-product w-100" multiple name="related_products[]" id="related_products">
                                        @if(!empty($data['related_products']))
                                            @foreach($data['related_products'] as $related_product)
                                                <option value="{{ $related_product->id }}" selected>
                                                    {{ $related_product->name }}
                                                </option>
                                            @endforeach
                                        @endif
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
                                        @if($data['categories']->isNotEmpty())
                                            @foreach($data['categories'] as $category)
                                                <option value="{{$category->id}}" {{($category->id == $data['product']->category_id) ? 'selected' : ''}}>
                                                    {{$category->name}}
                                                </option>
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
                                    <input type="text" name="price" value="{{$data['product']->price}}" id="input-price" class="form-control">
                                    <span id="price-error" class="error invalid-feedback"></span>
                                </div>
                                <div class="form-group">
                                    <label for="inputSpentBudget">Compare at Price</label>
                                    <input type="text" name="compare_price" value="{{$data['product']->compare_price}}" id="inputSpentBudget" class="form-control">
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" name="track_qty" type="hidden" value="No">
                                        <input class="form-check-input" name="track_qty" type="checkbox" value="Yes"
                                        {{$data['product']->track_qty === 'Yes' ? 'checked' : ''}}>
                                        <label class="form-check-label">Track Quantity</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputQty">Qty</label>
                                    <input type="number" min="0" value="{{$data['product']->qty}}" name="qty" id="input-qty" class="form-control">
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
                    <a href="{{route('product.list')}}" class="btn btn-secondary">Cancel</a>
                    <button type="button" class="btn btn-success float-right btn-save">Update</button>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

@push('scripts')
    <script>
        var product_id = {{ $data['product']->id }}
            Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            uploadprogress: function(file, progress, bytesSent) {
                $("button[type=submit]").prop('disabled',true);
            },
            url:  "{{ route('product-images.update') }}",
            params: {product_id:product_id},
            maxFiles: 10,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(file, response){
                var html = `<div class="col-md-3 mb-3" id="product-image-row-${response.image_id}">
                            <div class="card image-card">
                                 <input type="hidden" name="image_array[]" value="${response.image_id}"/>
                                <img src="${response.imagePath}" alt="" class="w-100 card-img-top">
                                <div class="card-body">
                                    <a href="javascript:void(0)" onclick="deleteImage(${response.image_id});" class="btn btn-danger">Delete</a>
                                </div>
                            </div>
                        </div>`;
                $("#image-wrapper").append(html);
                $("button[type=submit]").prop('disabled',false);
                this.removeFile(file);
            }
        });

        function deleteImage(id){
            if (confirm("Are you sure you want to delete?")) {
                var URL = "{{ route('product-images.delete','ID') }}";
                newURL = URL.replace('ID',id)

                $("#product-image-row-"+id).remove();

                $.ajax({
                    url: newURL,
                    data: {},
                    method: 'delete',
                    dataType:'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response){

                    }
                });
            }
        }

    </script>
@endpush
