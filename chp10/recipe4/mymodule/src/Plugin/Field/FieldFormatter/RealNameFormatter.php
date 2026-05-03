<?php

namespace Drupal\mymodule\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Attribute\FieldFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Provides a default formatter for the Real Name field type.
 */
#[FieldFormatter(
  id: 'mymodule_real_name_default',
  label: new TranslatableMarkup('Real name'),
  field_types: ['mymodule_real_name'],
)]
class RealNameFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings(): array {
    return [
      'format' => 'given_family',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state): array {
    $form['format'] = [
      '#type' => 'select',
      '#title' => $this->t('Format'),
      '#options' => [
        'given_family' => $this->t('Given name Family name'),
        'family_given' => $this->t('Family name, Given name'),
      ],
      '#default_value' => $this->getSetting('format'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary(): array {
    $summary = [];
    $format = $this->getSetting('format');
    if ($format === 'given_family') {
      $summary[] = $this->t('Format: Given name Family name');
    }
    else {
      $summary[] = $this->t('Format: Family name, Given name');
    }
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $elements = [];
    $format = $this->getSetting('format');

    foreach ($items as $delta => $item) {
      if ($format === 'given_family') {
        $output = $item->given_name . ' ' . $item->family_name;
      }
      else {
        $output = $item->family_name . ', ' . $item->given_name;
      }

      $elements[$delta] = [
        '#markup' => $output,
      ];
    }

    return $elements;
  }

}
