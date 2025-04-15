<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        if(!User::first()){
            return response()->json([ 'message' => "There aren't users" ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([ 'data' => User::all()], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show($id = null){
        if($id){
            $user = User::find($id);

            if(!$user){
                return response()->json(['message' => "User not found"], Response::HTTP_NOT_FOUND);
            }

            return response()->json(['data' => $user], Response::HTTP_OK);
        }

        $profile = Auth::user();

        if(!$profile){
            return response()->json([ 'message' => 'Profile not found' ], Response::HTTP_NOT_FOUND);
        }

        return response()->json( ['data' => $profile ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id = null){
        $request->validate([
            'name' => ['string', 'max:255'],
            'nickname' => ['string', 'unique:'.User::class],
            'foundation_id' => ['nullable', 'exists:foundation,id'],
            'avatar_id' => ['nullable', 'exists:avatar,id']
        ]);
        
        if($id){
            $user = User::find($id);

            if(!$user){
                return response()->json(['message' => "User not found"], Response::HTTP_NOT_FOUND);
            }

            $user->update([
                'name' => $request->name ?: $user->name,
                'nickname' => $request->nickname ?: $user->nickname,
                'foundation_id' => $request->foundation_id ?: $user->foundation_id,
                'avatar_id' => $request->avatar_id ?: $user->avatar_id
            ]);

            return response()->json([ 'message' => 'User updated successfully', 'data' => $user ], Response::HTTP_OK);
        }

        $profile = Auth::user();

        if(!$profile){
            return response()->json([ 'message' => 'Profile not found' ], Response::HTTP_NOT_FOUND);
        }

        /** @var \App\Models\User $profile */
        $profile->update([
            'name' => $request->name ?: $profile->name,
            'nickname' => $request->nickname ?: $profile->nickname,
            'foundation_id' => $request->foundation_id ?: $profile->foundation_id,
            'avatar_id' => $request->avatar_id ?: $profile->avatar_id
        ]);

        return response()->json( [ 'message' => 'Profile updated successfully', 'data' => $profile ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id = null){
        if($id){
            $user = User::find($id);

            if(!$user){
                return response()->json(['message' => "User not found"], Response::HTTP_NOT_FOUND);
            }

            /** @var \App\Models\User $user */
            $user->delete();

            return response()->json(['message' => 'User deleted successfully'], Response::HTTP_OK);
        }

        $profile = Auth::user();

        if(!$profile){
            return response()->json([ 'message' => 'Profile not found' ], Response::HTTP_NOT_FOUND);
        }

        /** @var \App\Models\User $profile */
        $profile->delete();

        return response()->json( ['message' => 'User deleted successfully' ], Response::HTTP_OK);
    }
}
