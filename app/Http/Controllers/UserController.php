<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateUserInfoRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
/**
 * @OA\Get(path="/users",
 *  security={{"bearerAuth": {}}},
 *  tags={"Users"},
 *  @OA\Response(response="200",
 *   description="User Collection"
 *  ),
 * @OA\Parameter(
 *      name="page",
 *      description="Pagination Page",
 *      in="query",
 *      @OA\Schema(
 *          type="integer"
 *      )
 *  ),
 * @OA\Parameter(
 *      name="per_page",
 *      description="Item Per Page",
 *      in="query",
 *      @OA\Schema(
 *          type="integer"
 *      )
 *  )
 * )
 */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('view', 'users');
        $users = User::with(['role'])->paginate();

        return UserResource::collection($users);
    }


/**
 * @OA\Post(
 *  path="/users",
 *  security={{"bearerAuth": {}}},
 * tags={"Users"},
 *  @OA\Response(response="200",
 *   description="Create New User"
 *  ),
 * @OA\RequestBody(
 *      required=true,
 *      @OA\JsonContent(ref="#/components/schemas/UserCreateRequest")
 *    )
 * )
 */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $user = User::create($request->except('password') + ['password'=>bcrypt(request('password'))]);

        return response(new UserResource($user), Response::HTTP_CREATED);
    }


/**
 * @OA\Get(path="/users/{id}",
 *  security={{"bearerAuth": {}}},
 * tags={"Users"},
 *  @OA\Response(response="201",
 *   description="User"
 *  ),
 * @OA\Parameter(
 *      name="id",
 *      description="User ID",
 *      in="path",
 *      required=true,
 *      @OA\Schema(
 *          type="integer"
 *      )
 *  )
 * )
 */

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        Gate::authorize('view', 'users');
        return new UserResource($user);
    }




    /**
 * @OA\Put(
 *  path="/users/{id}",
 *  security={{"bearerAuth": {}}},
 * tags={"Users"},
 *  @OA\Response(response="202",
 *   description="Update user"
 *  ),
 *
 *  @OA\Parameter(
 *      name="id",
 *      description="User Id",
 *      in="path",
 *      required=true,
 *      @OA\Schema(
 *          type="integer"
 *      )
 *  ),
 *
 * @OA\RequestBody(
 *      required=true,
 *      @OA\JsonContent(ref="#/components/schemas/UserUpdateRequest")
 *    )
 * )
 */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        Gate::authorize('edit', 'users');
        $user->update($request->except('password'));

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }






/**
 * @OA\Delete(
 *  path="/users/{id}",
 *  security={{"bearerAuth": {}}},
 * tags={"Users"},
 *  @OA\Response(response="204",
 *   description="Delete user"
 *  ),
 *  @OA\Parameter(
 *      name="id",
 *      description="User Id",
 *      in="path",
 *      required=true,
 *      @OA\Schema(
 *          type="integer"
 *      )
 *  ),
 * )
 */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Gate::authorize('edit', 'users');
        $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }




/**
 * @OA\Get(path="/user",
 *  security={{"bearerAuth": {}}},
 *  tags={"Profile"},
 *  @OA\Response(response="200",
 *   description="Get current authenticated user information"
 *  ),
 * )
 */

    /**
     * Get currently authenticated user information
     *
     * @return void
     */
    public function user()
    {
        return (new UserResource(auth()->user()))->additional([
            'permissions'   =>  auth()->user()->permissions,
        ]);
    }



/**
 * @OA\Put(
 *  path="/info",
 *  security={{"bearerAuth": {}}},
 * tags={"Profile"},
 *  @OA\Response(response="202",
 *   description="Update authenticated user information"
 *  ),
 *
 *
 * @OA\RequestBody(
 *      required=true,
 *      @OA\JsonContent(ref="#/components/schemas/UpdateUserInfoRequest")
 *    )
 * )
 */

    /**
     * Update currently authenticated user information
     *
     * @return void
     */
    public function updateInfo(UpdateUserInfoRequest $request)
    {
        $user = auth()->user();

        $user->update($request->except('password'));

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }






/**
 * @OA\Put(
 *  path="/password",
 *  security={{"bearerAuth": {}}},
 * tags={"Profile"},
 *  @OA\Response(response="202",
 *   description="Update authenticated user password"
 *  ),
 *
 *
 * @OA\RequestBody(
 *      required=true,
 *      @OA\JsonContent(ref="#/components/schemas/UpdatePasswordRequest")
 *    )
 * )
 */


    /**
     * Update currently authenticated user password
     *
     * @return void
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = auth()->user();

        $user->update(['password' => bcrypt($request->password) ]);

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }
}
