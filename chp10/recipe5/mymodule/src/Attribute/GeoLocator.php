<?php

namespace Drupal\mymodule\Attribute;

use Drupal\Component\Plugin\Attribute\Plugin;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Defines a GeoLocator attribute.
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class GeoLocator extends Plugin {

  /**
   * Constructs a GeoLocator attribute.
   *
   * @param string $id
   *   The plugin ID.
   * @param \Drupal\Core\StringTranslation\TranslatableMarkup|null $label
   *   The human-readable label of the plugin.
   * @param \Drupal\Core\StringTranslation\TranslatableMarkup|null $description
   *   The description of the plugin.
   * @param class-string|null $deriver
   *   (optional) The deriver class.
   */
  public function __construct(
    public readonly string $id,
    public readonly ?TranslatableMarkup $label = NULL,
    public readonly ?TranslatableMarkup $description = NULL,
    public readonly ?string $deriver = NULL,
  ) {}

}
