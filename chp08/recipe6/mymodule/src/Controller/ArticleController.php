<?php

namespace Drupal\mymodule\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;

class ArticleController extends ControllerBase {

  /**
   * Renders an article using a specified view mode.
   *
   * @param \Drupal\node\NodeInterface $node
   *   The node entity.
   * @param string $view_mode
   *   The view mode to render.
   *
   * @return array
   *   The render array.
   */
  public function view(NodeInterface $node, string $view_mode = 'full'): array {
    $view_builder = $this->entityTypeManager()
      ->getViewBuilder('node');
    $build = $view_builder->view($node, $view_mode);
    return $build;
  }

  /**
   * Returns the title for the article view page.
   */
  public function viewTitle(NodeInterface $node): string|\Stringable {
    return $node->label();
  }

  /**
   * Renders the article edit form in a given form mode.
   *
   * @param \Drupal\node\NodeInterface $node
   *   The node entity.
   * @param string $form_mode
   *   The form mode to use.
   *
   * @return array
   *   The form render array.
   */
  public function editForm(NodeInterface $node, string $form_mode = 'default'): array {
    return $this->entityFormBuilder()
      ->getForm($node, $form_mode);
  }

}
