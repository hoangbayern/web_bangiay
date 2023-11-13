@extends('client.layouts.app')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('client.home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Shop</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-6 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 sidebar">
                    <div class="sub-title">
                        <h2>Categories</h2>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="accordionExample">
                                @if($categories->isNotEmpty())
                                    @foreach($categories as $category)
                                        <div class="accordion-item">
                                            <h6 class="accordion-header" id="headingOne">
                                                <a href="{{route('client.shop', $category->name)}}" class="nav-item nav-link {{ ($categorySelected === $category->id) ? 'text-primary' : '' }}">{{$category->name}}</a>
                                            </h6>
{{--                                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">--}}
{{--                                                <div class="accordion-body">--}}
{{--                                                    <div class="navbar-nav">--}}

{{--                                                        <a href="" class="nav-item nav-link">Tablets</a>--}}
{{--                                                        <a href="" class="nav-item nav-link">Laptops</a>--}}
{{--                                                        <a href="" class="nav-item nav-link">Speakers</a>--}}
{{--                                                        <a href="" class="nav-item nav-link">Watches</a>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="sub-title mt-5">
                        <h2>Gender</h2>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <select name="gender" id="gender" class="form-control">
                                <option {{ ($gender == 'gender_all') ? 'selected' : '' }} value="gender_all">Male & Female</option>
                                <option {{ ($gender == 'gender_male') ? 'selected' : '' }} value="gender_male">Male</option>
                                <option {{ ($gender == 'gender_female') ? 'selected' : '' }} value="gender_female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="sub-title mt-5">
                        <h2>Size</h2>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            @if($sizes->isNotEmpty())
                                @foreach($sizes as $size)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input size-label" {{ (in_array($size->id, $sizeArray)) ? 'checked' : '' }} type="checkbox" name="size[]" value="{{$size->id}}" id="size-{{ $size->id }}">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            {{$size->name}}
                                        </label>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>

                    <div class="sub-title mt-5">
                        <h2>Color</h2>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            @if($colors->isNotEmpty())
                                @foreach($colors as $color)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input color-label" {{ (in_array($color->id, $colorArray)) ? 'checked' : '' }} type="checkbox" name="color[]" value="{{$color->id}}" id="color-{{ $color->id }}">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            {{$color->name}}
                                        </label>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>

                    <div class="sub-title mt-5">
                        <h2>Price</h2>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <input type="text" class="js-range-slider" name="my_range" value="" />
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row pb-3">
                        <div class="col-12 pb-1">
                            <div class="d-flex align-items-center justify-content-end mb-4">
                                <div class="ml-2">
{{--                                    <div class="btn-group">--}}
{{--                                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">Sorting</button>--}}
{{--                                        <div class="dropdown-menu dropdown-menu-right">--}}
{{--                                            <a class="dropdown-item" href="#">Latest</a>--}}
{{--                                            <a class="dropdown-item" href="#">Price High</a>--}}
{{--                                            <a class="dropdown-item" href="#">Price Low</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <select name="sort" id="sort" class="form-control">
                                        <option {{ ($sort == 'latest') ? 'selected' : '' }} value="latest">Latest</option>
                                        <option {{ ($sort == 'price_high') ? 'selected' : '' }} value="price_high">Price High</option>
                                        <option {{ ($sort == 'price_low') ? 'selected' : '' }} value="price_low">Price Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        @if($products->isNotEmpty())
                            @foreach($products as $product)
                                @php $productImage = $product->product_images->first() @endphp
                                <div class="col-md-4">
                                    <div class="card product-card">
                                        <div class="product-image position-relative">
                                            <a href="{{route('client.product', $product->name)}}" class="product-img">
                                                @if(!empty($productImage->image))
                                                    <img class="card-img-top" src="{{asset('uploads/products/small/'.$productImage->image)}}" alt="imgProduct">
                                                @else
                                                    <img class="card-img-top" src="/uploads/temp/default_product.png" alt="imgProduct">
                                                @endif
                                            </a>
                                            <a class="whishlist" onclick="addWishList({{$product->id}})" href="javascript:void(0);"><i class="far fa-heart"></i></a>

                                            <div class="product-action">
                                                @if($product->track_qty == 'Yes')
                                                    @if($product->qty > 0)
                                                        <a class="btn btn-dark" href="{{route('client.product', $product->name)}}">
                                                            <i class="fa fa-shopping-cart"></i> Buy Now
                                                        </a>
                                                    @else
                                                        <a class="btn btn-dark" href="{{route('client.product', $product->name)}}">
                                                            <i class="fa fa-shopping-cart"></i> Out Of Stock
                                                        </a>
                                                    @endif
                                                @else
                                                    <a class="btn btn-dark" href="{{route('client.product', $product->name)}}">
                                                        <i class="fa fa-shopping-cart"></i> Buy Now
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="card-body text-center mt-3">
                                            <a class="h6 link" href="product.php">{{$product->name}}</a>
                                            <div class="price mt-2">
                                                <span class="h5"><strong>{{number_format($product->price)}}₫</strong></span>
                                                @if($product->compare_price > 0)
                                                    <span class="h6 text-underline"><del>{{number_format($product->compare_price)}}₫</del></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <div class="col-md-12 pt-5 float-right">
                            {{ $products->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
<script>
    rangeSlider = $(".js-range-slider").ionRangeSlider({
        type: "double",
        min: 0,
        max: 1000000,
        from: {{ $priceMin }},
        step: 10000,
        to: {{ $priceMax }},
        skin: "round",
        max_postfix: "+",
        prefix: "₫",
        onFinish: function () {
            apply_filters()
        }
    });
    var slider = $(".js-range-slider").data("ionRangeSlider");

    $(".size-label, .color-label").change(function () {
        apply_filters();
    })

    $("#sort").change(function () {
        apply_filters();
    })

    $("#gender").change(function () {
        apply_filters();
    })

    function apply_filters() {
        var sizes = [];
        var colors = [];

        $(".size-label").each(function () {
            if ($(this).is(":checked") == true) {
                sizes.push($(this).val());
            }
        });

        $(".color-label").each(function () {
            if ($(this).is(":checked") == true) {
                colors.push($(this).val());
            }
        });

        var url = '{{ url()->current() }}?';
        if (sizes.length > 0) {
            url += '&size=' + sizes.toString();
        }
        if (colors.length > 0) {
            url += '&color=' + colors.toString();
        }
        url += '&price_min=' + slider.result.from + '&price_max=' + slider.result.to;

        url += '&sort=' + $("#sort").val();

        url += '&gender=' + $("#gender").val();

        var keyword = $("#search").val();
        if (keyword.length > 0){
            url += '&search=' + keyword;
        }

        window.location.href = url;
    }
</script>
@endsection
