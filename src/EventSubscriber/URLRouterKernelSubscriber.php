<?php

/**
 * @file
 * Contains Drupal\urlrouter\EventSubscriber\URLRouterKernelSubscriber.
 */

namespace Drupal\urlrouter\EventSubscriber;

use Drupal\urlrouter\Entity\URLRouterEntity;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class URLRouterKernelSubscriber.
 *
 * @package Drupal\urlrouter\EventSubscriber
 */
class URLRouterKernelSubscriber implements EventSubscriberInterface {

  /**
   * Gets the current path and manages the redirect if required.
   */
  public function onRequest(GetResponseEvent $event) {
    // Get the request from Symfony.
    $request = $event->getRequest();

    // Try to load the config for this page.
    $config = URLRouterEntity::load($request->getUri());

    // If this page has not been flagged to be redirected, continue like normal.
    if (is_null($config)) {
      return;
    }

    // This page is flagged to be redirected. We set the response and let
    // Symfony handle everything else.
    $response = RedirectResponse::create($config->getDestination(), $config->getStatusCode());
    $event->setResponse($response);
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [KernelEvents::REQUEST => 'onRequest'];
  }

}
