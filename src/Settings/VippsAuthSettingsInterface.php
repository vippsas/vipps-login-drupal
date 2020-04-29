<?php

namespace Drupal\social_auth_vipps\Settings;

/**
 * Defines an interface for Social Auth Vipps settings.
 */
interface VippsAuthSettingsInterface {

  /**
   * Gets the client ID.
   *
   * @return string
   *   The client ID.
   */
  public function getClientId();

  /**
   * Gets the client secret.
   *
   * @return string
   *   The client secret.
   */
  public function getClientSecret();

}
