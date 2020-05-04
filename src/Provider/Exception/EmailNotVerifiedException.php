<?php

namespace Drupal\social_auth_vipps\Provider\Exception;

use Throwable;

class EmailNotVerifiedException extends \Exception
{
  public function __construct($message = "Email is not verified", $code = 0, Throwable $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }
}
