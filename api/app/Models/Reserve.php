<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
  protected $fillable = [
    'event_id',
    'reserve_user_id',
    'ticket_token',
    'has_used',
    'is_assigned'
  ];

  public function event()
  {
    return $this->belongsTo(Event::class, 'event_id');
  }

  public function reserveUser()
  {
    return $this->belongsTo(User::class, 'reserve_user_id');
  }
}
