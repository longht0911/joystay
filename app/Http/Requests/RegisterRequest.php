<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            //
            'name'  => 'required|max:191',
            'email' => 'required|email|max:191|unique:users,email,' . $this->id,
            'phone' => 'required',
            'address' => 'required',
            'password' => [
                'required', 'string', 'min:8', 'max:20',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            ],

            'r_password' => 'required|same:password'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập vào họ tên',
            'email.required' => 'Vui lòng nhập vào email đăng nhập',
            'email.unique' => 'Email đăng nhập không thể trùng lặp',
            'email.max' => 'Email vượt quá số ký tự cho phép',
            'password.required' => 'Vui lòng nhập mật khẩu đăng nhập',
            'r_password.required' => 'Vui lòng nhập mật khẩu đăng nhập',
            'r_password.same' => 'Mật khẩu không trùng khớp',
            'phone.required' => 'Vui lòng nhập số điện thoại liên hệ',
            'address.required' => 'Vui lòng nhập địa chỉ',

        ];
    }
}
