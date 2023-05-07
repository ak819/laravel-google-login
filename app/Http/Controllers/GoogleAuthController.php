<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class GoogleAuthController extends Controller
{
   
    public function __construct(){
        
    }

     /**
     * Redirecting to google login 
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
       
        return Socialite::driver('google')->redirect();

    }

     /**
     * Callback by google after login 
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
        
            $user = Socialite::driver('google')->user();

         
            $finduser = User::where('email',$user->email)->first();
         
            if($finduser){
                if(!$finduser->google_token)
                {
                    User::updateOrCreate(['email' => $user->email],[
                        'google_token'=> $user->id,
                    ]);
                }
                Auth::login($finduser);
                return redirect()->route('home');
         
            }else{
                $newUser = User::create([
                        'guid'=>(string) Str::uuid(),
                        'name' => $user->name,
                        'email' => $user->email,
                        'google_token'=> $user->id,
                    ]);
         
                Auth::login($newUser);
        
                return redirect()->route('home');
            }
        
        } catch (\Throwable $th) {
            return redirect()->route('login')->with('error','Unable to login, please try again');
        }

    }
}
