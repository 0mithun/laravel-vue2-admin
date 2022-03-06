<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

 /**
 * @OA\Schema(
 *      title="Store User request",
 *      description="Store User request body data",
 * )
 */

class UserCreateRequest extends FormRequest
{
    /**
     * @OA\Property(
     *  title="first_name"
     * )
     *
     * @var string
     */
    public $first_name;


    /**
     * @OA\Property(
     *  title="last_name"
     * )
     *
     * @var string
     */
    public $last_name;


    /**
     * @OA\Property(
     *  title="email"
     * )
     *
     * @var string
     */
    public $email;


    /**
     * @OA\Property(
     *  title="role_id"
     * )
     *
     * @var integer
     */
    public $role_id;



    /**
     * @OA\Property(
     *  title="password"
     * )
     *
     * @var string
     */
    public $password;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  Gate::abilities('edit', 'users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'        =>  ['required'],
            'last_name'        =>  ['required'],
            'email'        =>  ['required','email','unique:users,email'],
            'password'        =>  ['required','min:8'],
            'role_id'   =>  ['required']
        ];
    }
}
