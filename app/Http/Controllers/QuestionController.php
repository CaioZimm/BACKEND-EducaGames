<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        if(!Question::first()){
            return response()->json([ 'message' => "There aren't questions" ], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => Question::all()], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionRequest $request){
        $question = Question::create([
            'description' => $request->description,
            'type' => $request->input('type'),
            'score' => $request->score,
            'game_id' => $request->game_id
        ]);
        
        return response()->json( [ 'message' => 'Question created successfully', 'data' => $question ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id){
        $question = Question::with('alternative', 'answer')->find($id);

        if(!$question){
            return response()->json([ 'message' => 'Question not found' ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([ 'data' => $question ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id){
        $request->validate([
            'description' => ['string'],
            'type' => ['in:open,mult'],
            'score' => ['nullable']
        ]);

        $question = Question::find($id);

        if(!$question){
            return response()->json([ 'message' => 'Question not found' ], Response::HTTP_NOT_FOUND);
        }

        $question->update([
            'description' => $request->description ?: $question->description,
            'type' => $request->type ?: $question->type,
            'score' => $request->score ?: $question->score
        ]);

        return response()->json( [ 'message' => 'Game updated successfully', 'data' => $question ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        $question = Question::find($id);

        if(!$question){
            return response()->json([ 'message' => 'Question not found' ], Response::HTTP_NOT_FOUND);
        }

        $question->delete();

        return response()->json( [ 'message' => 'Question deleted successfully' ], Response::HTTP_OK);
    }
}
