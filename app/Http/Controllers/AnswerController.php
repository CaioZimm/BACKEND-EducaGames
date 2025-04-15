<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Alternative;
use Illuminate\Http\Request;
use App\Http\Requests\AnswerRequest;
use Symfony\Component\HttpFoundation\Response;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        if(!Answer::first()){
            return response()->json([ 'message' => "There aren't answers" ], Response::HTTP_NOT_FOUND);
        }

        return response()->json( [ 'data' => Answer::all() ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AnswerRequest $request){
        $alternative_id = $request->alternative_id;
        
        if ($alternative_id) {
            $alternative = $this->alternativeAnswer($alternative_id);
        }

        $answer = Answer::create([
            'description' => $request->description ?: $alternative['description'],
            'is_correct' => $alternative['is_correct'] ?: 'waiting',
            'alternative_id' => $alternative_id,
            'user_id' => $request->user()->id,
            'question_id' => $request->question_id ?: $alternative['question_id']
        ]);

        return response()->json( [ 'message' => 'Answer created successfully', 'data' => $answer ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id){
        $answer = Answer::find($id);

        if(!$answer){
            return response()->json([ 'message' => 'Answer not found' ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([ 'data' => $answer ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id){
        $request->validate([
            'description' => ['nullable', 'string'],
            'is_correct' => ['in:waiting,correct,wrong,partially'],
            'alternative_id' => ['nullable', 'exists:alternative,id'],
        ]);

        $answer = Answer::find($id);

        if(!$answer){
            return response()->json([ 'message' => 'Answer not found' ], Response::HTTP_NOT_FOUND);
        }

        $alternative_id = $request->alternative_id;
        
        if ($alternative_id) {
            $alternative = $this->alternativeAnswer($alternative_id);

            $answer->update([
                'description' => $request->description ?: $alternative['description'],
                'is_correct' => $alternative['is_correct'] ?: 'waiting',
                'alternative_id' => $alternative_id
            ]);
        }

        $answer->update([
            'description' => $request->description ?: $answer->description,
            'is_correct' => $request->input('is_correct') ?: $answer->is_correct,
            'alternative_id' => $request->alternative_id ?: $answer->alternative_id
        ]);

        return response()->json( [ 'message' => 'Answer updated successfully', 'data' => $answer ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        $answer = Answer::find($id);

        if(!$answer){
            return response()->json([ 'message' => 'Answer not found' ], Response::HTTP_NOT_FOUND);
        }

        $answer->delete();

        return response()->json( [ 'message' => 'Answer deleted successfully' ], Response::HTTP_OK);
    }

    private function alternativeAnswer($alternative_id){
        $alternative = Alternative::find($alternative_id);
 
        $is_correct = $alternative->is_correct;
        if($is_correct === 'true'){
            $is_correct = 'correct';
        } 
        elseif($is_correct === 'false'){
            $is_correct = 'wrong';
        }

        return [
            'description' => $alternative->description,
            'question_id' => $alternative->question_id,
            'is_correct' => $is_correct
        ];
    }
}
