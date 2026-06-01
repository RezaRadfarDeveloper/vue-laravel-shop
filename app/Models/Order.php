<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = ['status','total_price', 'created_by','updated_by'];

    public function isPaid() {
       return $this->status == 'paid';
    }

    public function payment():HasOne {
return $this->hasOne(Payment::class);
    }

    public function items():HasMany {
        return $this->hasMany(OrderItem::class);
    }
}
