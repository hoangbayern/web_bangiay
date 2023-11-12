@extends('client.layouts.app')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('client.profile')}}">My Account</a></li>
                    <li class="breadcrumb-item">My Orders</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-11 ">
        <div class="container  mt-5">
            <div class="row">
                <div class="col-md-3">
                    @include('client.account.common.sidebar')
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">My Orders</h2>
                        </div>
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                @if($myOrders->isNotEmpty())
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Orders #</th>
                                            <th>Date Purchased</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($myOrders as $item)
                                                <tr>
                                                    <td>
                                                        <a href="{{route('client.myOrderDetail', $item->id)}}">SS{{$item->id}}</a>
                                                    </td>
                                                    <td>{{$item->created_at->format('d-m-Y')}}</td>
                                                    <td>
                                                        @if($item->status == 'pending')
                                                            <span class="badge bg-warning text-dark">{{ $item->status }}</span>
                                                        @elseif($item->status == 'shipped')
                                                            <span class="badge bg-info">{{ $item->status }}</span>
                                                        @elseif($item->status == 'delivered')
                                                            <span class="badge bg-success">{{ $item->status }}</span>
                                                        @elseif($item->status == 'completed')
                                                            <span class="badge bg-secondary">{{ $item->status }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{number_format($item->grand_total)}}₫</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="alert alert-info text-center" role="alert">
                                        No orders found. <a href="{{ route('client.shop') }}" class="alert-link">Start shopping now!</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
