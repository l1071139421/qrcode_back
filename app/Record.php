<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    //
    protected $table = 'records';

    protected $fillable = ['id', 'item_id', 'user_id', 'degree', 'item_token','date'];
}
