<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

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

    public function scopeNameSearch($query,$name){
        if(!empty($name)){
            $query->where('name','like','%'.$name.'%');
        }
    }

    public function scopeEmailSearch($query,$email){
        if(!empty($email)){
            $query->where('email',$email);
        }
    }

    public function scopeRoleSearch($query,$role){
        if(!empty($role)){
            $query->where('role',$role);
        }
    }
}
