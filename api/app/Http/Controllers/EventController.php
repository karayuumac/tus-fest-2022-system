<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Resources\collection\EventCollection;
use App\Resources\EventResource;

class EventController extends Controller
{
  public function index()
  {
    return new EventCollection(Event::where('visible', '=', true)->get());
  }

  public function get(int $id)
  {
    return new EventResource(Event::find($id));
  }
}
