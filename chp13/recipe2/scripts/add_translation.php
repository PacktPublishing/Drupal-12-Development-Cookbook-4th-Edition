<?php

/**
 * @file
 * Programmatically adds a Spanish translation to a node.
 *
 * Run with: drush php:script add_translation.php
 * Set $nid to the ID of an existing node of a translatable content type.
 */

$nid = 1;

$node = \Drupal\node\Entity\Node::load($nid);

// Check if the node already has a Spanish translation.
if (!$node->hasTranslation('es')) {
  // Add the translation.
  $translation = $node->addTranslation('es', [
    'title' => 'Acerca de nosotros',
    'body' => [
      'value' => '<p>Bienvenido a nuestro sitio web.</p>',
      'format' => 'basic_html',
    ],
  ]);
  $translation->save();
}
