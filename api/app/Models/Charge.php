<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
  protected $fillable = [
    'event_id',
    'reserved_user_id',
    'charge_id',
    'is_pending'
  ];

  public function seats()
  {
    return $this->hasMany(Seat::class, 'charge_id');
  }

  public function scopePending(Builder $query)
  {
    return $query->where('is_pending', true);
  }

  public function event()
  {
    return $this->belongsTo(Event::class, 'event_id');
  }
}
