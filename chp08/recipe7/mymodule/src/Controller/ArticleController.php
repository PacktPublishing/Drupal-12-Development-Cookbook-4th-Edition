<?php

namespace Drupal\mymodule\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends ControllerBase {

  public function delete(NodeInterface $node): JsonResponse {
    $node->delete();
    return new JsonResponse(null, 204);
  }

}
