<?php

namespace Drupal\mymodule\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;

#[Block(
  id: "copyright_block",
  admin_label: new TranslatableMarkup("Copyright"),
  category: new TranslatableMarkup("Custom"),
)]
class Copyright extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $date = new \DateTime();
    return [
      '#markup' => $this->t('Copyright @year&copy; My Company', [
        '@year' => $date->format('Y'),
      ]),
    ];
  }

}
