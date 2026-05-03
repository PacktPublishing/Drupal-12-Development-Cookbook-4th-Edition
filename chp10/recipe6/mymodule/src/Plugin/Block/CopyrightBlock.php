<?php

namespace Drupal\mymodule\Plugin\Block;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Copyright block with autowiring.
 */
#[Block(
  id: 'mymodule_copyright',
  admin_label: new TranslatableMarkup('Copyright'),
  category: new TranslatableMarkup('Custom'),
)]
class CopyrightBlock extends BlockBase implements ContainerFactoryPluginInterface {

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
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): static {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('datetime.time'),
    );
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
