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

        $number->random_number = rand(1, 75);

        foreach ($previous_numbers as $prev)
        {
            while ($prev->random_number === $number->random_number){
                $number->random_number = rand(1, 75);
            }
        }

        if(count($previous_numbers) < 75) {
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
