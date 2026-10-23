<?php

namespace Drupal\mymodule\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends ControllerBase {

  public function get(NodeInterface $node): JsonResponse {
    $entity_type_manager = $this->entityTypeManager();
    $access_handler = $entity_type_manager->getAccessControlHandler('node');
    $node_access = $access_handler->access($node, 'view');
    if (!$node_access) {
      return new JsonResponse(NULL, 404);
    }
    return new JsonResponse(
      $node->toArray(),
    );
  }

}
