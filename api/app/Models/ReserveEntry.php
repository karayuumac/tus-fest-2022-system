<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReserveEntry extends Model
{
  protected $fillable = [
    'reserve_id',
    'entry_time'
  ];
}
