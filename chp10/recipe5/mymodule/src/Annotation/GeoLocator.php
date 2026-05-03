<?php

namespace Drupal\mymodule\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a GeoLocator annotation object.
 *
 * @Annotation
 */
class GeoLocator extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public string $id;

  /**
   * The human-readable name of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $label;

  /**
   * A brief description of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $description;

}
