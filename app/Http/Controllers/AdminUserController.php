<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:student,user,admin_club,staff,admin',
        ]);

        $user = User::findOrFail($id);

        // ป้องกันไม่ให้แก้ role ตัวเอง
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $user->role = $request->role;
        $user->save();

        return back()->with('success', "Role of {$user->name} updated to {$request->role}.");
    }
}
