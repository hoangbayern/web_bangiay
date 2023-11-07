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
    @if($sizes->isNotEmpty())
        @foreach($sizes as $size)
            <tr>
                <td>
                    {{ $size->id }}
                </td>
                <td>
                    {{ $size->name }}
                </td>
                <td>
                    @if($size->status === 1)
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge badge-danger">Inactive</span>
                    @endif
                </td>
                <td>
                    <a href="{{route('size.edit', $size->id)}}"
                       class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i>
                    </a>

                    <a href="{{route('size.delete', $size->id)}}"
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
    {{ $sizes->links() }}
</div>
