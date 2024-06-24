<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\UserModel\Conversation;
use App\Models\AdminModel\Payment;
use App\Models\UserModel\Rate;
use App\Models\AdminModel\Activity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullname',
        'email',
        'password',
        'image',
        'username',
        'role',
        'phone',
        'image',
        'image_folder',
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
    ];

    public function conversation1() {
        return $this->hasMany(Conversation::class, 'user_id_1');
    }

    public function conversation2() {
        return $this->hasMany(Conversation::class, 'user_id_2');
    }

    public function payment() {
        return $this->hasMany(Payment::class);
    }

    public function campaign() {
        $class = new \App\Models\UserModel\campaign;
        return $this->hasMany($class::class);
    }

    public function activity() {
        
        return $this->hasMany(Activity::class);
    }


    public function ratings()
    {
        return $this->hasMany(Rate::class, 'user_id');
    }

    public function creatorID()
    {
        return $this->hasMany(Rate::class, 'creator_id');
    }
}
