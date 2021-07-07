<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        $id = $this->route('user');
        return [
            'name' => 'min:4|max:20|required',
            'email' => 'email|required|unique:users,email,' . $id,
            'phone' => ['required', new PhoneNumber, 'unique:users,phone,' . $id],
            'password' => 'min:6|max:20|nullable',

        ];
    }
}
