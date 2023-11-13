@extends('layouts.main')

@section('contents')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Order: #SS{{$order->id}}</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{route('order.list')}}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                @if(\Illuminate\Support\Facades\Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{\Illuminate\Support\Facades\Session::get('success')}}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header pt-3">
                                <div class="row invoice-info">
                                    <div class="col-sm-7 invoice-col">
                                        <h1 class="h5 mb-3">Shipping Address</h1>
                                        <address>
                                            FullName: <strong>{{ $order->full_name }}</strong><br>
                                            Address: <strong>{{ $order->address }} - {{ $order->ward }} - {{ $order->district }} - {{ $order->province }}</strong><br>
                                            Phone: <strong>{{ $order->phone }}</strong><br>
                                            Email: <strong>{{ $order->email }}</strong>
                                        </address>
                                    </div>



                                    <div class="col-sm-5 invoice-col">
                                        <br>
                                        <br>
                                        Order ID: <b>SS{{$order->id}}</b><br>
                                        Total: <b>{{number_format($order->grand_total)}}₫</b><br>
                                        Status: @if($order->status == 'pending')
                                            <span class="badge bg-warning text-dark">{{ $order->status }}</span>
                                        @elseif($order->status == 'shipped')
                                            <span class="badge bg-info">{{ $order->status }}</span>
                                        @elseif($order->status == 'delivered')
                                            <span class="badge bg-success">{{ $order->status }}</span>
                                        @elseif($order->status == 'completed')
                                            <span class="badge bg-secondary">{{ $order->status }}</span>
                                        @elseif($order->status == 'cancelled')
                                            <span class="badge bg-danger">{{ $order->status }}</span>
                                        @endif
                                        <br>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-3">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Size</th>
                                        <th>Color</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orderItems as $item)
                                        <tr>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->size}}</td>
                                            <td>{{$item->color}}</td>
                                            <td>{{number_format($item->price)}}₫</td>
                                            <td>{{$item->qty}}</td>
                                            <td>{{number_format($item->total)}}₫</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th colspan="5" class="text-right">Subtotal:</th>
                                        <td>{{number_format($order->subtotal)}}₫</td>
                                    </tr>

                                    <tr>
                                        <th colspan="5" class="text-right">Shipping:</th>
                                        <td>{{number_format($order->shipping)}}₫</td>
                                    </tr>
                                    <tr>
                                        <th colspan="5" class="text-right">Grand Total:</th>
                                        <td>{{number_format($order->grand_total)}}₫</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <form action="" method="post" name="changeOrderStatus" id="changeOrderStatus">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Order Status</h2>
                                    <div class="mb-3">
                                        <select name="status" id="status" class="form-control">
                                            <option value="pending" {{$order->status == 'pending' ? 'selected' : ''}}>Pending</option>
                                            <option value="shipped" {{$order->status == 'shipped' ? 'selected' : ''}}>Shipped</option>
                                            <option value="delivered" {{$order->status == 'delivered' ? 'selected' : ''}}>Delivered</option>
                                            <option value="completed" {{$order->status == 'completed' ? 'selected' : ''}}>Completed</option>
                                            <option value="cancelled" {{$order->status == 'cancelled' ? 'selected' : ''}}>Cancelled</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Send Inovice Email</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Customer</option>
                                        <option value="">Admin</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary">Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $("#changeOrderStatus").submit(function (event){
            event.preventDefault();
           $.ajax({
               url: '{{route('order.changeOrderStatus', $order->id)}}',
               type: 'POST',
               data: $(this).serializeArray(),
               dataType: 'json',
               success: function (response){
                   if (response.status == true){
                       window.location.href = '{{route('order.detail', $order->id)}}'
                   }
               }
           })
        });
    </script>
@endpush
