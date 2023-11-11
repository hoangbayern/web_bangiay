@extends('client.layouts.app')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('client.home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('client.shop')}}">Shop</a></li>
                    <li class="breadcrumb-item">Checkout</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-9 pt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="sub-title">
                        <h2>Shipping Address</h2>
                    </div>
                    <div class="card shadow-lg border-0">
                        <div class="card-body checkout-form">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Full Name">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Phone">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <select name="country" id="city" class="form-control">
                                            <option value="" selected>Select a Provice</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <select name="country" id="district" class="form-control">
                                            <option value="" selected>Select a District</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <select name="country" id="ward" class="form-control">
                                            <option value="" selected>Select a Ward</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="address" id="address" cols="30" rows="3" placeholder="Address" class="form-control"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="order_notes" id="order_notes" cols="30" rows="2" placeholder="Order Notes (optional)" class="form-control"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="sub-title">
                        <h2>Order Summery</h2>
                    </div>
                    <div class="card cart-summery">
                        <div class="card-body">
                            @foreach(\Gloudemans\Shoppingcart\Facades\Cart::content() as $item )
                                <div class="d-flex justify-content-between pb-2">
                                    <div class="h6">{{$item->name}},@if(isset($item->options->color['name']))
                                            {{$item->options->color['name']}}
                                        @endif, @if(isset($item->options->size['name']))
                                            {{$item->options->size['name']}}
                                        @endif</div>
                                    <div class="h6">X{{$item->qty}}</div>
                                    <div class="h6">{{number_format($item->price * $item->qty)}}₫</div>
                                </div>
                            @endforeach
                                @php
                                    $subtotal = floatval(str_replace(',', '', \Gloudemans\Shoppingcart\Facades\Cart::subtotal()));
                                    $shipping = (\Gloudemans\Shoppingcart\Facades\Cart::count() > 0) ? 20000 : 0; // Giả sử phí vận chuyển là 20000₫
                                    $total = $subtotal + $shipping;
                                @endphp
                            <div class="d-flex justify-content-between summery-end">
                                <div class="h6"><strong>Subtotal</strong></div>
                                <div class="h6"><strong>{{ number_format($subtotal, 0, ',', ',') }}₫</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="h6"><strong>Shipping</strong></div>
                                <div class="h6"><strong>{{ number_format($shipping, 0, ',', ',') }}₫</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2 summery-end">
                                <div class="h5"><strong>Total</strong></div>
                                <div class="h5"><strong>{{ number_format($total, 0, ',', ',') }}₫</strong></div>
                            </div>
                        </div>
                    </div>

                    <div class="card payment-form ">
                        <h3 class="card-title h5 mb-3">Payment Details</h3>
                        <div class="card-body p-0">
{{--                            <div class="mb-3">--}}
{{--                                <label for="card_number" class="mb-2">Card Number</label>--}}
{{--                                <input type="text" name="card_number" id="card_number" placeholder="Valid Card Number" class="form-control">--}}
{{--                            </div>--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <label for="expiry_date" class="mb-2">Expiry Date</label>--}}
{{--                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YYYY" class="form-control">--}}
{{--                                </div>--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <label for="expiry_date" class="mb-2">CVV Code</label>--}}
{{--                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="123" class="form-control">--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="pt-4">
                                <a href="#" class="btn-dark btn btn-block w-100">Thanh toán khi nhận hàng</a>
                            </div>
                        </div>
                    </div>


                    <!-- CREDIT CARD FORM ENDS HERE -->

                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script>
        var citis = document.getElementById("city");
        var districts = document.getElementById("district");
        var wards = document.getElementById("ward");
        var Parameter = {
            url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
            method: "GET",
            responseType: "application/json",
        };
        var promise = axios(Parameter);
        promise.then(function (result) {
            renderCity(result.data);
        });

        function renderCity(data) {
            for (const x of data) {
                citis.options[citis.options.length] = new Option(x.Name, x.Id);
            }
            citis.onchange = function () {
                district.length = 1;
                ward.length = 1;
                if(this.value != ""){
                    const result = data.filter(n => n.Id === this.value);

                    for (const k of result[0].Districts) {
                        district.options[district.options.length] = new Option(k.Name, k.Id);
                    }
                }
            };
            district.onchange = function () {
                ward.length = 1;
                const dataCity = data.filter((n) => n.Id === citis.value);
                if (this.value != "") {
                    const dataWards = dataCity[0].Districts.filter(n => n.Id === this.value)[0].Wards;

                    for (const w of dataWards) {
                        wards.options[wards.options.length] = new Option(w.Name, w.Id);
                    }
                }
            };
        }
    </script>
@endsection
