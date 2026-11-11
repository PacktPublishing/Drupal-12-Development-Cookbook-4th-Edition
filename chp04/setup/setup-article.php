<?php

/**
 * @file
 * Creates the Article content type, Body and Tags fields, and sample content.
 *
 * Drupal 12's Standard profile no longer creates the Article content type or
 * the Tags field, but the Chapter 4 recipes rely on them. Run this once on a
 * fresh Standard install, after applying the Tags recipe:
 *
 *   vendor/bin/dr recipe core/recipes/tags_taxonomy
 *   drush php:script chp04/setup/setup-article.php
 *   (or, without Drush: php chp04/setup/setup-article.php)
 *
 * When run through `drush php:script` Drupal is already bootstrapped. To run
 * it without Drush, see the bootstrap block below.
 */

use Drupal\Core\DrupalKernel;
use Drupal\Core\Entity\Entity\EntityFormDisplay;
use Drupal\Core\Entity\Entity\EntityViewDisplay;
use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\node\Entity\Node;
use Drupal\node\Entity\NodeType;
use Drupal\taxonomy\Entity\Term;
use Symfony\Component\HttpFoundation\Request;

if (!class_exists(\Drupal::class, FALSE) || !\Drupal::hasContainer()) {
  $root = getcwd();
  $autoloader = require $root . '/vendor/autoload.php';
  chdir($root . '/web');
  $request = Request::create('/', 'GET', [], [], [], [
    'SCRIPT_NAME' => '/index.php',
    'SCRIPT_FILENAME' => $root . '/web/index.php',
    'HTTP_HOST' => 'localhost',
  ]);
  $kernel = DrupalKernel::createFromRequest($request, $autoloader, 'prod');
  $kernel->boot();
  $kernel->preHandle($request);
}

// Article content type.
if (!NodeType::load('article')) {
  NodeType::create([
    'type' => 'article',
    'name' => 'Article',
    'description' => 'Use articles for time-sensitive content like news or blog posts.',
  ])->save();
}

// Body field.
if (!FieldStorageConfig::loadByName('node', 'body')) {
  FieldStorageConfig::create([
    'field_name' => 'body',
    'entity_type' => 'node',
    'type' => 'text_long',
  ])->save();
}
if (!FieldConfig::loadByName('node', 'article', 'body')) {
  FieldConfig::create([
    'field_name' => 'body',
    'entity_type' => 'node',
    'bundle' => 'article',
    'label' => 'Body',
  ])->save();
}

// Tags field (references the "tags" vocabulary from the tags_taxonomy recipe).
if (!FieldStorageConfig::loadByName('node', 'field_tags')) {
  FieldStorageConfig::create([
    'field_name' => 'field_tags',
    'entity_type' => 'node',
    'type' => 'entity_reference',
    'cardinality' => -1,
    'settings' => ['target_type' => 'taxonomy_term'],
  ])->save();
}
if (!FieldConfig::loadByName('node', 'article', 'field_tags')) {
  FieldConfig::create([
    'field_name' => 'field_tags',
    'entity_type' => 'node',
    'bundle' => 'article',
    'label' => 'Tags',
    'settings' => [
      'handler' => 'default:taxonomy_term',
      'handler_settings' => [
        'target_bundles' => ['tags' => 'tags'],
        'auto_create' => TRUE,
      ],
    ],
  ])->save();
}

// Form and view displays.
$form = EntityFormDisplay::load('node.article.default')
  ?? EntityFormDisplay::create([
    'targetEntityType' => 'node',
    'bundle' => 'article',
    'mode' => 'default',
    'status' => TRUE,
  ]);
$form->setComponent('body', ['type' => 'text_textarea', 'weight' => 1])
  ->setComponent('field_tags', ['type' => 'entity_reference_autocomplete_tags', 'weight' => 2])
  ->save();
foreach (['default', 'teaser'] as $mode) {
  $view = EntityViewDisplay::load("node.article.$mode")
    ?? EntityViewDisplay::create([
      'targetEntityType' => 'node',
      'bundle' => 'article',
      'mode' => $mode,
      'status' => TRUE,
    ]);
  $view->setComponent('body', ['type' => 'text_default', 'label' => 'hidden', 'weight' => 1])
    ->setComponent('field_tags', ['type' => 'entity_reference_label', 'label' => 'above', 'weight' => 2])
    ->save();
}

// Sample content: six articles across two tags.
$tags = [];
foreach (['Drupal', 'Views'] as $name) {
  $found = \Drupal::entityTypeManager()->getStorage('taxonomy_term')
    ->loadByProperties(['name' => $name, 'vid' => 'tags']);
  $tags[$name] = $found ? reset($found) : Term::create(['name' => $name, 'vid' => 'tags']);
  if ($tags[$name]->isNew()) {
    $tags[$name]->save();
  }
}
if (!\Drupal::entityQuery('node')->accessCheck(FALSE)->condition('type', 'article')->count()->execute()) {
  foreach (range(1, 6) as $i) {
    Node::create([
      'type' => 'article',
      'title' => "Sample article $i",
      'uid' => 1,
      'status' => 1,
      'body' => ['value' => "<p>Body of sample article $i.</p>", 'format' => 'plain_text'],
      'field_tags' => [['target_id' => $tags[$i % 2 ? 'Drupal' : 'Views']->id()]],
      'created' => time() - $i * 3600,
    ])->save();
  }
}
echo "Article setup complete.\n";
