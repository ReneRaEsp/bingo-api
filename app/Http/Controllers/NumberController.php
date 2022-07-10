<?php

namespace App\Http\Controllers;

use App\Models\Number;
use Illuminate\Http\Request;

class NumberController extends Controller
{
    public function index()
    {
        $numbers = Number::all();
        return $numbers;
    }

    public function store(Request $request)
    {
        $number = new Number();
        $previous_numbers = Number::all();
        $array = [];

        $i = 0; 
        foreach($previous_numbers as $prev) {
            $array[$i] = $prev->random_number;
            $i++;
        }

        do {
            $number->random_number = rand(1, 75);
        } while (in_array($number->random_number, $array));

        if (count($previous_numbers) < 75) {
            $number->save();
            return $number;
        }

        return "All number has been called";
    }

    public function destroy()
    {
        Number::truncate();
        return "Game restarted";
    }
}
