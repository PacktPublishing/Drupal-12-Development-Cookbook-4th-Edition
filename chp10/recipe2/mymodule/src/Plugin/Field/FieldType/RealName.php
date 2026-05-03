<?php

namespace Drupal\mymodule\Plugin\Field\FieldType;

use Drupal\Core\Field\Attribute\FieldType;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Provides a Real Name field type.
 */
#[FieldType(
  id: 'mymodule_real_name',
  label: new TranslatableMarkup('Real name'),
  description: new TranslatableMarkup('A field for storing a real name with given and family name.'),
  default_widget: 'mymodule_real_name_default',
  default_formatter: 'mymodule_real_name_default',
)]
class RealName extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition): array {
    return [
      'columns' => [
        'given_name' => [
          'type' => 'varchar',
          'length' => 255,
        ],
        'family_name' => [
          'type' => 'varchar',
          'length' => 255,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {
    $properties = [];
    $properties['given_name'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Given name'));
    $properties['family_name'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Family name'));
    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    $given = $this->get('given_name')->getValue();
    $family = $this->get('family_name')->getValue();
    return empty($given) && empty($family);
  }

}
