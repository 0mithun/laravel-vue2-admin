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
     * @OA\Post(
     ** path="/register",
     *   tags={"Register"},
     *   summary="Register",
     *   operationId="Register",
     *
     *   @OA\Parameter(
     *      name="first_name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="last_name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password_confirmation",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/


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
