<?php

namespace Drupal\mymodule\Attribute;

use Drupal\Component\Plugin\Attribute\Plugin;

#[\Attribute(\Attribute::TARGET_CLASS)]
class GeoLocator extends Plugin {

  public function __construct(
    public readonly string $id,
    public readonly ?string $label = NULL,
  ) {
    parent::__construct($id);
  }

}
