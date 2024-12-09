<?php

namespace App\Http\Controllers;

use App\Models\CV;
use Illuminate\Http\Request;

class CvController extends Controller
{
    public function store(Request $request){
            try {
                $validatedData = $request->validate([
                    'type' => 'string|required',
                   
                ]);
                CV::create($validatedData);
                return response()->json(['message' => 'Sikeres mentés'], 200);
            } catch (\Illuminate\Validation\ValidationException $e) {            
                $errorMessage = collect($e->errors())->flatten()->implode(' ');
    
    
                return response()->json(['message' =>$errorMessage ], 422);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Hiba lépett fel a küldés közben.'. $e], 500);
            }
        
    }
}
