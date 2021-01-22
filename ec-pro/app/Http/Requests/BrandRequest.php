<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as ValidationRule;

class BrandRequest extends FormRequest
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
            'brand_name' => 'required|min:4',
            'image' => 'mimes:jpg,jpeg,png',
            'brand_name' => ValidationRule::unique('brand_translations')
                            ->ignore($this->id, 'brand_id')
                            ->where(function ($query) {
                                return $query->where('locale', app()->getLocale());
                            }),
        ];
    }
}
