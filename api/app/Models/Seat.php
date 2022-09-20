<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
  protected $fillable = [
    'row',
    'col',
    'is_pending',
    'charge_id',
    'ticket_token',
    'has_used'
  ];

  public function charge()
  {
    return $this->belongsTo(Charge::class, 'charge_id');
  }
}
