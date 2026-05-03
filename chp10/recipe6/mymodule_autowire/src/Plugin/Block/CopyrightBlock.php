<?php

namespace Drupal\mymodule_autowire\Plugin\Block;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\AutowireTrait;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Provides a Copyright block using AutowireTrait.
 */
#[Block(
  id: 'mymodule_autowire_copyright',
  admin_label: new TranslatableMarkup('Copyright (Autowired)'),
  category: new TranslatableMarkup('Custom'),
)]
class CopyrightBlock extends BlockBase implements ContainerFactoryPluginInterface {

  use AutowireTrait;

  /**
   * Constructs a new CopyrightBlock instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Component\Datetime\TimeInterface $time
   *   The time service.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    protected TimeInterface $time,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $year = date('Y', $this->time->getRequestTime());
    return [
      '#markup' => '&copy; ' . $year,
    ];
  }

}
