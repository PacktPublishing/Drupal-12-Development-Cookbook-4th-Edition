<?php

namespace Drupal\mymodule\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends ControllerBase {

  public function update(Request $request, NodeInterface $node): JsonResponse {
    $content = $request->getContent();
    $json = \Drupal\Component\Serialization\Json::decode($content);
    if (isset($json['title'])) {
      $node->setTitle($json['title']);
    }
    if (isset($json['body'])) {
      $node->set('body', $json['body']);
    }
    $node->save();
    return new JsonResponse(
      $node->toArray()
    );
  }

}
