<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidDetails extends Model
{
    
/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bid_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'buyer_id', 'seller_id', 'bid_price','product_price', 'product_id', 'product_title','bid_status','bid_commission','amount_paid','disputed_bid','dispute_type','dispute_reason','dispute_status','dispute_status_notes','dispute_images','update_date_time','bid_payment_status','dispute_refund','payment_type','bid_created_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     * 
     * @var bool
     */
    public $timestamps = true;
}

