<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Resources\EventCollection;

class EventController extends Controller
{
  public function index()
  {
    return new EventCollection(Event::where('visible',  '=', true)->get());
  }
}
