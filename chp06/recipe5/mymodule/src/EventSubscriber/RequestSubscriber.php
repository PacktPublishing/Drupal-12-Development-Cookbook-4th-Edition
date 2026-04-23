<?php

namespace Drupal\mymodule\EventSubscriber;

use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Url;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class RequestSubscriber implements EventSubscriberInterface {

  public function __construct(
    private readonly RouteMatchInterface $routeMatch,
    private readonly AccountProxyInterface $accountProxy,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      RequestEvent::class => ['doAnonymousRedirect', 28],
    ];
  }

  public function doAnonymousRedirect(RequestEvent $event): void {
    if ($this->routeMatch->getRouteName() == 'user.login') {
      return;
    }
    if ($this->accountProxy->isAnonymous()) {
      $url = Url::fromRoute('user.login')->toString();
      $redirect = new RedirectResponse($url);
      $event->setResponse($redirect);
    }
  }

}
