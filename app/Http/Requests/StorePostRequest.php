<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'=>['required','max:10','string'],
            'content'=>['required','max:10','string'],
            'user_id'=> ['required','exists:App\Models\User,id'],
            'status' =>['nullable',Rule::in(['hide', 'display'])]
        ];
    }
}
