<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Post extends Model
{
    use HasFactory;

    use Translatable;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'is_active','image', 'category_id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = ['post_title', 'post_details', 'post_tags'];



    public function scopeActive($query){
        return $query -> where('is_active',1) ;
    }

    public function getActive(){
        return  $this -> is_active  == 0 ? trans('main.is_active')  : trans('main.is_not_active') ;
    }

    public static function files_path() {
        return 'assets/dashboard/images/posts/';
    }

    public function image_delete()
    {
        delete_img($this->image_rel_path());
    }

    public function image_rel_path()
    {
        return $this->files_path() . $this->attributes['image'];
    }

    public function  getImageAttribute($val){
        return ($val && file_exists($this->image_rel_path())) ?  asset($this->image_rel_path()) : false;
    }

    public function  imageSrc(){
        return $this->image_rel_path('image');
    }


}
