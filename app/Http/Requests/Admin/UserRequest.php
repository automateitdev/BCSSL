<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        // dd($this->user);
        return [
            'name' => 'required|string',
            'gender' => 'nullable|string',
            'mobile' => 'nullable|string',
            'nid' => 'nullable',
            'image' => 'nullable',
            'status' => 'required',
            // 'email' => 'required|unique:users|email',
            'email' => ['required','email',Rule::unique('users')->ignore($this->user)],
            'password' => request()->isMethod('PUT') ? 'nullable' : 'required|min:6',
            'roles' => 'required'
        ];
    }
}
