<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    use Translatable;


    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];


    protected $translatedAttributes = ['product_name', 'product_details'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        // 'category_id',
        'brand_id',
        'product_code',
        'product_quantity',
        'product_color',
        'product_size',
        'product_weight',
        'selling_price',
        'discount_price',
        'video_link',
        'main_slider',
        'hot_deal',
        'best_rated',
        'mid_slider',
        'hot_new',
        'buyone_getone',
        'trend',
        'image_one',
        'image_two',
        'image_three',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = ['translations'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'main_slider' => 'boolean',
        'hot_deal' => 'boolean',
        'best_rated' => 'boolean',
        'mid_slider' => 'boolean',
        'hot_new' => 'boolean',
        'buyone_getone' => 'boolean',
        'trend' => 'boolean',
    ];

    public function getActive(){
        return  $this -> is_active  == 0 ? trans('main.is_active')  : trans('main.is_not_active') ;
    }

    public function scopeActive($query){
        return $query -> where('is_active',1) ;
    }

    public function user(){
        return $this -> hasOne(Self::class,'id', 'user_id');
    }

    //Image Path
    public static function files_path() {
        return 'assets/dashboard/images/products/';
    }

    public function image_delete($attr='')
    {
        if(!$attr){
            delete_img($this->image_rel_path('image_one'));
            delete_img($this->image_rel_path('image_two'));
            delete_img($this->image_rel_path('image_three'));
        }else{
            delete_img($this->image_rel_path($attr));
        };
    }

    public function image_rel_path($attr)
    {
        return $this->files_path() . $this->attributes[$attr];
    }

    public function  getImage_oneAttribute($val){
        return ($val && file_exists($this->image_rel_path('image_one'))) ?  asset($this->image_rel_path('image_one')) : false;
    }

    public function  getImage_twoAttribute($val){
        return ($val && file_exists($this->image_rel_path('image_two'))) ?  asset($this->image_rel_path('image_two')) : false;
    }

    public function  getImage_threeAttribute($val){
        return ($val && file_exists($this->image_rel_path('image_three'))) ?  asset($this->image_rel_path('image_three')) : false;
    }

    public function  image_oneSrc(){
        return $this->image_rel_path('image_one');
    }

    public function  image_twoSrc(){
        return $this->image_rel_path('image_two');
    }

    public function  image_threeSrc(){
        return $this->image_rel_path('image_three');
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categoryable');
    }
}
