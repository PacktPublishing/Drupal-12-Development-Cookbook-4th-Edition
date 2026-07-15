<?php

declare(strict_types=1);

namespace Drupal\chapter15\Plugin\Field\FieldFormatter;

use Drupal\chapter15\CamelCase;
use Drupal\Core\Field\Attribute\FieldFormatter;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\StringFormatter;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Plugin implementation of the 'camel_case' field formatter.
 */
#[FieldFormatter(
  id: 'camel_case',
  label: new TranslatableMarkup('Camel case'),
  field_types: [
    'string',
  ],
)]
class CamelCaseFormatter extends StringFormatter {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $elements = [];
    foreach ($items as $delta => $item) {
      $view_value = $this->viewValue($item);
      $elements[$delta] = $view_value;
    }
    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  protected function viewValue(FieldItemInterface $item): array {
    return [
      '#type' => 'inline_template',
      '#template' => '{{ value|nl2br }}',
      '#context' => ['value' => CamelCase::convert($item->value)],
    ];
  }

}
