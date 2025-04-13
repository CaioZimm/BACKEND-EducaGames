<?php

namespace App\Http\Controllers;

use App\Models\Foundation;
use Illuminate\Http\Request;
use App\Http\Requests\FoundationRequest;
use Symfony\Component\HttpFoundation\Response;

class FoundationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        if(!Foundation::first()){
            return response()->json([ 'message' => "There aren't foundations" ], Response::HTTP_NOT_FOUND);
        }

        return response()->json( [ 'data' => Foundation::all() ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FoundationRequest $request){
        $foundation = Foundation::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response()->json( [ 'message' => 'Foundation created successfully', 'data' => $foundation ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id){
        $foundation = Foundation::find($id);

        if(!$foundation){
            return response()->json([ 'message' => 'Foundation not found' ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([ 'data' => $foundation ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id){
        $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255']
        ]);
        
        $foundation = Foundation::find($id);

        if(!$foundation){
            return response()->json([ 'message' => 'Foundation not found' ], Response::HTTP_NOT_FOUND);
        }

        $foundation->update([
            'name' => $request->name ?: $foundation->name,
            'description' => $request->description ?: $foundation->description,
        ]);

        return response()->json( [ 'message' => 'Foundation updated successfully', 'data' => $foundation ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        $foundation = Foundation::find($id);

        if(!$foundation){
            return response()->json([ 'message' => 'Foundation not found' ], Response::HTTP_NOT_FOUND);
        }

        $foundation->delete();

        return response()->json( [ 'message' => 'Foundation deleted successfully' ], Response::HTTP_OK);
    }
}
