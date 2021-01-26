<?php

namespace Drupal\social_auth_vipps\EventSubscriber;

use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RequestStack;

class CallbackEventSubscriber implements EventSubscriberInterface
{
  private $request;

  private $messenger;

  public function __construct(RequestStack $requestStack, MessengerInterface $messenger)
  {
    $this->request = $requestStack->getCurrentRequest();
    $this->messenger = $messenger;
  }

  public function checkForErrors(GetResponseEvent $event) {
    if(!empty($this->request->get('error'))) {
      $this->messenger->addError($this->request->get('error_description'));

      $response = new RedirectResponse((new Url('user.login'))->toString(), 301);
      $event->setResponse($response);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      KernelEvents::REQUEST => ['checkForErrors', 30]
    ];
  }
}
