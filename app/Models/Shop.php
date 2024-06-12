<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'area',
        'category',
        'overview',
        'image_name',
        'path',
    ];

    public function scopeNameSearch($query,$name){
        if(!empty($name)){
            $query->where('name','like','%'.$name.'%');
        }
    }

    public function scopeAreaSearch($query,$area){
        if(!empty($area)){
            $query->where('area',$area);
        }
    }

    public function scopeCategorySearch($query,$category){
        if(!empty($category)){
            $query->where('category',$category);
        }
    }

    public function reserves(){
        return $this->hasMany(Reserve::class);
    }

    public function favorites(){
        return $this->hasMany(Favorite::class);
    }

    public function representatives(){
        return $this->hasMany(Representative::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function kutikomis(){
        return $this->hasMany(Kutikomi::class);
    }

}
