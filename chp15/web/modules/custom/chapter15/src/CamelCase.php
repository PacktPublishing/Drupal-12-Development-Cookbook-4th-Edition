<?php

declare(strict_types=1);

namespace Drupal\chapter15;

/**
 * Provides a utility for converting strings to camelCase.
 */
class CamelCase {

  /**
   * Convert a snake_case string to camelCase.
   *
   * @param string $input
   *   The input string in snake_case format.
   *
   * @return string
   *   The converted camelCase string.
   */
  public static function convert(string $input): string {
    $input = strtolower($input);
    $input = preg_replace('/[, -]/', '_', $input);
    return str_replace('_', '', lcfirst(ucwords($input, '_')));
  }

}
