<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CreateUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Exclude admin users from the list
        $query->whereDoesntHave('roles', function ($q) {
            $q->where('name', 'admin');
        });

        // Filter berdasarkan pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan role (hanya akan menampilkan user)
        if ($request->has('role') && !empty($request->role)) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // Ambil data user dengan pagination
        $users = $query->latest()->paginate(10);

        return view('admin.user.index', compact('users'));
    }


    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        $user->assignRole('user');

        return redirect()->route('admin.user.index');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id); // ambil user
        return view('admin.user.edit', compact('user'));
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'password' => 'required|min:6',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $validatedData['name'],
            'password' => bcrypt($validatedData['password']),
        ]);

        return redirect()->route('admin.user.index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Cek apakah user sedang meminjam barang dan belum dikembalikan
        $sedangMeminjam = $user->peminjaman()
            ->whereDoesntHave('pengembalian')
            ->exists();

        if ($sedangMeminjam) {
            return redirect()->route('admin.user.index')
                ->with('error', 'User tidak dapat dihapus karena masih memiliki peminjaman yang belum dikembalikan.');
        }

        $user->delete();
        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
