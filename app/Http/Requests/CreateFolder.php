<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFolder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {   // デフォルトはfalse、今回はtrueに変更したのでリクエストを受け付ける設定になっている
        return true;
    }

    public function attributes()
    {
        return [
            'title' => 'フォルダ名',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:20',
        ];
    }
}
