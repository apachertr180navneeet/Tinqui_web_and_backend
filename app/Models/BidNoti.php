<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidNoti extends Model
{
    use HasFactory;

     protected $fillable = ['id', 'bid_id', 'type', 'bid_noti_message', 'bid_flag', 'is_read', 'added_date',  'updated_date'];

    protected $table = "bid_notis";

    const CREATED_AT = 'added_date';
    const UPDATED_AT = 'updated_date';

    const tableName = "bid_notis";
    const id = "id";
    const bidId = "bid_id";
    const type = "type";
    const bidNotiMessage = "bid_noti_message";
    const bidFlag = "bid_flag";
    const isRead = "is_read";
    const addedDate = 'added_date';

    protected static function newFactory()
    {
        // return \Modules\Chat\Database\factories\ChatNotiFactory::new();
    }
    public $timestamps = true;

}
