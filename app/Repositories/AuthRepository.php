<?php
namespace App\Repositories;
use App\Interfaces\AuthInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class AuthRepository implements AuthInterface
{
     /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $data
     * @return \Illuminate\Http\Response
     */
   public function login(array $data)
   {
      if(Auth::attempt($data))
      { 
        return true;
      }{
        return false;
      }

   }
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $data
     * @return \Illuminate\Http\Response
     */
   public function register(array $data)
   {
      try {
         User::create([
            'guid'=>(string) Str::uuid(),
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
        return true;
      } catch (\Throwable $th) {
          return false;
      }
      
     
    
   }
    /**
   * Log out the user .
   *
   * @return \Illuminate\Http\Response
   */
   public function logout()
   {

    Auth::logout();
     return true;
   }



}



?>