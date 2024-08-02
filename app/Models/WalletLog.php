<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class WalletLog extends Model
{
/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wallet_log';

    /** 
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'users_wallet_id', 'amount_added', 'amount_deducted','currency', 'old_balance','payment_type','payment_status','txn_id','paid_at','on_hold_amount',"log_type"
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
}
