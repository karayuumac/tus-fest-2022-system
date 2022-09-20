<?php

namespace App\Resources\collection;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Seat */
class SeatCollection extends ResourceCollection
{
  /**
   * @param Request $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'data' => $this->collection,
    ];
  }
}
