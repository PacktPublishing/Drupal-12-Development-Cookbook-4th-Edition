<?php

namespace Drupal\mymodule;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\mymodule\Attribute\GeoLocator as GeoLocatorAttribute;

class GeoLocatorManager extends DefaultPluginManager {

  public function __construct(
    \Traversable $namespaces,
    CacheBackendInterface $cache_backend,
    ModuleHandlerInterface $module_handler,
  ) {
    parent::__construct(
      'Plugin/GeoLocator',
      $namespaces,
      $module_handler,
      'Drupal\mymodule\Plugin\GeoLocator\GeoLocatorInterface',
      GeoLocatorAttribute::class,
    );
  }

}
