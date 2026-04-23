<?php

namespace Drupal\mymodule\Hook;

use Drupal\Core\Hook\Attribute\Hook;
use Drupal\mymodule\NodeStatisticsService;
use Drupal\node\NodeInterface;

class NodeViewHooks {

  public function __construct(
    protected readonly NodeStatisticsService $nodeStatistics,
  ) {}

  #[Hook('node_view')]
  public function nodeView(array &$build, NodeInterface $node): void {
    $this->nodeStatistics->recordView((int) $node->id());
  }

}
