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
        'mobile' => 'required|min:10:max:10',
        'password' => 'required',
        'gender' => 'required',

    ];

    use HasApiTokens, HasFactory, Notifiable;

    public static $profile = [
        'mandali_code' => 'required',
        'email' => 'required',
        'user_name' => 'required',
        'mobile' => 'required|min:10|max:10',
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
        'InsertedByUserId',
        'email',
        'user_name',
        'cust_code',
        'mandali_name',
        'mandali_address',
        'mobile',
        'gst_num',
        'reg_num',
        'role',
        'profile',
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
        return  $this->belongsTo(User::class,'insertedByUserId','id');
    }


}
