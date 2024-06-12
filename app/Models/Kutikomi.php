<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kutikomi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['user_id','shop_id','score','kutikomi','path'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function shop(){
        return $this->belongsTo(Shop::class);
    }
}
