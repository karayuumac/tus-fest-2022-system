<?php

namespace App\Resources\collection;

use App\Resources\EventResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Event */
class EventCollection extends ResourceCollection
{
  /**
   * @param Request $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'data' => $this->collection->map(function ($row) use ($request) {
        return (new EventResource($row))->toArray($request);
      }),
    ];
  }
}
