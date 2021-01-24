<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as ValidationRule;

class PostRequest extends FormRequest
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
            'category_id' => 'nullable|numeric',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|min:0|max:1024',
            'is_active' => 'nullable|numeric',

            'post_title' => ValidationRule::unique('post_translations')
                    ->ignore($this->id, 'post_id')
                    ->where(function ($query) {
                        return $query->where('locale', app()->getLocale());
                    }),
        ];
    }
}
