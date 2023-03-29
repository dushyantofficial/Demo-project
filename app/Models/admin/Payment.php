<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public $table = 'tk_payment';
    protected $fillable = [
        'customer_id',
        'created_by',
        'payment_from_date',
        'payment_to_date',
    ];

}
