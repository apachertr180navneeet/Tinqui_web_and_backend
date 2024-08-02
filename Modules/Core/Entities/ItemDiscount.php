<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemDiscount extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $table = "item_discounts";

    protected static function newFactory()
    {
        return \Modules\Core\Database\factories\ItemDiscountFactory::new();
    }
}
