<?php

namespace Drupal\social_auth_vipps\OptionProvider;

use League\OAuth2\Client\OptionProvider\PostAuthOptionProvider;

class VippsAuthOptionProvider extends PostAuthOptionProvider
{
  /**
   * @inheritdoc
   */
  public function getAccessTokenOptions($method, array $params)
  {
    $options =  parent::getAccessTokenOptions($method, $params);


//    $args = [
//      'grant_type' => 'authorization_code',
//      'code' => $code,
//      'redirect_uri' => $this->configManager->getRedirectUrl()
//    ];
//
//    $response = $this->httpClient->request('POST', $url, [
//      'headers' => [
//        'Authorization' => $this->configManager->getAuthorizationStringForAuthToken(),
//      ],
//      'form_params' => $args,
//    ]);

    $options['headers']['Authorization'] = "Basic " . base64_encode("{$params['client_id']}:{$params['client_secret']}");
//    $options['form_params'] = $options['body'];
//    unset($options['body']);
//
//    dd('VippsAuthOptionProvider', $params, $options);

    return $options;
  }
}
