<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //
    protected $table = 'report';

    protected $fillable = ['item_id', 'bill', 'bill_degree', 'degree', 'type', 'user_id', 'date'];

    const YEAR = 'Year';

    const MONTH = 'Month';

    const DAY = 'Day';
}
