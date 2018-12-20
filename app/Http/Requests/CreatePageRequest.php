<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePageRequest extends FormRequest
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
            'type' => 'required|string',
            'title' => 'required|string',
            'slug' => 'required|alpha_dash',
            'parent_id' => 'nullable',
            'order' => 'nullable|integer',
            'settings' => 'required|array'
        ];
    }
}
