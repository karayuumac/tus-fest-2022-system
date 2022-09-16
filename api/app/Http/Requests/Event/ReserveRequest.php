<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class ReserveRequest extends FormRequest
{
  public function rules(): array
  {
    return [
      'number_of_people' => ['integer', 'min:1']
    ];
  }

  public function authorize(): bool
  {
    return true;
  }
}
