<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class AdminUserUpdateRequest extends FormRequest
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
        $id = $this->route('admin_user');
        return [
            'name' => 'min:4|max:20|required',
            'email' => 'email|required|unique:admin_users,email,' . $id,
            'password' => 'min:6|max:20|nullable',
            'phone' => ['required', new PhoneNumber, 'unique:admin_users,phone,' . $id],
        ];
    }
}
