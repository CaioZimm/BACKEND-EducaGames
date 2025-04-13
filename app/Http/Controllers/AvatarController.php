<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use App\Http\Requests\AvatarRequest;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class AvatarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        if(!Avatar::first()){
            return response()->json(['message' => "There aren't avatars"], Response::HTTP_NOT_FOUND);
        }

        return response()->json([ 'data' => Avatar::all() ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AvatarRequest $request){
        $path = $request->file('url')->store('avatar', 'public');
        $url = asset("storage/{$path}");

        $avatar = Avatar::create([
            'url' => $url
        ]);

        return response()->json([ 'message' => 'Avatar created successfully', 'data' => $avatar ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id){
        $avatar = Avatar::find($id);

        if(!$avatar){
            return response()->json(['message' => 'Avatar not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => $avatar], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AvatarRequest $request, $id){
        $avatar = Avatar::find($id);

        if(!$avatar){
            return response()->json(['message' => "Avatar not found"], Response::HTTP_NOT_FOUND);
        }

        if($request->hasFile('url')){
            if ($avatar->url) {
                $oldPath = str_replace('/storage/', '', parse_url($avatar->url, PHP_URL_PATH));
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('url')->store('avatar', 'public');

            $avatar->url = asset("storage/{$path}");
        }

        $avatar->save();
        
        return response()->json([ 'message' => 'Avatar updated successfully', 'data' => $avatar], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        $avatar = Avatar::find($id);

        if(!$avatar){
            return response()->json(['message' => "Avatar not found"], Response::HTTP_NOT_FOUND);
        }

        if ($avatar->url) {
            $oldPath = str_replace('/storage/', '', parse_url($avatar->url, PHP_URL_PATH));
            Storage::disk('public')->delete($oldPath);
        }

        $avatar->delete();

        return response()->json([ 'message' => 'Avatar deleted successfully'], Response::HTTP_OK);
    }
}
