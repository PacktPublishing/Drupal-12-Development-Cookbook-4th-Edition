<?php

namespace Drupal\mymodule\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

#[Block(
  id: "copyright_block",
  admin_label: new TranslatableMarkup("Copyright"),
  category: new TranslatableMarkup("Custom"),
)]
class Copyright extends BlockBase implements ContainerFactoryPluginInterface {

  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    private readonly RouteMatchInterface $routeMatch,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  // No create() method needed -- inherited from
  // PluginBase via AutowiredInstanceTrait.

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $date = new \DateTime();
    return [
      '#markup' => $this->t(
        'Copyright @year&copy; My Company (route: @route)', [
          '@year' => $date->format('Y'),
          '@route' => $this->routeMatch->getRouteName(),
        ]),
    ];
  }

}
