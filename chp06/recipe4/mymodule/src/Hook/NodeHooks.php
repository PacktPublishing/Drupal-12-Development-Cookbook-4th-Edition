<?php

namespace Drupal\mymodule\Hook;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Hook\Attribute\Hook;
use Drupal\Core\Mail\MailManagerInterface;
use Drupal\node\NodeInterface;

class NodeHooks {

  public function __construct(
    private readonly ConfigFactoryInterface $configFactory,
    private readonly MailManagerInterface $mailManager,
  ) {}

  #[Hook('node_insert')]
  public function nodeInsert(NodeInterface $node): void {
    if ($node->isPublished()) {
      $this->sendNotification($node, 'node_published_insert');
    }
  }

  #[Hook('node_update')]
  public function nodeUpdate(NodeInterface $node): void {
    if ($node->isPublished()) {
      $original = $node->original;
      if (!$original->isPublished()) {
        $this->sendNotification($node, 'node_published_update');
      }
    }
  }

  #[Hook('mail')]
  public function mail(string $key, array &$message, array $params): void {
    $node = $params['node'];
    if ($key === 'node_published_insert') {
      $message['subject'] = 'Newly published node: ' . $node->label();
    }
    elseif ($key === 'node_published_update') {
      $message['subject'] = 'Existing node published: ' . $node->label();
    }
    else {
      return;
    }
    $message['body'][] = 'The following node has been published:';
    $message['body'][] = $node->label();
    $message['body'][] = $node->toUrl()->setAbsolute()->toString();
  }

  protected function sendNotification(NodeInterface $node, string $key): void {
    $site_mail = $this->configFactory->get('system.site')->get('mail');
    $this->mailManager->mail(
      'mymodule',
      $key,
      $site_mail,
      'en',
      ['node' => $node],
    );
  }

}
