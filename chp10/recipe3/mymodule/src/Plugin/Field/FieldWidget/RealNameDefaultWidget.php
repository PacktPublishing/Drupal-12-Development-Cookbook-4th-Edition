<?php

namespace Drupal\mymodule\Plugin\Field\FieldWidget;

use Drupal\Core\Field\Attribute\FieldWidget;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Provides a default widget for the Real Name field type.
 */
#[FieldWidget(
  id: 'mymodule_real_name_default',
  label: new TranslatableMarkup('Real name'),
  field_types: ['mymodule_real_name'],
)]
class RealNameDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {
    $element['given_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Given name'),
      '#default_value' => $items[$delta]->given_name ?? '',
      '#size' => 25,
    ];
    $element['family_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Family name'),
      '#default_value' => $items[$delta]->family_name ?? '',
      '#size' => 25,
    ];
    return $element;
  }

}
