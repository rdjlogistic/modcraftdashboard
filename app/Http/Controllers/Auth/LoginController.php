<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index(Request $request){
        $info = [];
        return view('auth/login', $info);
    }

    public function verify(Request $request){
        $credential = [
            'email' => $request->email,
            'password' => $request->password,
        ];

       $remember_me  = ( !empty( $request->remember ) )? TRUE : FALSE;
       

      

        if(Auth::attempt($credential)){
            $user = User::where(["email" => $credential['email']])->first();
            
            Auth::login($user, $remember_me);
            // Cookie::queue("member_login", $request->email, time()+ (10 * 365 * 24 * 60 * 60));
            
            // $cookie = \Cookie::make('member_login', $request->email, time()+ (10 * 365 * 24 * 60 * 60));
            // $member_login = cookie('member_login', $request->email,  time()+ (10 * 365 * 24 * 60 * 60));
            // Cookie::queue('member_login', $request->emai, time()+ (10 * 365 * 24 * 60 * 60));
            
            // $cookieJar->queue(cookie('member_login', $request->emai, 45000));

            Session::put('loginemail',$request->email);
            Session::put('loginpassword',$request->password);
            if( !empty( $request->remember ) ) {
                Session::put('loginremember',$remember_me);
            } else {
                Session::put('loginremember',$remember_me);
            }
            
            
            return redirect(route('home'));
        }
    }

    public function logout(Request $request){
        // Auth::logout();
        return view('auth/login');
    }
}
