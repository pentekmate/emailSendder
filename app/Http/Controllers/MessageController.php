<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'string|required',
                'message' => 'string|required|max:255',
            ]);
            Message::create($validatedData);
            return response()->json(['message' => 'Sikeres üzenet küldés!'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {            
            $errorMessage = collect($e->errors())->flatten()->implode(' ');


            return response()->json(['message' =>$errorMessage ], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Hiba lépett fel a küldés közben.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
