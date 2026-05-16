<?php

namespace Drupal\mymodule\Plugin\Field\FieldType;

use Drupal\Core\Field\Attribute\FieldType;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

#[FieldType(
  id: "realname",
  label: new TranslatableMarkup("Real name"),
  description: new TranslatableMarkup("This field stores a first and last name."),
  category: new TranslatableMarkup("General"),
  default_widget: "string_textfield",
  default_formatter: "string",
)]
class RealName extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition): array {
    return [
      'columns' => [
        'given_name' => [
          'description' => 'Given name.',
          'type' => 'varchar',
          'length' => '255',
          'not null' => TRUE,
          'default' => '',
        ],
        'family_name' => [
          'description' => 'Family name.',
          'type' => 'varchar',
          'length' => '255',
          'not null' => TRUE,
          'default' => '',
        ],
      ],
      'indexes' => [
        'given_name' => ['given_name'],
        'family_name' => ['family_name'],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {
    $properties['given_name'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Given name'));
    $properties['family_name'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Family name'));
    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function mainPropertyName(): string {
    return 'given_name';
  }

}
