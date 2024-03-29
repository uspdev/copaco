<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Models\User;
use Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    public function username()
    {
        return 'username';
    }
    
    public function redirectToProvider()
    {
       return Socialite::driver('senhaunica')->redirect();
    }
    
    public function handleProviderCallback(Request $request)
    {
        $userSenhaUnica = Socialite::driver('senhaunica')->user();

        # busca o usuário local
        $user = User::where('username',$userSenhaUnica->codpes)->first();

        if (is_null($user)) {
            $user = new User;
        }

        // precisamos saber se o usuário é autorizado
        $unidades = explode(',', trim(config('copaco.senha_unica_unidades')));

        if ($unidades) {
            if(config('copaco.allow_login_all')){
                $login = true;
            } else {
                $login = false;
                foreach ($userSenhaUnica->vinculo as $vinculo) {
                    if (in_array($vinculo['siglaUnidade'], $unidades)) {
                        if ($vinculo['tipoVinculo'] != 'ALUNOGR') {
                            $login = true;
                        }
                    }
                }
            }

        }

        if (!$login) {
            $request->session()->flash('alert-danger', 'Usuário sem acesso ao sistema.');
            return redirect('/');
        }

        // bind do dados retornados
        $user->username = $userSenhaUnica->codpes;
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
