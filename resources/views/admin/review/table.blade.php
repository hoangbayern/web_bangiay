<table class="table table-hover text-nowrap">
    <thead>
    <tr>
        <th>ID</th>
        <th>Product</th>
        <th>Rating</th>
        <th>Comment</th>
        <th>Rated by</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @if($reviews->isNotEmpty())
        @foreach($reviews as $item)
            <tr>
                <td>
                    <a href="{{route('review.detail', $item->id)}}">
                        {{$item->id}}
                    </a>
                </td>
                <td>
                    {{$item->product->name}}
                </td>
                <td>
                    {{ number_format($item->rating, 1) }}
                </td>
                <td>
                    {{ Str::limit($item->comment, 30) }}
                </td>
                <td>
                    {{$item->username}}
                </td>
                <td>
                    @if($item->status === 1)
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge badge-danger">Inactive</span>
                    @endif
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
    {{ $reviews->links() }}
</div>
