<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
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
    
    public function handleProviderCallback(Request $request)
    {
        $userSenhaUnica = Socialite::driver('senhaunica')->user();
        
        # busca o usuário local
        $user = User::where('username_senhaunica',$userSenhaUnica->codpes)->first();
        
        if (is_null($user)) {
            $user = new User;
        }

        // precisamos saber se o usuário é autorizado
        $unidades = explode(',', trim(config('copaco.senha_unica_unidades')));

        if ($unidades) {
            $login = false;
            foreach ($userSenhaUnica->vinculo as $vinculo) {
                if (in_array($vinculo['siglaUnidade'], $unidades)) {
                    if ($vinculo['tipoVinculo'] != 'ALUNOGR') {
                        $login = true;
                    }
                }
            }
        }

        if (!$login) {
            $request->session()->flash('alert-danger', 'Usuário sem acesso ao sistema.');
            return redirect('/');
        }

        // bind do dados retornados
        $user->id = $userSenhaUnica->codpes;
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
