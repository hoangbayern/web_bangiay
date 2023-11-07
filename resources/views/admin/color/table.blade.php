<table class="table table-hover text-nowrap">
    <thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @if($colors->isNotEmpty())
        @foreach($colors as $color)
            <tr>
                <td>
                    {{ $color->id }}
                </td>
                <td>
                    {{ $color->name }}
                </td>
                <td>
                    @if($color->status === 1)
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge badge-danger">Inactive</span>
                    @endif
                </td>
                <td>
                    <a href="{{route('color.edit', $color->id)}}"
                       class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i>
                    </a>

                    <a href="{{route('color.delete', $color->id)}}"
                       class="btn btn-sm btn-danger btn-delete">
                        <i class="fas fa-trash"></i>
                    </a>
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
    {{ $colors->links() }}
</div>
