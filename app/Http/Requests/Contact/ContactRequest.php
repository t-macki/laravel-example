<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class ContactRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return false;
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
            'name'    => 'required',
            'email'   => 'required|email',
            'subject' => 'required',
            'content' => 'required',
        ];
    }

    /**
     * Set custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }

    /**
     * Set custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name'    => 'お名前',
            'email'   => 'メールアドレス',
            'subject' => '件名',
            'content' => '内容',
        ];
    }

    protected function transform(array $attrs)
    {
        $inputs['name'] = $attrs['name'] ?? '';
        $inputs['email'] = $attrs['email'] ?? '';
        $inputs['subject'] = $attrs['subject'] ?? '';
        $inputs['content'] = $attrs['content'] ?? '';
        return $inputs;
    }
}
