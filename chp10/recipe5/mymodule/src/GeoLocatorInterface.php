<?php

namespace Drupal\mymodule;

/**
 * Interface for GeoLocator plugins.
 */
interface GeoLocatorInterface {

  /**
   * Gets the label of the plugin.
   *
   * @return string
   *   The label.
   */
  public function label(): string;

  /**
   * Gets the description of the plugin.
   *
   * @return string
   *   The description.
   */
  public function description(): string;

  /**
   * Retrieves the coordinates for a given address.
   *
   * @param string $address
   *   The address to geocode.
   *
   * @return array|null
   *   An array with 'lat' and 'lng' keys, or NULL if geocoding failed.
   */
  public function getCoordinates(string $address): ?array;

}
