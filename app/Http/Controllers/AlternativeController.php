<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use Illuminate\Http\Request;
use App\Http\Requests\AlternativeRequest;
use Symfony\Component\HttpFoundation\Response;

class AlternativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        if(!Alternative::first()){
            return response()->json([ 'message' => 'Não existem alternativas' ], Response::HTTP_NOT_FOUND);
        }

        return response()->json( [ 'data' => Alternative::all()], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AlternativeRequest $request){
        $alternative = Alternative::create([
            'description' => $request->description,
            'is_correct' => $request->input('is_correct'),
            'question_id' => $request->question_id
        ]);

        return response()->json( [ 'message' => 'Alternativa criada com sucesso', 'data' => $alternative ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id){
        $alternative = Alternative::find($id);

        if(!$alternative){
            return response()->json([ 'message' => 'Alternative not found' ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([ 'data' => $alternative ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id){
        $request->validate([
            'description' => ['nullable', 'string'],
            'is_correct' => ['nullable', 'in:true,false']
        ]);

        $alternative = Alternative::find($id);

        if(!$alternative){
            return response()->json([ 'message' => 'Alternative not found' ], Response::HTTP_NOT_FOUND);
        }

        $alternative->update([
            'description' => $request->description ?: $alternative->description,
            'is_correct' => $request->input('is_correct') ?: $alternative->is_correct
        ]);

        return response()->json( [ 'message' => 'Alternative updated successfully', 'data' => $alternative ], Response::HTTP_OK);
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        $alternative = Alternative::find($id);

        if(!$alternative){
            return response()->json([ 'message' => 'Alternative not found' ], Response::HTTP_NOT_FOUND);
        }

        $alternative->delete();

        return response()->json( [ 'message' => 'Alternative deleted successfully' ], Response::HTTP_OK);
    }
}
