<?php

namespace Drupal\social_auth_vipps\Provider;

use Drupal\social_auth_vipps\OptionProvider\VippsAuthOptionProvider;
use Drupal\social_auth_vipps\Provider\Exception\VippsIdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class Vipps extends AbstractProvider
{
    use BearerAuthorizationTrait;

    /**
     * Domain
     *
     * @var string
     */
    public $domain = 'https://apitest.vipps.no';//TODO check if test

    /**
     * Api domain
     *
     * @var string
     */
    public $apiDomain = 'https://apitest.vipps.no';//TODO check if test

  public function __construct(array $options = [], array $collaborators = [])
  {
    parent::__construct($options, $collaborators);

    $this->setOptionProvider(new VippsAuthOptionProvider());
  }

  /**
     * Get authorization url to begin OAuth flow
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return $this->domain . '/access-management-1.0/access/oauth2/auth';
    }

    /**
     * Get access token url to retrieve token
     *
     * @param  array $params
     *
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
      return $this->domain . '/access-management-1.0/access/oauth2/token';
    }

    /**
     * Get provider url to fetch user details
     *
     * @param  AccessToken $token
     *
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->domain . '/access-management-1.0/access/userinfo';
    }

    /**
     * Get the default scopes used by this provider.
     *
     * This should not be a complete list of all scopes, but the minimum
     * required for the provider user interface!
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return [];
    }

    /**
     * Check a provider response for errors.
     *
     * @link   https://developer.github.com/v3/#client-errors
     * @link   https://developer.github.com/v3/oauth/#common-errors-for-the-access-token-request
     * @throws VippsIdentityProviderException
     * @param  ResponseInterface $response
     * @param  string $data Parsed response data
     * @return void
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() >= 400) {
            throw VippsIdentityProviderException::clientException($response, $data);
        } elseif (isset($data['error'])) {
            throw VippsIdentityProviderException::oauthException($response, $data);
        }
    }

    /**
     * Generate a user object from a successful user details request.
     *
     * @param array $response
     * @param AccessToken $token
     * @return ResourceOwnerInterface
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        $user = new VippsResourceOwner($response);

        return $user->setDomain($this->domain);
    }

  protected function getScopeSeparator()
  {
    return '+';
  }

  /**
   * Build a query string from an array. Vipps API doesn't work with encoded url
   *
   * @param array $params
   *
   * @return string
   */
  protected function buildQueryString(array $params)
  {
    return urldecode(parent::buildQueryString($params));
  }
}
