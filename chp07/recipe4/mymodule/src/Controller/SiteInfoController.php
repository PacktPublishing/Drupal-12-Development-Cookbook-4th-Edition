<?php

namespace Drupal\mymodule\Controller;

use Drupal\Core\Cache\CacheableJsonResponse;
use Drupal\Core\Controller\ControllerBase;

class SiteInfoController extends ControllerBase {

  /**
   * Returns site info in a JSON response.
   *
   * @return \Drupal\Core\Cache\CacheableJsonResponse
   *   The JSON response.
   */
  public function page(): CacheableJsonResponse {
    $config = $this->config('system.site');
    $response = new CacheableJsonResponse([
      'name' => $config->get('name'),
      'slogan' => $config->get('slogan'),
      'email' => $config->get('mail'),
    ]);
    $response->addCacheableDependency($config);
    return $response;
  }

}
