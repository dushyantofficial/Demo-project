<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    public $table = 'users';
    public static $rules = [
        'mandali_code' => 'required',
        'email' => 'required',
        'user_name' => 'required',
        'mobile_number' => 'required|min:10:max:10',
        'password' => 'required',
        'gender' => 'required',

    ];

    use HasApiTokens, HasFactory, Notifiable;

    public static $profile = [
        'mandali_code' => 'required',
        'email' => 'required',
        'user_name' => 'required',
        'mobile_number' => 'required|min:10|max:10',
        'gender' => 'required',

    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_name',
        'mandali_code',
        'created_by',
        'email',
        'user_name',
        'customer_code',
        'mandali_name',
        'mandali_address',
        'mobile_number',
        'gst_number',
        'registration_num',
        'role',
        'profile_pic',
        'password',
        'gender',
        'lang',
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

    public function users(){
        return  $this->belongsTo(User::class,'created_by','id');
    }


}
