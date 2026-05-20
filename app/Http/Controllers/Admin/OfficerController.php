<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class OfficerController extends Controller
{
    public function index()
    {
        $officers = User::where('role', UserRole::Officer)->latest()->paginate(10);
        return view('admin.officers.index', compact('officers'));
    }

    public function create()
    {
        return view('admin.officers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => UserRole::Officer,
        ]);

        return redirect()->route('admin.officers.create')->with('status', 'Officer created successfully!');
    }
}
