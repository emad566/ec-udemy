<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
             'category_name' => 'required|max:191',
             'description' => 'nullable|max:1000',
             'slug' => 'required|max:191|unique:categories,slug,'.$this -> id.',id,deleted_at,NULL',
        ];
    }
}
