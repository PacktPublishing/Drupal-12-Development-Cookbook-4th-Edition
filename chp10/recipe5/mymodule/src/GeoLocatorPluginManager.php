<?php

namespace Drupal\mymodule;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\mymodule\Attribute\GeoLocator;

/**
 * Plugin manager for GeoLocator plugins.
 */
class GeoLocatorPluginManager extends DefaultPluginManager {

  /**
   * Constructs a new GeoLocatorPluginManager.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   The cache backend.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler.
   */
  public function __construct(
    \Traversable $namespaces,
    CacheBackendInterface $cache_backend,
    ModuleHandlerInterface $module_handler,
  ) {
    parent::__construct(
      'Plugin/GeoLocator',
      $namespaces,
      $module_handler,
      GeoLocatorInterface::class,
      GeoLocator::class,
      'Drupal\mymodule\Annotation\GeoLocator'
    );
    $this->alterInfo('geo_locator_info');
    $this->setCacheBackend($cache_backend, 'geo_locator_plugins');
  }

}
