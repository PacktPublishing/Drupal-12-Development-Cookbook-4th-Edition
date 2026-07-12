<?php

declare(strict_types=1);

namespace Drupal\ai_tldr\Plugin\Block;

use Drupal\ai\AiProviderPluginManager;
use Drupal\ai\OperationType\Chat\ChatInput;
use Drupal\ai\OperationType\Chat\ChatMessage;
use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

/**
 * Provides an AI-generated one-sentence summary of the current node.
 */
#[Block(
  id: 'ai_tldr',
  admin_label: new TranslatableMarkup('AI TL;DR'),
  category: new TranslatableMarkup('Content'),
)]
final class AiTldrBlock extends BlockBase implements ContainerFactoryPluginInterface {

  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    #[Autowire(service: 'ai.provider')]
    private readonly AiProviderPluginManager $aiProvider,
    private readonly RouteMatchInterface $routeMatch,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $node = $this->routeMatch->getParameter('node');
    if (!$node instanceof NodeInterface || !$node->hasField('body')) {
      return [];
    }
    $body = $node->get('body')->value ?? '';
    if ($body === '') {
      return [];
    }

    $defaults = $this->aiProvider->getDefaultProviderForOperationType('chat');
    if (empty($defaults['provider_id']) || empty($defaults['model_id'])) {
      return ['#markup' => $this->t('No default chat provider configured.')];
    }

    $provider = $this->aiProvider->createInstance($defaults['provider_id']);
    $input = new ChatInput([
      new ChatMessage('user', "Summarize this article in one sentence:\n\n" . strip_tags($body)),
    ]);
    $input->setSystemPrompt('You write concise one-sentence summaries. Reply with only the summary, no preamble.');

    try {
      $response = $provider->chat($input, $defaults['model_id']);
      $summary = $response->getNormalized()->getText();
    }
    catch (\Throwable $e) {
      return ['#markup' => $this->t('AI summary unavailable.')];
    }

    return [
      '#theme' => 'item_list',
      '#title' => $this->t('TL;DR'),
      '#items' => [$summary],
      '#cache' => [
        'tags' => $node->getCacheTags(),
        'contexts' => ['route'],
        'max-age' => 3600,
      ],
    ];
  }

}
