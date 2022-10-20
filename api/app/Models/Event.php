<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'application_start_date',
    'due_date',
    'begin_date',
    'end_date',
    'price',
    'status',
    'visible',
    'max_reservation_count'
  ];

  protected $casts = [
    'visible' => 'boolean'
  ];

  public function isFree()
  {
    return $this->price === 0;
  }

  public function reserves()
  {
    return $this->hasMany(Reserve::class, 'event_id');
  }

  public function charges()
  {
    return $this->hasMany(Charge::class, 'event_id');
  }

  public function canReserve()
  {
    if (!Auth::check()) {
      return false;
    }
    if (Carbon::now()->isBefore($this->application_start_date) || Carbon::now()->isAfter($this->due_date)) {
      return false;
    }
    if (!$this->get('visible')) {
      return false;
    }
    return
      count(
        Reserve::where([
          'reserve_user_id' => Auth::id(),
          'event_id' => $this->id
        ])->get()) == 0
      && count(Charge::where([
        'reserved_user_id' => Auth::id(),
        'event_id' => $this->id
      ])->get()) == 0;
  }
}
