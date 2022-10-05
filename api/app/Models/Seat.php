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
    'has_used',
    'is_assigned'
  ];

  public function charge()
  {
    return $this->belongsTo(Charge::class, 'charge_id');
  }

  public function event()
  {
    return $this->charge->event();
  }
}
