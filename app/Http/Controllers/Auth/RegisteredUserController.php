<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\RegisterRequest;
use Symfony\Component\HttpFoundation\Response;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'nickname' => $request->nickname,
            'role' => $request->input('role', 'user'),
            'password' => Hash::make($request->string('password')),
            'foundation_id' => Auth::user()?->foundation_id ?? $request->foundation_id,
            'avatar_id' => $request->avatar_id
        ]);

        return response()->json([ 'message' => 'User created successfully', 'data' => $user ], Response::HTTP_CREATED);
    }
}
