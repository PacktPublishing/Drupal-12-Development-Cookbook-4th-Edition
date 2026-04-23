<?php

namespace Drupal\mymodule\Hook;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Access\AccessResultInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Hook\Attribute\Hook;
use Drupal\Core\Session\AccountInterface;

class FieldAccessHooks {

  #[Hook('entity_field_access')]
  public function entityFieldAccess(string $operation, FieldDefinitionInterface $field_definition, AccountInterface $account): AccessResultInterface {
    $field_name = $field_definition->getName();
    if ($field_name === 'promote' || $field_name === 'sticky') {
      $can_promote = $account->hasPermission('can promote nodes');
      return AccessResult::allowedIf($can_promote);
    }
    return AccessResult::neutral();
  }

}
