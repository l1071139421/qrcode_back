<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itemdata extends Model
{
    //
    protected $table = 'itemdata';

    protected $fillable = ['item_id', 'token', 'property_num', 'address'];
}
