<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
class UserResource extends JsonResource
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
      'email' => $this->email,
      'email_verified_at' => $this->email_verified_at,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
  }
}
