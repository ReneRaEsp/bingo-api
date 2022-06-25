<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index()
    {
        $cards = Card::all();
        return $cards;
    }

    public function store(Request $request)
    {
        $card = $this->generateCard();

        $card->save();

        return $card;
    }

    public function show($id)
    {
        $card = Card::find($id);
        return $card;
    }

    public function update(Request $request, Card $card)
    {
        //
    }

    public function destroy(Card $card)
    {
        Card::truncate();
        return "Cards deleted";
    }

    public function generateCard()
    {
        $card = new Card();
        $column_b = [];
        $column_i = [];
        $column_n = [];
        $column_g = [];
        $column_o = [];
        
        $previous_numbers = [];
        for ($i = 0; $i < 5; $i++) {
            $column_b[$i] = rand(1, 15);
            
            foreach ($previous_numbers as $prev) {
                while ($prev === $column_b[$i]) {
                    $column_b[$i] = rand(1, 15);
                }
            }
            $previous_numbers[$i] = $column_b[$i];
        }

        $previous_numbers = [];
        for ($i = 0; $i < 5; $i++) {
            $column_i[$i] = rand(16, 30);
            
            foreach ($previous_numbers as $prev) {
                while ($prev === $column_i[$i]) {
                    $column_i[$i] = rand(16, 30);
                }
            }
            $previous_numbers[$i] = $column_i[$i];
        }

        $previous_numbers = [];
        for ($i = 0; $i < 5; $i++) {
            $column_n[$i] = rand(31, 45);
            
            foreach ($previous_numbers as $prev) {
                while ($prev === $column_n[$i]) {
                    $column_n[$i] = rand(31, 45);
                }
            }
            if ($i === 2) {
                $column_n[$i] = 0;
            }
            $previous_numbers[$i] = $column_n[$i];
        }

        $previous_numbers = [];
        for ($i = 0; $i < 5; $i++) {
            $column_g[$i] = rand(46, 60);
            
            foreach ($previous_numbers as $prev) {
                while ($prev === $column_g[$i]) {
                    $column_g[$i] = rand(46, 60);
                }
            }
            $previous_numbers[$i] = $column_g[$i];
        }

        $previous_numbers = [];
        for ($i = 0; $i < 5; $i++) {
            $column_o[$i] = rand(61, 75);
            
            foreach ($previous_numbers as $prev) {
                while ($prev === $column_o[$i]) {
                    $column_o[$i] = rand(61, 75);
                }
            }
            $previous_numbers[$i] = $column_o[$i];
        }

        $column_b = implode(",", $column_b);
        $column_i = implode(",", $column_i);
        $column_n = implode(",", $column_n);
        $column_g = implode(",", $column_g);
        $column_o = implode(",", $column_o);

        $card->column_b = $column_b;
        $card->column_i = $column_i;
        $card->column_n = $column_n;
        $card->column_g = $column_g;
        $card->column_o = $column_o;

        return $card;
    }

}
