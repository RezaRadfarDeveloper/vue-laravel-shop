<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    protected $fillable = ['first_name', 'last_name','country_code', 'status', 'phone', 'created_by', 'updated_by'];
   
    public function user():HasOne {
        return $this->hasOne(User::class,'id','id');
    }

    public function country():HasOne {
        return $this->hasOne(Country::class,'code','country_code' );
    }

}
