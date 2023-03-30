<?php

namespace App\Models\admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSales extends Model
{
    use HasFactory;

    public static $rules = [
        'payment_from_date' => 'required',
        'payment_to_date' => 'required',
        'ItemQty' => 'required',
        'CustPhoto' => 'required',
        'ItemId' => 'required',
        'CustId' => 'required',
        'entry_date' => 'required',
        'deduct_from_date' => 'required',
        'deduct_to_date' => 'required',
        'payment' => 'required',
        'deduct_payment' => 'required',
        'total' => 'required',
        'total_quantity' => 'required',
    ];
    public $table = 'tk_itemsales';
    protected $fillable = [
        'payment_from_date',
        'payment_to_date',
        'from_morning_evening',
        'to_morning_evening',
        'deduct_from_date',
        'deduct_to_date',
        'entry_date',
        'deduct_morning_evening',
        'payment',
        'deduct_payment',
        'total',
        'total_quantity',
        'CustId',
        'ItemId',
        'ItemQty',
        'CustPhoto',
        'InsertedByUserId',
    ];

    public function customers()
    {
        return $this->belongsTo(Customers::class, 'CustId');
    }

    public function item_names()
    {
        return $this->belongsTo(ItemPurchase::class, 'ItemId');
    }

    public function created_name()
    {
        return $this->belongsTo(User::class, 'insertedByUserId');
    }

}
