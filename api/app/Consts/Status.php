<?php

namespace App\Consts;

class Status
{
  public const LOTTERY_APPLICATIONS = "lottery_applications";
  public const PENDING = 'pending';
  public const DONE = 'done';

  public const statuses = [
    self::LOTTERY_APPLICATIONS,
    self::PENDING,
    self::DONE
  ];
}
