<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostGetByHashRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolPostGetByHash
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge(['hash' => $this->route('hash')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'hash' => 'required|exists:posts,hashed_link|min:32|max:32'
        ];
    }
}
