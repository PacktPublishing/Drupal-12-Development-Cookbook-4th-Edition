<?php

namespace Drupal\mymodule\Plugin\Field\FieldWidget;

use Drupal\Core\Field\Attribute\FieldWidget;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

#[FieldWidget(
  id: "realname_default",
  label: new TranslatableMarkup("Real name"),
  field_types: ["realname"],
)]
class RealNameDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(
    FieldItemListInterface $items,
    $delta,
    array $element,
    array &$form,
    FormStateInterface $form_state
  ): array {
    $element['given_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First name'),
      '#default_value' => '',
      '#size' => 25,
      '#required' => $element['#required'],
    ];
    $element['family_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Last name'),
      '#default_value' => '',
      '#size' => 25,
      '#required' => $element['#required'],
    ];
    return $element;
  }

}
