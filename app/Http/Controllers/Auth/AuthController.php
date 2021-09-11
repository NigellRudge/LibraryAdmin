<?php


namespace App\Http\Controllers\Auth;
use \App\Http\Controllers\Controller;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{
    private $app;
    public function __construct(Application $app)
    {
        $this->app = $app;
    }


    public function login(){
        if(auth()->user()){
            return redirect(route('dashboard'));
        }
        return view('auth.login');
    }

    public function authenticate(Request $request,$backUrl=null){
        $credentials = $request->validate([
            'email' =>['required','email'],
            'password' => ['required']
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect(route('dashboard'));

        }
        return back()->withErrors([
           'error' => trans('common.auth_error_label')
        ]);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function changeLanguage(Request $request){
        $langId = $request['language_id'];
        $user = Auth::user();
        $user->language_id = $langId;
        $user->save();
        return redirect()->back();
    }

}
