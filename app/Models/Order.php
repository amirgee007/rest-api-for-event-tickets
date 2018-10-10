<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $guarded = [];
    protected $dates = [];

//    public function ticket(){
//        return $this->hasOne(Ticket::class , 'ticket_id' , 'ticket_id');
//    }

}
