<?php
namespace App\Repositories;
use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Redis;
use App\Models\User;

class UserRepository implements UserInterface
{    
    /**
     * logged in user details and current weather location by lat and long
     * using api
     *
     * @return \Illuminate\Http\Response
     */
     public function getLoggedInUserAndWeatherInfo($user_ip)
     { 
        $user=Auth::user();
        $locationinfo = Location::get($user_ip);
        $weatherinfo=[];
        $main=[];
        if($locationinfo)
        {
         $cachedweather = Redis::get('w_'.$locationinfo->ip); //getting cache from redis
         if($cachedweather)
         { 
         
            $main=json_decode($cachedweather,TRUE); // converting json to array
          
         }else{
         try {
               $url = "https://api.openweathermap.org/data/2.5/weather?lat=".$locationinfo->latitude."&lon=".$locationinfo->longitude."&appid=".env('OPEN_WEATHER_API');
               $curl = curl_init($url);
               curl_setopt($curl, CURLOPT_URL, $url);
               curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      
               $headers = array(
               "Accept: application/json",
               );
               curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
               //for debug only!
               curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
               curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      
               $resp = curl_exec($curl);
               curl_close($curl);

               $weatherinfo=json_decode($resp);
               if(isset($weatherinfo->main))
               {
               $main=['temp'=>$weatherinfo->main?->temp,
                     'pressure'=>$weatherinfo->main?->pressure,
                     'humidity'=>$weatherinfo->main?->humidity,
                     'temp_min'=>$weatherinfo->main?->temp_min,
                     'temp_max'=>$weatherinfo->main?->temp_max,
               ];
            
               Redis::set('w_' .$locationinfo->ip,json_encode($main)); // set data to redis as json
               }
            } catch (\Throwable $th) {
               throw $th;
            }
          }
        }
         $userinfo=['name'=>$user->name,
                    'email'=>$user->email,
                    'created_at'=>$user->created_at->format('Y-m-d H:i:s'),
                    'updated_at'=>$user->updated_at->format('Y-m-d H:i:s'),        
          ];
          
        
          return ['user'=>$userinfo,'main'=>$main];
 
     }
}



?>