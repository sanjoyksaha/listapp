<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Illuminate\Validation\ValidationException;
use PhpParser\Node\Stmt\ElseIf_;

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

    protected function credentials(Request $request)
    {
        //return $request->only($this->username(), 'password');
        // $user = User::where('email', $request->{$this->username()})->first();
        // if($user->status == 0) {
        //     return ['email' => 'inactive', 'password' => 'You are not active'];
        // } else {
            return ['email' => $request->{$this->username()}, 'password' => $request->password, 'status' => '1'];
        // }
        
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        // throw ValidationException::withMessages([
        //     $this->username() => [trans('auth.failed')],
        // ]);

        // $fields = $this->credentials($request);
        // //dd($fields);
        // if($fields['email'] = 'inactive' )
        // {
        //     $errors = $fields['password'];
        // } else {
        //     throw ValidationException::withMessages([
        //         $this->username() => [trans('auth.failed')],
        //     ]);
        // }

        $errors = [$this->username() => trans('auth.failed')];

        // Load user from database
        $user = \App\User::where($this->username(), $request->{$this->username()})->first();

        // Check if user was successfully loaded, that the password matches
        // and active is not 1. If so, override the default error message.
        if ($user && \Hash::check($request->password, $user->password) && $user->active != 1) {
            $errors = [$this->username() => 'Your account is not active.'];
        }

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }
}
