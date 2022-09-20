<?php

namespace App\Http\Requests\Seat;

use Illuminate\Foundation\Http\FormRequest;

class ReserveSeatRequest extends FormRequest
{
  public function rules(): array
  {
    return [
      'seats' => ['required', 'array'],
      'seats.*.row' => ['required', 'numeric', 'min:1', 'max:22'],
      'seats.*.col' => ['required', 'numeric', 'min:1', 'max:25']
    ];
  }

  public function authorize(): bool
  {
    return true;
  }
}
