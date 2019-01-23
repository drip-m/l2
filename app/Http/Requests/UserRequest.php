<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

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
        return [
            'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,' . Auth::id(),
            'email' => 'required|email',
            'introduction' => 'max:80',
            'avatar' => 'mimes:jpg,bmp,jpeg,gif|dimensions:min_width=200, min_height=200'
        ];
    }

    public function messages()
    {
        return [
            'avatar.mimes' => '图片格式必须是jpg,bmp,jpeg,gif格式',
            'avatar.dimensions' => '图片清晰度不够，宽和高必须是200PX以上',
            'name.required' => '用户名必须填写！',
            'name.between' => '用户名必须介于3 - 25个字符之间',
            'name.regex' => '用户名只支持字母数字下划线',
            'name.unique' => '用户名已被占用，请重新填写'
        ];
    }
}
