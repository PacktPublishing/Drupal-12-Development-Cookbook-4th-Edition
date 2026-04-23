<?php

namespace Drupal\mymodule;

use Drupal\Core\Database\Connection;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Component\Datetime\TimeInterface;

class NodeStatisticsService {

  public function __construct(
    protected readonly Connection $database,
    protected readonly AccountProxyInterface $currentUser,
    protected readonly TimeInterface $time,
  ) {}

  public function recordView(int $nid): void {
    $this->database->merge('mymodule_node_stats')
      ->keys(['nid' => $nid])
      ->fields([
        'view_count' => 1,
        'last_viewed' => $this->time->getRequestTime(),
        'last_viewer_uid' => $this->currentUser->id(),
      ])
      ->expression('view_count', '[view_count] + 1')
      ->execute();
  }

  public function getViewCount(int $nid): int {
    $result = $this->database->select('mymodule_node_stats', 's')
      ->fields('s', ['view_count'])
      ->condition('nid', $nid)
      ->execute()
      ->fetchField();
    return (int) ($result ?: 0);
  }

}
