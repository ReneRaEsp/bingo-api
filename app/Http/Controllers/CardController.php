<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Number;
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

    public function markSquare($id, Request $request)
    {
        $card = Card::findOrFail($id);
        $numbers_called = Number::all();
        $matchOneTime = false;
        $column_b = $card->column_b;
        $column_i = $card->column_i;
        $column_n = $card->column_n;
        $column_g = $card->column_g;
        $column_o = $card->column_o;
        $requested_number = $request->number;

        foreach ($numbers_called as $number_called) {
            if ($number_called->random_number == $request->number) {
                $matchOneTime = true;
            }
        }

        if (!$matchOneTime) {
            return "Number not called";
        }

        $column_b = explode(",", $card->column_b);
        $column_i = explode(",", $card->column_i);
        $column_n = explode(",", $card->column_n);
        $column_g = explode(",", $card->column_g);
        $column_o = explode(",", $card->column_o);

        $i = 0;
        foreach($column_b as $number) {
            if ((int)$number == $requested_number){
                $column_b[$i] = (int)$column_b[$i];
                $column_b[$i] = -$column_b[$i];
            }
            $i++;
        }
        $i = 0;
        foreach($column_i as $number) {
            if ((int)$number == $requested_number){
                $column_i[$i] = (int)$column_i[$i];
                $column_i[$i] = -$column_i[$i];
            }
            $i++;
        }
        $i = 0;
        foreach($column_n as $number) {
            if ((int)$number == $requested_number){
                $column_n[$i] = (int)$column_n[$i];
                $column_n[$i] = -$column_n[$i];
            }
            $i++;
        }
        $i = 0;
        foreach($column_g as $number) {
            if ((int)$number == $requested_number){
                $column_g[$i] = (int)$column_g[$i];
                $column_g[$i] = -$column_g[$i];
            }
            $i++;
        }
        $i = 0;
        foreach($column_o as $number) {
            if ((int)$number == $requested_number){
                $column_o[$i] = (int)$column_o[$i];
                $column_o[$i] = -$column_o[$i];
            }
            $i++;
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

        $card->save();

        return $card;

    }

    public function checkWinCases($id)
    {
        $is_winner = false;

        $card = Card::findOrFail($id);
        $column_b = $card->column_b;
        $column_i = $card->column_i;
        $column_n = $card->column_n;
        $column_g = $card->column_g;
        $column_o = $card->column_o;

        $column_b = explode(",", $card->column_b);
        $column_i = explode(",", $card->column_i);
        $column_n = explode(",", $card->column_n);
        $column_g = explode(",", $card->column_g);
        $column_o = explode(",", $card->column_o);

        if ($column_b[0] <= 0 && $column_i[0] <= 0 && $column_n[0] <= 0 && $column_g[0] <= 0 && $column_o[0] <= 0) {
            $is_winner = true;
        } elseif ($column_b[1] <= 0 && $column_i[1] <= 0 && $column_n[1] <= 0 && $column_g[1] <= 0 && $column_o[1] <= 0) {
            $is_winner = true;
        } elseif ($column_b[2] <= 0 && $column_i[2] <= 0 && $column_n[2] <= 0 && $column_g[2] <= 0 && $column_o[2] <= 0) {
            $is_winner = true;
        } elseif ($column_b[3] <= 0 && $column_i[3] <= 0 && $column_g[3] <= 0 && $column_g[3] <= 0 && $column_o[3] <= 0) {
            $is_winner = true;
        } elseif ($column_b[4] <= 0 && $column_i[4] <= 0 && $column_n[4] <= 0 && $column_g[4] <= 0 && $column_o[4] <= 0) {
            $is_winner = true;
        } elseif ($column_b[0] <= 0 && $column_b[1] <= 0 && $column_b[2] <= 0 && $column_b[3] <= 0 && $column_b[4] <= 0) {
            $is_winner = true;
        } elseif ($column_i[0] <= 0 && $column_i[1] <= 0 && $column_i[2] <= 0 && $column_i[3] <= 0 && $column_i[4] <= 0) {
            $is_winner = true;
        } elseif ($column_n[0] <= 0 && $column_n[1] <= 0 && $column_n[2] <= 0 && $column_n[3] <= 0 && $column_n[4] <= 0) {
            $is_winner = true;
        } elseif ($column_g[0] <= 0 && $column_g[1] <= 0 && $column_g[2] <= 0 && $column_g[3] <= 0 && $column_g[4] <= 0) {
            $is_winner = true;
        } elseif ($column_o[0] <= 0 && $column_o[1] <= 0 && $column_o[2] <= 0 && $column_g[3] <= 0 && $column_o[4] <= 0) {
            $is_winner = true;
        }

        if ($is_winner) {
            return "You win!";
        } else {
            return "This card is not winner";
        }
    }

    public function resetAllCards()
    {
        $cards = Card::all();

        foreach($cards as $card){
            $column_b = explode(",", $card->column_b);
            $column_i = explode(",", $card->column_i);
            $column_n = explode(",", $card->column_n);
            $column_g = explode(",", $card->column_g);
            $column_o = explode(",", $card->column_o);

            $i = 0;
            foreach($column_b as $number) {
                if ((int)$number < 0) {
                    $column_b[$i] = (int)$column_b[$i];
                    $column_b[$i] = abs($column_b[$i]);
                }
                $i++;
            }
            $i = 0;
            foreach($column_i as $number) {
                if ((int)$number < 0) {
                    $column_i[$i] = (int)$column_i[$i];
                    $column_i[$i] = abs($column_i[$i]);
                }
                $i++;
            }
            $i = 0;
            foreach($column_n as $number) {
                if ((int)$number < 0) {
                    $column_n[$i] = (int)$column_n[$i];
                    $column_n[$i] = abs($column_n[$i]);
                }
                $i++;
            }
            $i = 0;
            foreach($column_g as $number) {
                if ((int)$number < 0) {
                    $column_g[$i] = (int)$column_g[$i];
                    $column_g[$i] = abs($column_g[$i]);
                }
                $i++;
            }
            $i = 0;
            foreach($column_o as $number) {
                if ((int)$number < 0) {
                    $column_o[$i] = (int)$column_o[$i];
                    $column_o[$i] = abs($column_o[$i]);
                }
                $i++;
            }
            $column_b = implode(",", $column_b);
            $column_i = implode(",", $column_i);
            $column_n = implode(",", $column_n);
            $column_g = implode(",", $column_g);
            $column_o = implode(",", $column_o);

            $card = Card::find($card->id);


            $card->column_b = $column_b;
            $card->column_i = $column_i;
            $card->column_n = $column_n;
            $card->column_g = $column_g;
            $card->column_o = $column_o;
            
            $card->save();
        }
        
        return $cards;
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
            do {
                $column_b[$i] = rand(1, 15);
            } while (in_array($column_b[$i], $previous_numbers));
            
            $previous_numbers[$i] = $column_b[$i];
        }

        $previous_numbers = [];
        for ($i = 0; $i < 5; $i++) {
            do {
                $column_i[$i] = rand(16, 30);
            } while (in_array($column_i[$i], $previous_numbers));
            
            $previous_numbers[$i] = $column_i[$i];
        }

        $previous_numbers = [];
        for ($i = 0; $i < 5; $i++) {
            do {
                $column_n[$i] = rand(31, 45);
            } while (in_array($column_n[$i], $previous_numbers));
            
            if ($i === 2) {
                $column_n[$i] = 0;
            }
            $previous_numbers[$i] = $column_n[$i];
        }

        $previous_numbers = [];
        for ($i = 0; $i < 5; $i++) {
            do {
                $column_g[$i] = rand(46, 60);
            } while (in_array($column_g[$i], $previous_numbers));
            $previous_numbers[$i] = $column_g[$i];
        }

        $previous_numbers = [];
        for ($i = 0; $i < 5; $i++) {
            do {
                $column_o[$i] = rand(61, 75);
            } while (in_array($column_o[$i], $previous_numbers));
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
