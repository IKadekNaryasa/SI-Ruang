<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Models\Bidang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('bidang')->get();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bidangs = Bidang::all();
        return view('user.create', compact('bidangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|max:255|unique:users,email',
            'bidang_id' => 'required|exists:bidangs,id',
            'role' => 'required|string|in:admin,operator'
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'bidang_id' => $validated['bidang_id'],
            'role' => $validated['role'],
            'password' => Hash::make('12345678'),
        ];

        try {
            User::create($data);
            return redirect()->route('user.index')->with('success', 'User created successfully!');
        } catch (Exception $e) {
            return back()->withErrors(['errors' => 'Failed created new user. Please try again!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $bidangs = Bidang::all();
        return view('user.edit', compact('user', 'bidangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:users,name' . $user->id,
            'email' => 'required|email|max:255|unique:users,email' . $user->id,
            'bidang_id' => 'required|exists:bidangs,id',
            'role' => 'required|string|in:admin,operator'
        ]);

        try {
            $user->update($validated);
            return redirect()->route('user.index')->with('success', 'User updated successfully!');
        } catch (Exception $e) {
            return back()->withErrors(['errors' => 'Failed updated user. Please try again!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return back()->with('success', 'User deleted successfully!');
        } catch (Exception $e) {
            return back()->withErrors(['errors' => 'Failed delete user. Please try again!']);
        }
    }
}
