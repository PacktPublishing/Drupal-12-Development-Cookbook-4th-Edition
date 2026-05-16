<?php

namespace Drupal\mymodule\Plugin\GeoLocator;

use Symfony\Component\HttpFoundation\Request;

interface GeoLocatorInterface {

  /**
   * Get the plugin's label.
   */
  public function label(): string;

  /**
   * Performs geolocation on a request.
   *
   * @return string|null
   *   The geolocated country code, or NULL.
   */
  public function geolocate(Request $request): ?string;

}
