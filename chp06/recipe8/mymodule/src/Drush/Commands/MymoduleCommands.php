<?php

namespace Drupal\mymodule\Drush\Commands;

use Drupal\Core\Extension\ExtensionPathResolver;
use Drush\Attributes as CLI;
use Drush\Commands\DrushCommands;

class MymoduleCommands extends DrushCommands {

  public function __construct(
    protected readonly ExtensionPathResolver $extensionPathResolver,
  ) {
    parent::__construct();
  }

  #[CLI\Command(
    name: 'mymodule:hello-world',
    aliases: ['mhw'],
  )]
  #[CLI\Usage(
    name: 'mymodule:hello-world',
    description: 'Display Drupal location.',
  )]
  public function helloWorld(): void {
    $this->io()->writeln('Hello world!');
    $drupal_root = $this->extensionPathResolver->getPath('core', 'core');
    $this->io()->writeln("Drupal core is located at: {$drupal_root}");
  }

  #[CLI\Command(name: 'mymodule:greet')]
  #[CLI\Argument(
    name: 'name',
    description: 'The name to greet.',
  )]
  #[CLI\Option(
    name: 'shout',
    description: 'Uppercase the greeting.',
  )]
  #[CLI\Usage(
    name: 'mymodule:greet World',
    description: 'Greet someone by name.',
  )]
  public function greet(string $name, array $options = ['shout' => FALSE]): void {
    $greeting = "Hello, {$name}!";
    if ($options['shout']) {
      $greeting = strtoupper($greeting);
    }
    $this->io()->writeln($greeting);
  }

}
