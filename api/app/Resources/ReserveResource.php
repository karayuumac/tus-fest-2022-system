<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Reserve */
class ReserveResource extends JsonResource
{
  /**
   * @param Request $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'ticket_token' => $this->ticket_token,
      'is_assigned' => $this->is_assigned,
      'has_used' => $this->has_used,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,

      'event_id' => $this->event_id,
      'reserve_user_id' => $this->reserve_user_id,
    ];
  }
}
