<table class="table table-hover text-nowrap">
    <thead>
    <tr>
        <th>Id</th>
        <th>Image</th>
        <th>Name</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Gender</th>
        <th>Size</th>
        <th>Color</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @if($products->isNotEmpty())
        @foreach($products as $product)
            <tr>
                <td>
                    {{ $product->id }}
                </td>
                <td>
                    @php $productImage = $product->product_images->first() @endphp
                    @if(!empty($productImage->image))
                        <img src="{{asset('uploads/products/small/'.$productImage->image)}}" alt="imgProduct"
                             style="object-fit: cover; width: 110px; height: 110px;">
                    @else
                        <img src="/uploads/temp/default_product.png" alt="imgProduct"
                             style="object-fit: cover; width: 110px; height: 110px;">
                    @endif
                </td>
                <td>
                    {{ $product->name }}
                </td>
                <td>
                    {{ number_format($product->price) }}
                </td>
                <td>
                    {{ number_format($product->qty) }}
                </td>
                <td>
                    @if($product->gender === 1)
                        Male
                    @else
                        Female
                    @endif
                </td>
                <td>
                    @foreach($product->sizes as $key => $size)
                        {{ $size->name }}
                        @if (!$loop->last), @endif
                    @endforeach
                </td>
                <td>
                    @foreach($product->colors as $key => $color)
                        {{ $color->name }}
                        @if (!$loop->last), @endif
                    @endforeach
                </td>
                <td>
                    @if($product->status === 1)
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge badge-danger">Inactive</span>
                    @endif
                </td>
                <td>

                    <a href="{{route('product.edit', $product->id)}}"
                       class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i>
                    </a>

                    <a href="{{route('product.delete', $product->id)}}"
                       class="btn btn-sm btn-danger btn-delete">
                        <i class="fas fa-trash"></i>
                    </a>

                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7" class="text-center">
                <span style="color: red">No data found.</span>
            </td>
        </tr>
    @endif
    </tbody>
</table>
<div class="mt-3 mr-2 ml-2">
    {{ $products->links() }}
</div>
