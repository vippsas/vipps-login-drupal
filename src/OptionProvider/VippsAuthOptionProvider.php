<?php

namespace Drupal\social_auth_vipps\OptionProvider;

use League\OAuth2\Client\OptionProvider\OptionProviderInterface;
use League\OAuth2\Client\Tool\QueryBuilderTrait;

class VippsAuthOptionProvider implements OptionProviderInterface
{
  use QueryBuilderTrait;

  /**
   * @inheritdoc
   */
  public function getAccessTokenOptions($method, array $params)
  {
    $body = $this->getAccessTokenBody([
      'grant_type' => $params['grant_type'],
      'code' => $params['code'],
      'redirect_uri' => $params['redirect_uri'],
    ]);

    return [
      'headers' => [
        'Authorization' => "Basic " . base64_encode("{$params['client_id']}:{$params['client_secret']}"),
        'content-type' => 'application/x-www-form-urlencoded'
      ],
      'body' => $body,
    ];
  }

  /**
   * Returns the request body for requesting an access token.
   *
   * @param  array $params
   * @return string
   */
  protected function getAccessTokenBody(array $params)
  {
    return urldecode($this->buildQueryString($params));
  }
}
