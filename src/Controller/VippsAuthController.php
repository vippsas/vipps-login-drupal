<?php

namespace Drupal\social_auth_vipps\Controller;

use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\social_api\Plugin\NetworkManager;
use Drupal\social_auth\Controller\OAuth2ControllerBase;
use Drupal\social_auth\SocialAuthDataHandler;
use Drupal\social_auth\User\UserAuthenticator;
use Drupal\social_auth_vipps\VippsAuthManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\social_auth_vipps\Provider\VippsResourceOwner;

/**
 * Returns responses for Social Auth Vipps routes.
 */
class VippsAuthController extends OAuth2ControllerBase {

  /**
   * VippsAuthController constructor.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   * @param \Drupal\social_api\Plugin\NetworkManager $network_manager
   *   Used to get an instance of social_auth_vipps network plugin.
   * @param \Drupal\social_auth\User\UserAuthenticator $user_authenticator
   *   Manages user login/registration.
   * @param \Drupal\social_auth_vipps\VippsAuthManager $vipps_manager
   *   Used to manage authentication methods.
   * @param \Symfony\Component\HttpFoundation\RequestStack $request
   *   Used to access GET parameters.
   * @param \Drupal\social_auth\SocialAuthDataHandler $data_handler
   *   The Social Auth data handler.
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   Used to handle metadata for redirection to authentication URL.
   */
  public function __construct(MessengerInterface $messenger,
                              NetworkManager $network_manager,
                              UserAuthenticator $user_authenticator,
                              VippsAuthManager $vipps_manager,
                              RequestStack $request,
                              SocialAuthDataHandler $data_handler,
                              RendererInterface $renderer) {

    parent::__construct('Social Auth Vipps', 'social_auth_vipps',
                        $messenger, $network_manager, $user_authenticator,
      $vipps_manager, $request, $data_handler, $renderer);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('messenger'),
      $container->get('plugin.network.manager'),
      $container->get('social_auth.user_authenticator'),
      $container->get('social_auth_vipps.manager'),
      $container->get('request_stack'),
      $container->get('social_auth.data_handler'),
      $container->get('renderer')
    );
  }

  /**
   * Response for path 'user/login/vipps/callback'.
   *
   * Vipps returns the user here after user has authenticated.
   */
  public function callback() {

    /** @var VippsResourceOwner|null $profile */
    $profile = $this->processCallback();

    // If authentication was successful.
    if ($profile !== NULL) {

      // Gets (or not) extra initial data.
      $data = $this->userAuthenticator->checkProviderIsAssociated($profile->getId()) ? NULL : $this->providerManager->getExtraDetails();

      // GitHub allows the user to leave their name empty. Use nickname in that
      // case.
      $name = $profile->getName() ?? $profile->getNickName();

      // If user information could be retrieved.
      return $this->userAuthenticator->authenticateUser($name,
                                                        $profile->getEmail(),
                                                        $profile->getId(),
                                                        $this->providerManager->getAccessToken(),
                                                        $profile->toArray()['avatar_url'],
                                                        $data);
    }

    return $this->redirect('user.login');
  }

}
