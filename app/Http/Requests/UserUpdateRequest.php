<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


 /**
 * @OA\Schema(
 *      title="Update User request",
 *      description="Update User request body data",
 * )
 */
class UserUpdateRequest extends FormRequest
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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'        =>  ['email','unique:users,email,'.$this->user->id],
            'password'        =>  ['min:8'],
            'role_id'   =>  ['numeric']
        ];
    }
}
