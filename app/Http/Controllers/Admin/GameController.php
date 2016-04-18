<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GameController extends Controller
{
    public function index(){
    	$games = \DB::table('games')->get();
    	return view('admin.game.index', ['games' => $games]);
    }
}