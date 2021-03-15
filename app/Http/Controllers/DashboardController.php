<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Place;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $places = Place::where('user_id', Auth::id())->get()->count();
        $data['totalPlaces'] = $places;
        return $data;
    }
}
