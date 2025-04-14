<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Requests\GameRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        if(!Game::first()){
            return response()->json([ 'message' => "There aren't games" ], Response::HTTP_NOT_FOUND);
        }

        return response()->json( [ 'data' => Game::all() ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GameRequest $request){
        $game = Game::create([
            'title' => $request->title,
            'description' => $request->description,
            'mode' => $request->input('mode'),
            'closed_time' => $request->closed_time,
            'password' => $request->password,
            'foundation_id' => Auth::user()?->foundation_id ?? $request->foundation_id
        ]);

        return response()->json( [ 'message' => 'Game created successfully', 'data' => $game ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id){
        $game = Game::with('question')->find($id);

        if(!$game){
            return response()->json([ 'message' => 'Game not found' ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([ 'data' => $game ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id){
        $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'mode' => ['nullable', 'in:competitive,casual'],
            'closed_time' => ['nullable', 'date'],
            'password' => ['nullable', 'string']
        ]);

        $game = Game::find($id);

        if(!$game){
            return response()->json([ 'message' => 'Game not found' ], Response::HTTP_NOT_FOUND);
        }

        $game->update([
            'title' => $request->title ?: $game->title,
            'description' => $request->description ?: $game->description,
            'mode' => $request->mode ?: $game->mode,
            'closed_time' => $request->closed_time ?: $game->closed_time,
            'password' => $request->password ?: $game->password
        ]);

        return response()->json( [ 'message' => 'Game updated successfully', 'data' => $game ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        $game = Game::find($id);

        if(!$game){
            return response()->json([ 'message' => 'Game not found' ], Response::HTTP_NOT_FOUND);
        }

        $game->delete();

        return response()->json( [ 'message' => 'Game deleted successfully' ], Response::HTTP_OK);
    }
}
