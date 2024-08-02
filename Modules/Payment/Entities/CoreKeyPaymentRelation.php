<?php

namespace Modules\Payment\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoreKeyPaymentRelation extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'payment_id', 'core_key_id', 'added_date', 'added_user_id', 'updated_date', 'updated_user_id', 'updated_flag'];

    protected $table = "core_key_payment_relations";

    const CREATED_AT = 'added_date';
    const UPDATED_AT = 'updated_date';

    const tableName = "core_key_payment_relations";
    const id = "id";
    const paymentId = "payment_id";
    const coreKeysId = "core_keys_id";
    const addedDate = 'added_date';

    protected static function newFactory()
    {
        // return \Modules\Payment\Database\factories\CoreKeyPaymentRelationFactory::new();
    }

    public function owner(){
        return $this->belongsTo(User::class, 'added_user_id');
    }

    public function editor(){
        return $this->belongsTo(User::class, 'updated_user_id');
    }
}
