<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Seat */
class SeatResource extends JsonResource
{
  /**
   * @param Request $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'row' => $this->row,
      'col' => $this->col,
      'is_pending' => $this->is_pending,
      'ticket_token' => $this->ticket_token,
      'has_used' => $this->has_used,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,

      /*
      'event_id' => $this->event_id,
      'reserve_user_id' => $this->reserve_user_id,

      'event' => new EventResource($this->whenLoaded('event')),
      'user' => new UserResource($this->whenLoaded('user')),
      */
    ];
  }
}
