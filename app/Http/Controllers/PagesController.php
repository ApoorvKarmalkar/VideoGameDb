<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function showHomePage() {
        return view('index');
    }
    public function getGame() {
        $ch = curl_init();
        $game = str_replace(' ','-',$_GET['searchTitle']);
        curl_setopt_array(
            $ch, array(
            CURLOPT_URL => "https://api.rawg.io/api/games?search=$game",
            CURLOPT_RETURNTRANSFER => true
        ));
        $output = json_decode(curl_exec($ch));
        curl_close($ch);
        return view('index',['output' => $output]);
    }
}
