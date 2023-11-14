@extends('client.layouts.app')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('client.profile')}}">My Account</a></li>
                    <li class="breadcrumb-item">Wishlist</li>
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
                            <h2 class="h5 mb-0 pt-2 pb-2">My Wishlist</h2>
                        </div>
                        <div class="card-body p-4">
                            @if($wishlists->count() > 0)
                            @foreach($wishlists as $item)
                                <div class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom">
                                    <div class="d-block d-sm-flex align-items-start text-center text-sm-start">
                                        @php $productImage = getProductImage($item->product_id) @endphp
                                        <a class="d-block flex-shrink-0 mx-auto me-sm-4" href="{{route('client.product', $item->product->name)}}" style="width: 10rem;">
                                            @if(!empty($productImage->image))
                                                <img src="{{asset('uploads/products/small/'.$productImage->image)}}" alt="imgProduct">
                                            @else
                                                <img src="/uploads/temp/default_product.png" alt="imgProduct">
                                            @endif
                                        </a>
                                        <div class="pt-2">
                                            <h3 class="product-title fs-base mb-2"><a href="{{route('client.product', $item->product->name)}}">{{$item->product->name}}</a></h3>
                                            <span class="h5"><strong>{{number_format($item->product->price)}}₫</strong></span>
                                            @if($item->product->compare_price > 0)
                                                <span class="h6 text-underline"><del>{{number_format($item->product->compare_price)}}₫</del></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                                        <button onclick="removeItemWishlist({{$item->id}})" class="btn btn-outline-danger btn-sm" type="button"><i class="fas fa-trash-alt me-2"></i>Remove</button>
                                    </div>
                                </div>
                            @endforeach
                            @else
                                <div class="alert alert-info text-center" role="alert" style="font-size: 18px">
                                    Your wishlist is empty.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script>
        function removeItemWishlist(id){
            $.ajax({
                url: '{{route('client.removeItemWishlist')}}',
                type: 'POST',
                data: {id:id},
                dataType: 'json',
                success: function (response){
                    if (response.status == true){
                        window.location.href = '{{route('client.wishlist')}}'
                    }
                    else {
                        toastr.error('Deleted Item Failed');
                    }
                }
            });
        }
    </script>
@endsection
