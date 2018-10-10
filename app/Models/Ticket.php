<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';
    protected $guarded = [];
    protected $primaryKey = 'ticket_id';
    protected $dates = ['sale_end_time'];
}
