<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class RoleController extends Controller
{
    public function users()
    {
        $this->authorize('see.users');

        $users = User::with('roles')->where('role','!=',3)->get();
        return view('admin.shared.users', compact('users'));
    }

    public function manageRole()
    {
        $this->authorize('manage.role');

        $users = User::where('role','!=',3)->get();
        $roles = Role::all();
        return view('admin.shared.manage_role', compact(['users','roles']));
    }

    public function updateRole(Request $request)
{
    $request->validate([
        'role_id' => 'required|not_in:3',
    ]);

    User::where('id', $request->user_id)->update([
        'role' => $request->role_id
    ]);

    return redirect()->back();
}

}
