<table class="table table-hover text-nowrap">
    <thead>
    <tr>
        <th>Order #</th>
        <th>Customer</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Status</th>
        <th>Total</th>
        <th>Date Purchased</th>
    </tr>
    </thead>
    <tbody>
    @if($orders->isNotEmpty())
        @foreach($orders as $order)
            <tr>
                <td>
                    <a href="{{route('order.detail', $order->id)}}">
                        SS{{ $order->id }}
                    </a>
                </td>
                <td>
                    {{ $order->full_name }}
                </td>
                <td>
                    {{ $order->email }}
                </td>
                <td>
                    {{ $order->phone }}
                </td>
                <td>
                    @if($order->status == 'pending')
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
                </td>
                <td>
                    {{number_format($order->grand_total)}}₫
                </td>
                <td>
                    {{ $order->created_at }}
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="6" class="text-center">
                <span style="color: red">No data found.</span>
            </td>
        </tr>
    @endif
    </tbody>
</table>
<div class="mt-3 mr-2 float-right">
    {{ $orders->links() }}
</div>
