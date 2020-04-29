<?php

namespace Drupal\social_auth_vipps\Plugin\Network;

use Drupal\Core\Url;
use Drupal\social_api\SocialApiException;
use Drupal\social_auth\Plugin\Network\NetworkBase;
use Drupal\social_auth_vipps\Settings\VippsAuthSettings;
use Drupal\social_api\Annotation\Network;
use Drupal\social_auth_vipps\Provider\Vipps as VippsProvider;

/**
 * Defines a Network Plugin for Social Auth Vipps.
 *
 * @package Drupal\social_auth_vipps\Plugin\Network
 *
 * @Network(
 *   id = "social_auth_vipps",
 *   social_network = "Vipps",
 *   type = "social_auth",
 *   handlers = {
 *     "settings": {
 *       "class": "\Drupal\social_auth_vipps\Settings\VippsAuthSettings",
 *       "config_id": "social_auth_vipps.settings"
 *     }
 *   }
 * )
 */
class VippsAuth extends NetworkBase implements VippsAuthInterface {

  /**
   * Sets the underlying SDK library.
   *
   * @return VippsProvider|false
   *   The initialized 3rd party library instance.
   *   False if library could not be initialized.
   *
   * @throws \Drupal\social_api\SocialApiException
   *   If the SDK library does not exist.
   */
  protected function initSdk() {

    $class_name = VippsProvider::class;
    if (!class_exists($class_name)) {
      throw new SocialApiException(sprintf('The Vipps library for PHP League OAuth2 not found. Class: %s.', $class_name));
    }

    /** @var \Drupal\social_auth_vipps\Settings\VippsAuthSettings $settings */
    $settings = $this->settings;

    if ($this->validateConfig($settings)) {
      // All these settings are mandatory.
      $league_settings = [
        'clientId' => $settings->getClientId(),
        'clientSecret' => $settings->getClientSecret(),
        'redirectUri' => Url::fromRoute('social_auth_vipps.callback')->setAbsolute()->toString(),
      ];

      // Proxy configuration data for outward proxy.
      $proxyUrl = $this->siteSettings->get('http_client_config')['proxy']['http'];
      if ($proxyUrl) {
        $league_settings['proxy'] = $proxyUrl;
      }

      return new VippsProvider($league_settings);
    }

    return FALSE;
  }

  /**
   * Checks that module is configured.
   *
   * @param \Drupal\social_auth_vipps\Settings\VippsAuthSettings $settings
   *   The Vipps auth settings.
   *
   * @return bool
   *   True if module is configured.
   *   False otherwise.
   */
  protected function validateConfig(VippsAuthSettings $settings) {
    $client_id = $settings->getClientId();
    $client_secret = $settings->getClientSecret();
    if (!$client_id || !$client_secret) {
      $this->loggerFactory
        ->get('social_auth_vipps')
        ->error('Define Client ID and Client Secret on module settings.');

      return FALSE;
    }

    return TRUE;
  }

}
