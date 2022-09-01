<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Event */
class EventResource extends JsonResource
{
  /**
   * @param Request $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'application_start_date' => $this->application_start_date,
      'due_date' => $this->due_date,
      'begin_date' => $this->begin_date,
      'end_date' => $this->end_date,
      'price' => $this->price,
      'status' => $this->status,
      'visible' => $this->visible,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
  }
}
