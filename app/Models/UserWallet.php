<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class UserWallet extends Model
{

   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users_wallet';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id','currency', 'wallet_balance', 'recharge_date','amount_on_hold'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
}
