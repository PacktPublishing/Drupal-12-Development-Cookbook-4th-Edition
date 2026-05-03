<?php

namespace Drupal\mymodule\Controller;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;

class ArticleListController extends ControllerBase {

  /**
   * Displays a list of published articles.
   *
   * @return array
   *   The render array.
   */
  public function page(): array {
    $storage = $this->entityTypeManager()->getStorage('node');
    $query = $storage->getQuery()
      ->condition('type', 'article')
      ->condition('status', NodeInterface::PUBLISHED)
      ->sort('created', 'DESC')
      ->range(0, 10)
      ->accessCheck(TRUE);
    $nids = $query->execute();
    $nodes = $storage->loadMultiple($nids);

    $cache = new CacheableMetadata();
    $cache->addCacheTags(['node_list:article']);
    $cache->addCacheContexts(['user.permissions']);

    $items = [];
    foreach ($nodes as $node) {
      $items[] = $node->toLink()->toString();
      $cache->addCacheableDependency($node);
    }

    $build = [
      '#theme' => 'item_list',
      '#items' => $items,
      '#title' => 'Recent Articles',
      '#empty' => 'No articles found.',
    ];
    $cache->applyTo($build);

    return $build;
  }

}
