<?php

declare(strict_types=1);

namespace Drupal\my_config_translation_alter\Hook;

use Drupal\Core\Hook\Attribute\Hook;

/**
 * Config translation hook implementations.
 *
 * This mirrors how the Node module registers its mapper in
 * \Drupal\node\Hook\NodeConfigTranslationHooks.
 */
class ConfigTranslationHooks {

  /**
   * Implements hook_config_translation_info_alter().
   */
  #[Hook('config_translation_info_alter')]
  public function configTranslationInfoAlter(array &$info): void {
    $info['node_type']['class'] = 'Drupal\node\ConfigTranslation\NodeTypeMapper';
  }

}
