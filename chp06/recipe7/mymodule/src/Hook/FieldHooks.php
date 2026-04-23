<?php

namespace Drupal\mymodule\Hook;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Hook\Attribute\Hook;

class FieldHooks {

  #[Hook('entity_bundle_field_info_alter')]
  public function bundleFieldInfoAlter(
    array &$fields,
    EntityTypeInterface $entity_type,
    string $bundle,
  ): void {
    if ($entity_type->id() === 'node' && isset($fields['field_phone'])) {
      $fields['field_phone']->addConstraint('ValidPhoneNumber');
    }
  }

}
