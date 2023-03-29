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
        'customer_name' => 'required',
        'customer_code' => 'required',
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
        'customer_name',
        'customer_code',
        'account_number',
        'user_id',
        'ifsc_code',
        'final_amount',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function created_bys()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function customer()
    {
        return $this->hasOne(Payment::class, 'customer_id');
    }
}


