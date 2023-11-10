@extends('client.layouts.app')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('client.home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('client.shop')}}">Shop</a></li>
                    <li class="breadcrumb-item">Cart</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-9 pt-4">
        <div class="container">
            <div class="row">
                @if(\Illuminate\Support\Facades\Session::has('success'))
                    <div class="col-md-12">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ \Illuminate\Support\Facades\Session::get('success') }}
                            <button type="button" class="close float-right" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                @endif
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table" id="cart">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Remove</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($cartContent))
                                @foreach($cartContent as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if(!empty($item->options->productImage->image))
                                                    <img src="{{ asset('uploads/products/small/'.$item->options->productImage->image) }}" width="" height="">
                                                @endif
                                                <h2>{{$item->name}}</h2>
                                            </div>
                                        </td>
                                        <td>{{number_format($item->price)}}</td>
                                        <td>
                                            @if(isset($item->options->size['name']))
                                                {{$item->options->size['name']}}
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($item->options->color['name']))
                                                {{$item->options->color['name']}}
                                            @endif
                                        </td>
                                        <td>
                                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="text" class="form-control form-control-sm  border-0 text-center" value="{{ $item->qty }}">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ number_format($item->price * $item->qty) }}
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card cart-summery">
                        <div class="sub-title">
                            <h2 class="bg-white">Cart Summery</h2>
                        </div>
                        <div class="card-body">
                            @php
                                $subtotal = floatval(str_replace(',', '', \Gloudemans\Shoppingcart\Facades\Cart::subtotal()));
                                $shipping = 20000; // Giả sử phí vận chuyển là 20000₫
                                $total = $subtotal + $shipping;
                            @endphp
                            <div class="d-flex justify-content-between pb-2">
                                <div>Subtotal</div>
                                <div>{{ number_format($subtotal, 0, ',', ',') }}₫</div>
                            </div>
                            <div class="d-flex justify-content-between pb-2">
                                <div>Shipping</div>
                                <div>{{ number_format($shipping, 0, ',', ',') }}₫</div>
                            </div>
                            <div class="d-flex justify-content-between summery-end">
                                <div>Total</div>
                                <div>{{ number_format($total, 0, ',', ',') }}₫</div>
                            </div>
                            <div class="pt-5">
                                <a href="login.php" class="btn-dark btn btn-block w-100">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>
{{--                    <div class="input-group apply-coupan mt-4">--}}
{{--                        <input type="text" placeholder="Coupon Code" class="form-control">--}}
{{--                        <button class="btn btn-dark" type="button" id="button-addon2">Apply Coupon</button>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </section>
@endsection

