<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule as ValidationRule;

// use Validator;

class ProductRequest extends FormRequest
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
            'brand_id' => 'nullable|numeric',
            'product_code' => 'nullable|min:0|max:50',
            'product_quantity' => 'nullable|numeric|min:0|max:99999',
            'product_color' => 'nullable|min:0|max:191',
            'product_size' => 'nullable|min:0|max:191',
            'product_weight' => 'nullable|min:0|max:50',
            'selling_price' => 'required|numeric|min:0|max:999999',
            'discount_price' => 'nullable|numeric|min:0|min:0|max:100',
            'video_link' => 'nullable|min:0|max:191',
            'main_slider' => 'nullable|numeric',
            'hot_deal' => 'nullable|numeric',
            'best_rated' => 'nullable|numeric',
            'mid_slider' => 'nullable|numeric',
            'hot_new' => 'nullable|numeric',
            'buyone_getone' => 'nullable|numeric',
            'trend' => 'nullable|numeric',
            'image_one' => 'image|mimes:jpg,png,jpeg,gif,svg|min:0|max:1024',
            'image_two' => 'image|mimes:jpg,png,jpeg,gif,svg|min:0|max:1024',
            'image_three' => 'image|mimes:jpg,png,jpeg,gif,svg|min:0|max:1024',
            'is_active' => 'nullable|numeric',

            'product_name' => ValidationRule::unique('product_translations')
                    ->ignore($this->id, 'product_id')
                    ->where(function ($query) {
                        return $query->where('locale', app()->getLocale());
                    }),

        ];
    }
}
