<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BidStripeTransaction extends Model
{

    /** 
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

   
    protected $table = 'bid_stripe_transactions';
    protected $fillable = [
        'bid_details_id','txn_id','payment_type','payment_status','txn_date'
    ];


    public $timestamps = true;

    
 


}
