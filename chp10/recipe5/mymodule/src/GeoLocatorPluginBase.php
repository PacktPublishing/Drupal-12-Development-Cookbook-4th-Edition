<?php

namespace Drupal\mymodule;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for GeoLocator plugins.
 */
abstract class GeoLocatorPluginBase extends PluginBase implements GeoLocatorInterface {

  /**
   * {@inheritdoc}
   */
  public function label(): string {
    return (string) $this->pluginDefinition['label'];
  }

  /**
   * {@inheritdoc}
   */
  public function description(): string {
    return (string) $this->pluginDefinition['description'];
  }

}
