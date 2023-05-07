<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Interfaces\AuthInterface;

class AuthController extends Controller
{
    protected $auth;
    public function __construct(AuthInterface $auth){
        $this->auth = $auth;
    }
    
    
    /**
     * Show a login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLogin()
    {
        return view('auth.login');
    }
     /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
         $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');
        $result=$this->auth->login($credentials);
        if($result)
        {
            $request->session()->regenerate();
            return redirect()->route('home')
            ->with('success','You have Successfully loggedin');
        }else{
            
            return back()->with('error','Your email or password does not match please try again.');
        } 
       
    }

    /**
     * Show a registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegister()
    {
        return view('auth.signup');
    }
     /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    { 
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        $result=$this->auth->register($request->all()); 
        if($result)
        {
            return redirect()->route('login.show')
            ->with('success','You have successfully registered, please login');

        }else{

            return back()->with('error','Unable to signup please try again');
        }
        
    }

     /**
     * Log out the user .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->auth->logout();  
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.show');
    }    
}
