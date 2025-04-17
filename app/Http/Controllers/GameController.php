<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Services\ResultService;
use App\Http\Requests\GameRequest;
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
            'foundation_id' => $request->user()->foundation_id ?: $request->foundation_id
        ]);

        return response()->json( [ 'message' => 'Game created successfully', 'data' => $game ], Response::HTTP_CREATED);
    } 

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request){
        $isUserPlaying = $request['play'] ?: null;

        $game = Game::withCount('question');

        if($isUserPlaying){
            $game = $game->with(['question' => function ($query){
                $query->with('alternative');
            }]);
        }

        $game = $game->find($id);

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

    public function finish(Request $request, ResultService $resultService){
        $data = $request->validate([
            'game_id' => ['required', 'exists:game,id'],
            'answers' => ['array']
        ]);
        $data['user_id'] = $request->user()->id;

        $result = $resultService->resultUser($data);

        return response()->json([ 'data' => $result ]);
    }
}