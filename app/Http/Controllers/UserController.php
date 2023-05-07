<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Interfaces\UserInterface;
use Stevebauman\Location\Facades\Location;

class UserController extends Controller
{
    protected $user;
    public function __construct(UserInterface $user){
        $this->user = $user;
    }


    public function index(Request $request)
    {
        //$ip = $request->ip();
        $ip="103.182.196.216";
        $userinfo=$this->user->getLoggedInUserAndWeatherInfo($ip);
         
         return view('welcome',compact('userinfo'));
    
        //
    }
}
