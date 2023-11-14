<table class="table table-hover text-nowrap">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Gender</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @if($users->isNotEmpty())
        @foreach($users as $user)
            <tr>
                <td>
                    {{$user->id}}
                </td>
                <td>
                    {{ $user->name }}
                </td>
                <td>
                    {{ $user->email }}
                </td>
                <td>
                    {{ optional($user->profile)->phone }}
                </td>
                <td>
                    @if($user->profile)
                        @if($user->profile->gender === 1)
                            Male
                        @else
                            Female
                        @endif
                    @endif
                </td>
                <td>
                    @if($user->status === 1)
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge badge-danger">Inactive</span>
                    @endif
                </td>
                <td>
                    <a href="{{route('user.edit', $user->id)}}"
                       class="btn btn-sm btn-secondary">
                        <i class="fas fa-edit"></i>
                    </a>

                    <a href="{{route('user.delete', $user->id)}}"
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
    {{ $users->links() }}
</div>
