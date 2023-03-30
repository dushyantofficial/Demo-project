<?php

namespace App\Models\admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    public static $rules = [
        'bank_name' => 'required',
        'cust_name' => 'required',
        'cust_code' => 'required',
        'account_number' => 'required',
        'user_id' => 'required',
        'ifsc_code' => 'required',
        'final_amount' => 'required',
    ];
    public static $bank = [
        'bank_name' => 'required',
        'account_number' => 'required',
        'ifsc_code' => 'required',
        'final_amount' => 'required',

    ];
    public $table = 'tk_customername';
    protected $fillable = [
        'bank_name',
        'cust_name',
        'cust_code',
        'account_number',
        'user_id',
        'ifsc_code',
        'final_amount',
        'insertedByUserId',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function created_bys()
    {
        return $this->belongsTo(User::class, 'insertedByUserId', 'id');
    }

    public function customer()
    {
        return $this->hasOne(Payment::class, 'customer_id');
    }
}


