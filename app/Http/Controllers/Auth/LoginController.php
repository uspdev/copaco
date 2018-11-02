<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use Socialite;
use App\Http\Controllers\Controller;
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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function redirectToProvider()
    {
        if (\App::environment('local') && config('copaco.senha_unica_override')) {
            # busca o usuário dev
            $dev_user = config('copaco.developer_id');

            # Se não encontra, retorna 404
            $user = User::findOrFail($dev_user);

            # faz login
            Auth::login($user, true);

            return redirect('/');
        }

        return Socialite::driver('senhaunica')->redirect();
    }
    
    public function handleProviderCallback()
    {
        $userSenhaUnica = Socialite::driver('senhaunica')->user();
        
        # busca o usuário local
        $user = User::where('username_senhaunica',$userSenhaUnica->codpes)->first();
        
        if (is_null($user)) {
            $user = new User;
        }
        
        // bind do dados retornados
        $user->username_senhaunica = $userSenhaUnica->codpes;
        $user->email = $userSenhaUnica->email;
        $user->name = $userSenhaUnica->nompes;
        $user->save();
 
        Auth::login($user, true);
        return redirect('/');
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
