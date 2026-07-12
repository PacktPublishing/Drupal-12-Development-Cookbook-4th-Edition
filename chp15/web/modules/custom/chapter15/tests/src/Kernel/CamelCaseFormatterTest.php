<?php

declare(strict_types=1);

namespace Drupal\Tests\chapter15\Kernel;

use Drupal\Core\Entity\Entity\EntityViewDisplay;
use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\KernelTests\KernelTestBase;
use Drupal\Tests\node\Traits\ContentTypeCreationTrait;
use Drupal\Tests\node\Traits\NodeCreationTrait;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;

#[Group('chapter15')]
#[RunTestsInSeparateProcesses]
class CamelCaseFormatterTest extends KernelTestBase {

  use NodeCreationTrait;
  use ContentTypeCreationTrait;

  protected $strictConfigSchema = FALSE;

  protected static $modules = [
    'field',
    'text',
    'node',
    'system',
    'filter',
    'user',
    'chapter15',
  ];

  protected function setUp(): void {
    parent::setUp();
    $this->installEntitySchema('node');
    $this->installEntitySchema('user');
    $this->installConfig(['field', 'node', 'filter', 'system']);
    // node_access is registered automatically in modern Drupal; skip the explicit installSchema call.

    $this->createContentType(['type' => 'page']);

    FieldStorageConfig::create([
      'field_name' => 'field_chapter15_test',
      'entity_type' => 'node',
      'type' => 'string',
      'cardinality' => 1,
      'settings' => ['max_length' => 255, 'case_sensitive' => FALSE, 'is_ascii' => FALSE],
    ])->save();

    FieldConfig::create([
      'field_name' => 'field_chapter15_test',
      'field_type' => 'string',
      'entity_type' => 'node',
      'label' => 'Chapter15 Camel Case Field',
      'bundle' => 'page',
      'settings' => ['link_to_entity' => FALSE],
    ])->save();

    $entity_display = EntityViewDisplay::load('node.page.default');
    $entity_display->setComponent('field_chapter15_test', [
      'type' => 'camel_case',
      'region' => 'content',
      'settings' => [],
      'label' => 'hidden',
      'third_party_settings' => [],
    ]);
    $entity_display->save();
  }

  public function testFieldIsFormatted(): void {
    $node = $this->createNode([
      'type' => 'page',
      'field_chapter15_test' => 'A user entered string',
    ]);
    $build = $node->field_chapter15_test->view('default');
    $this->assertSame('aUserEnteredString', $build[0]['#context']['value']);
  }

}
