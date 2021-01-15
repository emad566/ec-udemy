<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Brand extends Model
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
    protected $fillable = ['is_active','image'];

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
    public $translatedAttributes = ['brand_name'];



    public function scopeActive($query){
        return $query -> where('is_active',1) ;
    }

    public function getActive(){
        return  $this -> is_active  == 0 ?  'غير مفعل'   : 'مفعل' ;
    }

    public function  getImageAttribute($path=true){
        if($this->image)
            return ($path) ? asset('assets/images/brands/' . $this->image) : $this->image;
        return false;
    }
}
