<?php

namespace App\Http\Controllers;

use Event;
use App\Events\IncidentFound;
use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function test()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://dev.virtualearth.net/REST/v1/Traffic/Incidents/37.04,-115.46,42.35,-108.17?key=AunSppuTRCtKNtZ6Tw-ojcFtxuOCs7rjQDTP1X38e0RoIK-nUDzTd24bcAZUymg-"); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = json_decode(curl_exec($ch));
        curl_close($ch); 
        $incidents = $result->resourceSets[0]->resources;
        Event::fire(new IncidentFound($incidents));
    }
}
