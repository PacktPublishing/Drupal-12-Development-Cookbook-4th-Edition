<?php

namespace Drupal\mymodule\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Provides a Copyright block.
 */
#[Block(
  id: 'mymodule_copyright',
  admin_label: new TranslatableMarkup('Copyright'),
  category: new TranslatableMarkup('Custom'),
)]
class CopyrightBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $date = new \DateTime();
    return [
      '#markup' => $this->t('Copyright @year&copy; My Company', ['@year' => $date->format('Y')]),
    ];
  }

}
