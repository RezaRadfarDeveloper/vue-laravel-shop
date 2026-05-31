<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = ['status','type','order_id','amount','created_by', 'updated_by','session_id'];

    public function order():BelongsTo {
        return $this->belongsTo(Order::class);
    }
}
