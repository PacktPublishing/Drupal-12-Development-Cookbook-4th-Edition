<?php

declare(strict_types=1);

namespace Drupal\Tests\chapter15\Functional;

use Drupal\Core\Entity\Entity\EntityFormDisplay;
use Drupal\Core\Entity\Entity\EntityViewDisplay;
use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\Tests\BrowserTestBase;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;

/**
 * Tests the CamelCase field formatter display in the browser.
 */
#[Group('chapter15')]
#[RunTestsInSeparateProcesses]
class CamelCaseFormatterDisplayTest extends BrowserTestBase {

  protected $strictConfigSchema = FALSE;
  protected $defaultTheme = 'stark';

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

    $this->createContentType(['type' => 'page']);

    FieldStorageConfig::create([
      'field_name' => 'field_chapter15_test',
      'entity_type' => 'node',
      'type' => 'string',
      'cardinality' => 1,
      'locked' => FALSE,
      'indexes' => [],
      'settings' => ['max_length' => 255, 'case_sensitive' => FALSE, 'is_ascii' => FALSE],
    ])->save();

    FieldConfig::create([
      'field_name' => 'field_chapter15_test',
      'field_type' => 'string',
      'entity_type' => 'node',
      'label' => 'Chapter15 Camel Case Field',
      'bundle' => 'page',
      'description' => '',
      'required' => FALSE,
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

    // Add the field to the node edit form so it can be submitted.
    $form_display = EntityFormDisplay::load('node.page.default');
    $form_display->setComponent('field_chapter15_test', [
      'type' => 'string_textfield',
      'region' => 'content',
    ]);
    $form_display->save();
  }

  public function testUserCanSeeFormattedString(): void {
    $this->drupalCreateNode([
      'type' => 'page',
      'field_chapter15_test' => 'A user entered string',
    ]);

    $this->drupalGet('/node/1');
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->pageTextContains('aUserEnteredString');
  }

  public function testAuthenticatedUserCanSeeFormattedString(): void {
    $user = $this->drupalCreateUser(['access content', 'create page content']);
    $this->drupalLogin($user);

    $this->drupalCreateNode([
      'type' => 'page',
      'title' => 'Test Page',
      'field_chapter15_test' => 'hello_world_example',
      'uid' => $user->id(),
    ]);

    $this->drupalGet('/node/1');
    $this->assertSession()->pageTextContains('helloWorldExample');
    $this->assertSession()->pageTextContains('Test Page');
  }

  public function testFieldValueCanBeUpdated(): void {
    $admin = $this->drupalCreateUser([
      'access content',
      'create page content',
      'edit any page content',
    ]);
    $this->drupalLogin($admin);

    $node = $this->drupalCreateNode([
      'type' => 'page',
      'title' => 'Form Test Page',
      'field_chapter15_test' => 'initial_value',
    ]);

    $this->drupalGet('/node/' . $node->id() . '/edit');
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->fieldValueEquals('field_chapter15_test[0][value]', 'initial_value');

    $this->submitForm([
      'field_chapter15_test[0][value]' => 'updated_string_value',
    ], 'Save');
    $this->assertSession()->pageTextContains('updatedStringValue');
  }



}
