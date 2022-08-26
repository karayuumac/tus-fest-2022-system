<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
  use PasswordValidationRules;

  /**
   * Validate and create a newly registered user.
   *
   * @param array $input
   * @return \App\Models\User
   */
  public function create(array $input)
  {
    Validator::make($input, [
      'family_name' => ['required', 'string', 'max:255'],
      'given_name' => ['required', 'string', 'max:255'],
      'family_name_yomi' => ['required', 'string', 'max:255'],
      'given_name_yomi' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => $this->passwordRules(),
      'phone_number' => ['required', 'string', 'max:50'],
      'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
    ], [], [
      'family_name' => '姓',
      'given_name' => '名',
      'family_name_yomi' => 'セイ',
      'given_name_yomi' => 'メイ',
      'email' => 'メールアドレス',
      'password' => 'パスワード',
      'phone_number' => '電話番号',
      'terms' => '利用規約'
    ])->validate();

    return User::create([
      'family_name' => $input['family_name'],
      'given_name' => $input['given_name'],
      'family_name_yomi' => $input['family_name_yomi'],
      'given_name_yomi' => $input['given_name_yomi'],
      'email' => $input['email'],
      'password' => Hash::make($input['password']),
      'phone_number' => $input['phone_number']
    ]);
  }
}
