<?php

namespace App\Models\admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public $table = 'tk_payment';
    protected $fillable = [
        'CustId',
        'InsertedByUserId',
        'PaymentFromDate',
        'PaymentToDate',
    ];

    public function created_name()
    {
        return $this->belongsTo(User::class, 'insertedByUserId');
    }

}
