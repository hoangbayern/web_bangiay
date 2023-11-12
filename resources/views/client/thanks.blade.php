@extends('client.layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="card-title text-success">Thank You for Your Order!</h3>
                        <p class="card-text">
                            Your order <span class="text-success">(ID: #SS{{ $orderId }})</span> has been successfully placed.
                            Our team is processing it, and you will receive a confirmation email shortly.
                        </p>
                        <p class="card-text">
                            If you have any questions or concerns, please feel free to contact our customer support.
                        </p>
                        <a href="{{ route('client.home') }}" class="btn btn-dark btn-block">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
