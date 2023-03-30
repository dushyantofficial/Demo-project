<?php

namespace App\Models\admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemName extends Model
{
    use HasFactory;

    public static $rules = [
        'item_name' => 'required',
    ];
    public $table = 'tk_itemname';
    protected $fillable = [
        'item_name',
        'insertedByUserId',
    ];

    public function created_bys()
    {
        return $this->belongsTo(User::class, 'insertedByUserId', 'id');
    }
}
