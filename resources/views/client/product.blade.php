@extends('client.layouts.app')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('client.home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('client.shop')}}">Shop</a></li>
                    <li class="breadcrumb-item">{{$product->name}}</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-7 pt-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col-md-5">
                    <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner bg-light">

                            @if($product->product_images)
                                @foreach($product->product_images as $key => $productImage)
                                    <div class="carousel-item {{ ($key==0) ? 'active' : '' }}">
                                        <img class="w-100 h-100" src="{{ asset('uploads/products/large/'.$productImage->image) }}" alt="Image">
                                    </div>
                                @endforeach
                            @endif

                        </div>
                        <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                            <i class="fa fa-2x fa-angle-left text-dark"></i>
                        </a>
                        <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                            <i class="fa fa-2x fa-angle-right text-dark"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="bg-light right">
                        <h1>{{$product->name}}</h1>
                        <div class="d-flex mb-3">
                            <div class="text-primary mr-2">
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star-half-alt"></small>
                                <small class="far fa-star"></small>
                            </div>
                            <small class="pt-1">(99 Reviews)</small>
                        </div>
                        @if($product->compare_price > 0)
                            <h2 class="price text-secondary"><del>{{number_format($product->compare_price)}}₫</del></h2>
                        @endif
                        <h2 class="price ">{{number_format($product->price)}}₫</h2>

                        <div class="sub-title mt-5">
                            <h5>Size</h5>
                        </div>
                        <div class="d-flex col-3">
                            <select name="size" id="size" class="form-control">
                                <option value="">Select size</option>
                                @foreach($product->sizes as $size)
                                    <option value="{{$size->id}}">{{$size->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="sub-title mt-5">
                            <h5>Color</h5>
                        </div>
                        <div class="d-flex col-3">
                            <select name="color" id="color" class="form-control">
                                <option value="">Select color</option>
                                @foreach($product->colors as $color)
                                    <option value="{{$color->id}}">{{$color->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        @if($product->track_qty == 'Yes')
                            @if($product->qty > 0)
                                <a href="javascript:void(0);" onclick="addToCart({{$product->id}})" class="btn btn-dark mt-3"><i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART</a>
                            @else
                                <a href="#" class="btn btn-dark mt-3 disabled" style="pointer-events: none; opacity: 0.5;"><i class="fas fa-shopping-cart"></i> &nbsp;Out Of Stock</a>
                            @endif
                        @else
                            <a href="javascript:void(0);" onclick="addToCart({{$product->id}})" class="btn btn-dark mt-3"><i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART</a>
                        @endif
                    </div>
                </div>

                <div class="col-md-12 mt-5">
                    <div class="bg-light">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                                <p>
                                    {!! $product->description !!}
                                </p>
                            </div>
                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-5 section-8">
        @if(!empty($related_products))
        <div class="container">
            <div class="section-title">
                <h2>Related Products</h2>
            </div>
            <div class="col-md-12">
                <div id="related-products" class="carousel">
                        @foreach($related_products as $related_product)
                            @php $productImage = $related_product->product_images->first() @endphp
                            <div class="card product-card">
                                <div class="product-image position-relative">
                                    <a href="{{route('client.product', $related_product->name)}}" class="product-img">
                                        @if(!empty($productImage->image))
                                            <img class="card-img-top" src="{{asset('uploads/products/small/'.$productImage->image)}}" alt="imgProduct">
                                        @else
                                            <img class="card-img-top" src="/uploads/temp/default_product.png" alt="imgProduct">
                                        @endif
                                    </a>
                                    <a class="whishlist" onclick="addWishList({{$related_product->id}})" href="javascript:void(0);"><i class="far fa-heart"></i></a>

                                    <div class="product-action">
                                        @if($related_product->track_qty == 'Yes')
                                            @if($related_product->qty > 0)
                                                <a class="btn btn-dark" href="{{route('client.product', $related_product->name)}}">
                                                    <i class="fa fa-shopping-cart"></i> Buy Now
                                                </a>
                                            @else
                                                <a class="btn btn-dark" href="{{route('client.product', $related_product->name)}}">
                                                    <i class="fa fa-shopping-cart"></i> Out Of Stock
                                                </a>
                                            @endif
                                        @else
                                            <a class="btn btn-dark" href="{{route('client.product', $related_product->name)}}">
                                                <i class="fa fa-shopping-cart"></i> Buy Now
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body text-center mt-3">
                                    <a class="h6 link" href="">{{$related_product->name}}</a>
                                    <div class="price mt-2">
                                        <span class="h5"><strong>{{$related_product->price}}₫</strong></span>
                                        @if($related_product->compare_price > 0)
                                            <span class="h6 text-underline"><del>{{$related_product->compare_price}}₫</del></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                </div>
            </div>
        </div>
        @endif
    </section>
@endsection

@section('customJs')
    <script type="text/javascript">
        function addToCart(id){
            var size = $("#size").val();
            var color = $("#color").val();
            $.ajax({
                url: '{{ route('client.addCart') }}',
                type: 'POST',
                data: {
                    id: id,
                    size: size,
                    color: color
                },
                dataType: 'json',
                success : function(response) {
                    if (response.status == true){
                        window.location.href = "{{ route('client.cart') }}"
                    }
                    else {
                        toastr.warning(response.message);
                    }
                },
            });
        }
    </script>
@endsection
