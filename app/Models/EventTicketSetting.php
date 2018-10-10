<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventTicketSetting extends Model
{
    protected $table = 'event_ticket_settings';
    protected $guarded = [];
    protected $dates = ['sale_start_time' , 'sale_end_time'];



}
