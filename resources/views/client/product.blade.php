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
                @if(\Illuminate\Support\Facades\Session::has('success'))
                    <div class="col-md-12">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {!! \Illuminate\Support\Facades\Session::get('success') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
                    @if(\Illuminate\Support\Facades\Session::has('warning'))
                        <div class="col-md-12">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                {!! \Illuminate\Support\Facades\Session::get('warning') !!}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
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
                        @php
                            $avgRating = 0;
                            if ($product->product_ratings_count > 0){
                                $avgRating = $product->product_ratings_sum_rating / $product->product_ratings_count;
                            }
                              $formattedRating = number_format($avgRating, 1);
                              $ratingPerAvg = ($avgRating * 100) / 5;
                        @endphp
                        <div class="d-flex mb-3">
                            <div class="star-rating product mt-2" title="">
                                <div class="back-stars">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>

                                    <div class="front-stars" style="width: {{$ratingPerAvg}}%">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <small class="pt-2 pl-2">({{$product->product_ratings_count}} Reviews)</small>
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
                                <div class="col-md-8">
                                    <div class="row">
                                        <form action="" method="post" id="productRatingForm" name="productRatingForm">
                                            <h3 class="h4 pb-3">Write a Review</h3>
                                            <div class="form-group col-md-6 mb-3">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" name="username" id="username" placeholder="Name">
                                                <p></p>
                                            </div>
                                            <div class="form-group col-md-6 mb-3">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                                                <p></p>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="rating">Rating</label>
                                                <br>
                                                <div class="rating" style="width: 10rem">
                                                    <input id="rating-5" type="radio" name="rating" value="5"/><label for="rating-5"><i class="fas fa-3x fa-star"></i></label>
                                                    <input id="rating-4" type="radio" name="rating" value="4"  /><label for="rating-4"><i class="fas fa-3x fa-star"></i></label>
                                                    <input id="rating-3" type="radio" name="rating" value="3"/><label for="rating-3"><i class="fas fa-3x fa-star"></i></label>
                                                    <input id="rating-2" type="radio" name="rating" value="2"/><label for="rating-2"><i class="fas fa-3x fa-star"></i></label>
                                                    <input id="rating-1" type="radio" name="rating" value="1"/><label for="rating-1"><i class="fas fa-3x fa-star"></i></label>
                                                </div>
                                                <p></p>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="">How was your overall experience?</label>
                                                <textarea name="comment"  id="comment" class="form-control" cols="30" rows="10" placeholder="How was your overall experience?"></textarea>
                                                <p></p>
                                            </div>
                                            <div>
                                                <button class="btn btn-dark">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-5">
                                    <div class="overall-rating mb-3">
                                        <div class="d-flex">
                                            @php
                                              $avgRating = 0;
                                              if ($product->product_ratings_count > 0){
                                                  $avgRating = $product->product_ratings_sum_rating / $product->product_ratings_count;
                                              }
                                                $formattedRating = number_format($avgRating, 1);
                                                $ratingPerAvg = ($avgRating * 100) / 5;
                                            @endphp

                                            <h1 class="h3 pe-3">{{$formattedRating}}</h1>
                                            <div class="star-rating mt-2" title="">
                                                <div class="back-stars">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>

                                                    <div class="front-stars" style="width: {{$ratingPerAvg}}%">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pt-2 ps-2">({{$product->product_ratings_count}} Reviews)</div>
                                        </div>

                                    </div>

                                    @if($product->product_ratings->isNotEmpty())
                                        @foreach($product->product_ratings as $item)
                                            @php $ratingPer = ($item->rating * 100)/5; @endphp
                                            <div class="rating-group mb-4">
                                                <span> <strong>{{$item->username}} </strong></span>
                                                <div class="star-rating mt-2" title="">
                                                    <div class="back-stars">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>

                                                        <div class="front-stars" style="width: {{$ratingPer}}%">
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="my-3">
                                                    <p>
                                                        {{$item->comment}}
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
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

        $("#productRatingForm").submit(function (e){
            e.preventDefault();
            $.ajax({
                url: '{{ route('client.saveRating', $product->id) }}',
                type: 'POST',
                data: $(this).serializeArray(),
                dataType: 'json',
                success : function(response) {
                    if (response.status == true){
                        window.location.href = "{{ route('client.product', $product->name) }}"
                    }
                    else {
                        var errors = response.errors;
                        if (errors.username){
                            $("#username").addClass('is-invalid')
                                .siblings("p")
                                .addClass('invalid-feedback')
                                .html(errors.username);
                        }
                        else {
                            $("#username").removeClass('is-invalid')
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

                        if (errors.rating){
                            $(".rating").addClass('is-invalid')
                                .siblings("p")
                                .addClass('invalid-feedback')
                                .html(errors.rating);
                        }
                        else {
                            $(".rating").removeClass('is-invalid')
                                .siblings("p")
                                .removeClass('invalid-feedback')
                                .html('');
                        }

                        if (errors.comment){
                            $("#comment").addClass('is-invalid')
                                .siblings("p")
                                .addClass('invalid-feedback')
                                .html(errors.comment);
                        }
                        else {
                            $("#comment").removeClass('is-invalid')
                                .siblings("p")
                                .removeClass('invalid-feedback')
                                .html('');
                        }

                        $("#username, #email, #comment").on("input", function() {
                            $(this).removeClass('is-invalid')
                                .siblings("p")
                                .removeClass('invalid-feedback')
                                .html('');
                        });

                        $(".rating").on("change", function() {
                            $(this).removeClass('is-invalid')
                                .siblings("p")
                                .removeClass('invalid-feedback')
                                .html('');
                        });
                    }
                },
            });
        });
    </script>
@endsection
