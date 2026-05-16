<?php

namespace Drupal\mymodule\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Attribute\FieldFormatter;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

#[FieldFormatter(
  id: "realname_one_line",
  label: new TranslatableMarkup("Real name (one line)"),
  field_types: ["realname"],
)]
class RealNameFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(
    FieldItemListInterface $items,
    $langcode
  ): array {
    $element = [];
    foreach ($items as $delta => $item) {
      $element[$delta] = [
        '#markup' => $this->t('@first @last', [
          '@first' => $item->given_name,
          '@last' => $item->family_name,
        ]),
      ];
    }
    return $element;
  }

}
