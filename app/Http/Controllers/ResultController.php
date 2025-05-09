<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function show($id)
    {
        $result = Result::findOrFail($id);

        if (!$result) {
            return redirect()->route('quiz')->with('error', 'Please complete the quiz first.');
        }

        // Check if the 'ingredients' and 'tips' are strings before decoding
        $ingredients = is_string($result->ingredients) ? json_decode($result->ingredients) : $result->ingredients;
        $tips = is_string($result->tips) ? json_decode($result->tips) : $result->tips;

        return view('result', [
            'result' => $result,
            'ingredients' => $ingredients,
            'tips' => $tips,
        ]);
    }
}
