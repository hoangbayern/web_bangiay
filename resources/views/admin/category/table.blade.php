<table class="table table-hover text-nowrap">
    <thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Description</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @if($categories->isNotEmpty())
        @foreach($categories as $category)
            <tr>
                <td>
                    {{ $category->id }}
                </td>
                <td>
                    {{ $category->name }}
                </td>
                <td>
                    {{ $category->description }}
                </td>
                <td>
                    @if($category->status === 1)
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge badge-danger">Inactive</span>
                    @endif
                </td>
                <td>
                    <a href="{{route('category.showFormEdit', $category->id)}}"
                       class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i>
                    </a>

                    <a href="{{route('category.delete', $category->id)}}"
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
    {{ $categories->links() }}
</div>
