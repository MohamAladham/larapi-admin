<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = request()->route()->parameter( 'user' );

        $rules = [
            'name'          => [ 'required', 'string', 'max:100' ],
            'email'         => [ 'required', 'email', 'max:100', Rule::unique( 'users' )->ignore( $id ) ],
            'avatar'        => [ 'nullable', 'image' ],
            'avatarPreview' => [ 'string', 'nullable' ],
            'password'      => [ 'required', 'confirmed', Password::min( 8 ) ],
        ];

        if ( $id )
        {
            $rules['password'] = [ 'nullable', 'confirmed', Password::min( 8 ) ];
        }

        return $rules;
    }
}
