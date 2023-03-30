<?php

namespace App\Models\admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPurchase extends Model
{
    use HasFactory;


    public static $rules = [
        'item_name_id' => 'required',
        'item_qty' => 'required',
        'purchase_rate' => 'required',
        'sales_rate' => 'required',
        'purchase_date' => 'required',
    ];
    public $table = 'tk_itempurchase';
    protected $fillable = [
        'item_name_id',
        'item_qty',
        'purchase_rate',
        'sales_rate',
        'insertedByUserId',
        'purchase_date',
    ];

    public function item_name()
    {
        return $this->belongsTo(ItemName::class, 'item_name_id');
    }

    public function created_bys()
    {
        return $this->belongsTo(User::class, 'insertedByUserId');
    }

    public function item_sales()
    {
        return $this->belongsTo(ItemSales::class, 'item_sales_id');
    }
}
