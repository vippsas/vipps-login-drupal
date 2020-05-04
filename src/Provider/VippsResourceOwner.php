<?php

namespace Drupal\social_auth_vipps\Provider;

use Drupal\social_auth_vipps\Provider\Exception\EmailNotVerifiedException;
use League\OAuth2\Client\Tool\ArrayAccessorTrait;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class VippsResourceOwner implements ResourceOwnerInterface
{
  use ArrayAccessorTrait;

  /**
   * Domain
   *
   * @var string
   */
  protected $domain;

  /**
   * Raw response
   *
   * @var array
   */
  protected $response;

  /**
   * Creates new resource owner.
   *
   * @param array $response
   */
  public function __construct(array $response = array())
  {
    $this->response = $response;
  }

  /**
   * Get resource owner id
   *
   * @return string|null
   */
  public function getId()
  {
    return $this->getValueByKey($this->response, 'sid');
  }

  /**
   * Get resource owner sub
   *
   * @return string|null
   */
  public function getSub()
  {
    return $this->getValueByKey($this->response, 'sub');
  }

  /**
   * Get resource owner email
   *
   * @return string|null
   */
  public function getEmail()
  {
    return $this->getValueByKey($this->response, 'email');
  }

  /**
   * Get resource owner email verified
   *
   * @return string|null
   */
  public function emailVerified()
  {
    return boolval($this->getValueByKey($this->response, 'email_verified'));
  }

  /**
   * Get resource owner name
   *
   * @return string|null
   */
  public function getName()
  {
    return $this->getValueByKey($this->response, 'name');
  }

  /**
   * Get resource owner first name
   *
   * @return string|null
   */
  public function getFirstName()
  {
    return $this->getValueByKey($this->response, 'family_name');
  }

  /**
   * Get resource owner last name
   *
   * @return string|null
   */
  public function getLastName()
  {
    return $this->getValueByKey($this->response, 'given_name');
  }

  /**
   * Get resource owner phone
   *
   * @return string|null
   */
  public function getPhoneNumber()
  {
    return $this->getValueByKey($this->response, 'phone_number');
  }

  /**
   * Get resource owner nickname
   *
   * @return string|null
   */
  public function getNickname()
  {
    return $this->getValueByKey($this->response, 'email');
  }

  /**
   * Get resource owner Address
   *
   * @return AddressData
   */
  public function getAddress()
  {
    $addressBody = $this->getValueByKey($this->response, 'address')[0];

    return new AddressData(
      $addressBody['address_type'],
      $addressBody['country'],
      $addressBody['formatted'],
      $addressBody['postal_code'],
      $addressBody['region'],
      $addressBody['street_address']
    );
  }

  /**
   * Get resource owner url. Not supported
   *
   * @return null
   */
  public function getUrl()
  {
    return null;
  }

  /**
   * Get resource owner avatar url. Not supported
   *
   * @return null
   */
  public function getAvatarUrl()
  {
    return null;
  }

  /**
   * Set resource owner domain
   *
   * @param string $domain
   *
   * @return ResourceOwnerInterface
   */
  public function setDomain($domain)
  {
    $this->domain = $domain;

    return $this;
  }

  /**
   * Return all of the owner details available as an array.
   *
   * @return array
   */
  public function toArray()
  {
    return $this->response;
  }

  /**
   * @throws EmailNotVerifiedException
   */
  public function verificationGuard()
  {
    if (!$this->emailVerified()) {
      throw new EmailNotVerifiedException();
    }
  }
}
