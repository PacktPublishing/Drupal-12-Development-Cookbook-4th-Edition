<?php

declare(strict_types=1);

namespace Drupal\Tests\chapter15\Unit;

use Drupal\Tests\UnitTestCase;
use Drupal\chapter15\CamelCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;

/**
 * Tests the CamelCase utility class.
 */
#[Group('chapter15')]
#[CoversClass(CamelCase::class)]
class CamelCaseTest extends UnitTestCase {

  public static function exampleStrings(): array {
    return [
      ['button_color', 'buttonColor'],
      ['snake_case_example', 'snakeCaseExample'],
      ['ALL_CAPS_LOCK', 'allCapsLock'],
      ['foo-bar', 'fooBar'],
      ['This is a basic string', 'thisIsABasicString'],
    ];
  }

  #[DataProvider('exampleStrings')]
  public function testCamelCaseConversion(string $input, string $expected): void {
    $output = CamelCase::convert($input);
    $this->assertEquals($expected, $output);
  }

}
