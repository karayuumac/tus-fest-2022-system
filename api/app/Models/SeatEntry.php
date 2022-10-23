<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeatEntry extends Model
{
  protected $fillable = [
    'seat_id',
    'entry_time'
  ];
}
