<?php

namespace Drupal\mymodule\Plugin\GeoLocator;

use Drupal\Core\Plugin\PluginBase;
use Drupal\mymodule\Attribute\GeoLocator;
use Symfony\Component\HttpFoundation\Request;

#[GeoLocator(
  id: "cloudfront",
  label: "CloudFront",
)]
class CloudFront extends PluginBase implements GeoLocatorInterface {

  public function label(): string {
    return $this->pluginDefinition['label'];
  }

  public function geolocate(Request $request): ?string {
    return $request->headers->get('CloudFront-Viewer-Country');
  }

}
