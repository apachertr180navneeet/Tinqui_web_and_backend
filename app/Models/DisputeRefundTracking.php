<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisputeRefundTracking extends Model
{
    use HasFactory;

     /** 
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

   
    protected $table = 'dispute_refund_tracking';
    protected $fillable = [
        'bid_id','refund_id','refund_status','update_date'
    ];


    public $timestamps = true;

    
 


} 
