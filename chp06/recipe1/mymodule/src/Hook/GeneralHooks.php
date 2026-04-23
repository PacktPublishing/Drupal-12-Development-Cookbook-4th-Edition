<?php

namespace Drupal\mymodule\Hook;

use Drupal\Core\Hook\Attribute\Hook;
use Drupal\Core\Messenger\MessengerInterface;

class GeneralHooks {

  public function __construct(
    protected readonly MessengerInterface $messenger,
  ) {}

  #[Hook('page_top')]
  public function pageTop(): void {
    $this->messenger->addStatus('Hello world!');
  }

}
