<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{



    /**
     * Login with email & password
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' =>  ['required'],
            'password'  =>  ['required']
        ]);

        if(Auth::attempt($request->only(['email', 'password']))){
            $user = Auth::user();
            $token = $user->createToken('admin')->accessToken;

            return ['token'=>$token];
        }

        return response([
            'error'     =>  'Invalid credentials.'
        ], Response::HTTP_UNAUTHORIZED);
    }




    /**
     * Register user
     *
     * @param Request $request
     * @return void
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->except('password') + ['role_id'=>3, 'password'=>bcrypt(request('password'))]);

        return response($user, Response::HTTP_CREATED);
    }
}
