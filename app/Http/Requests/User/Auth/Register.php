<?php

namespace App\Http\Requests\User\Auth;

use App\Http\Requests\BaseFormRequest;

class Register extends BaseFormRequest
{
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
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|alpha_num|min:8|max:20|confirmed',
        ];
    }

    protected function transform(array $attrs)
    {
        $inputs['email'] = $attrs['email'] ?? '';
        $inputs['password'] = $attrs['password'] ?? '';
        return $inputs;
    }
}
