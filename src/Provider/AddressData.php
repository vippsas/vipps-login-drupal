<?php

namespace Drupal\social_auth_vipps\Provider;

class AddressData
{
  private $address_type;

  private $country;

  private $formatted;

  private $postalCode;

  private $region;

  private $streetAddress;

  public function __construct(
    ?string $address_type,
    ?string $country,
    ?string $formatted,
    ?string $postalCode,
    ?string $region,
    ?string $streetAddress
  )
  {
    $this->address_type = $address_type;
    $this->country = $country;
    $this->formatted = $formatted;
    $this->postalCode = $postalCode;
    $this->region = $region;
    $this->streetAddress = $streetAddress;
  }

  /**
   * @return string
   */
  public function getAddressType(): ?string
  {
    return $this->address_type;
  }

  /**
   * @return string
   */
  public function getCountry(): ?string
  {
    return $this->country;
  }

  /**
   * @return string
   */
  public function getFormatted(): ?string
  {
    return $this->formatted;
  }

  /**
   * @return string
   */
  public function getPostalCode(): ?string
  {
    return $this->postalCode;
  }

  /**
   * @return string
   */
  public function getRegion(): ?string
  {
    return $this->region;
  }

  /**
   * @return string
   */
  public function getStreetAddress(): ?string
  {
    return $this->streetAddress;
  }
}
