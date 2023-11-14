<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected User $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function listUser()
    {
        return view('admin.user.list');
    }

    public function search(Request $request)
    {
        $users = $this->user->search($request->name);
        $view = view('admin.user.table', compact('users'))->render();
        return response()->json([
            'table' => $view,
        ], Response::HTTP_OK);
    }

    public function showFormEdit($id)
    {
        $user = $this->user->find($id);
        if ($user == null){
            session()->flash('error', 'User Not Found');
            return redirect()->route('user.list');
        }
        return view('admin.user.edit', compact('user'));
    }

    public function update(UpdateRequest $request, string $id)
    {
        $user = $this->user->findOrFail($id);
        $user->update($request->all());
        return redirect()->route('user.list')->withErrors([
            'success' => 'User Updated Successfully.'
        ]);
    }

    public function deleteUser(string $id)
    {
        $userId = $this->user->findOrFail($id);
        $userId->delete();

        return response()->json([
            'message' => 'Deleted User Successfully.'
        ], Response::HTTP_OK);
    }
}
