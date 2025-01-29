<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
   protected $fillable = ['user_id', 'amount', 'type', 'target_user_id'];
}
