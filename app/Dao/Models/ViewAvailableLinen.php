<?php

namespace App\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class ViewAvailableLinen extends Model
{
    protected $table = 'view_available_linen';

    protected $primaryKey = 'view_linen_rfid';

    protected $casts = [
        'view_linen_rfid' => 'string',
        'view_rs_id' => 'integer',
    ];

    protected $filters = [
        'view_rs_id',
        'view_status',
    ];
}
