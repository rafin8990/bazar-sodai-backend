<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function viewLogin()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role' => 'nullable|in:user,admin,super_admin',
            'email_verified_at' => 'nullable|date',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_path('uploads/users');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $imageName);


            $fullImageUrl = url('public/uploads/users/' . $imageName);
            $data['image'] = $fullImageUrl;
        }

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        $token = $user->createToken($data['name']);

        return response()->json([
            "success" => true,
            "message" => "User registered successfully",
            "data" => $user,
            "token" => $token->plainTextToken
        ], 201);
    }


    public function loginFromDashboard(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->with('error', 'Invalid credentials.');
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);
        $user = User::where('email', $validatedData['email'])->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return [
                'message' => 'The provided credentials are incorrect.'
            ];
        }
        $token = $user->createToken($user->name);

        return response()->json([
            'success' => true,
            'message' => 'User logged in successfully',
            'user' => $user,
            'token' => $token->plainTextToken,
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'User logged out successfully',
        ], 200);
    }

    public function logoutfromDashboard(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully');
    }

    public function getUser(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'message' => 'User retrieved successfully',
            'data' => $user,
        ], 200);
    }

    public function updateUser(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|string|min:8|confirmed',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role' => 'nullable|in:user,admin,super_admin',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_path('uploads/users');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $imageName);

            $fullImageUrl = url('public/uploads/users/' . $imageName);
            $data['image'] = $fullImageUrl;
        }

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);

        return response()->json([
            "success" => true,
            "message" => "User updated successfully",
            "data" => $user
        ], 200);
    }

    public function deleteUser(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully',
        ], 200);
    }

    public function refreshToken(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        $token = $user->createToken($user->name);

        return response()->json([
            'success' => true,
            'message' => 'Token refreshed successfully',
            'token' => $token->plainTextToken,
        ], 200);
    }
}
