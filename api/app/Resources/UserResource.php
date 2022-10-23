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
      'family_name' => $this->family_name,
      'given_name' => $this->given_name,
      'family_name_yomi' => $this->family_name_yomi,
      'given_name_yomi' => $this->given_name_yomi,
      'email' => $this->email,
      'has_email_verified' => $this->email_verified_at !== null,
      'is_admin' => $this->is_admin
    ];
  }
}
