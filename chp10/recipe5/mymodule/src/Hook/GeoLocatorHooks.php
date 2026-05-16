<?php

namespace Drupal\mymodule\Hook;

use Drupal\Core\Hook\Attribute\Hook;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\mymodule\GeoLocatorManager;
use Symfony\Component\HttpFoundation\RequestStack;

class GeoLocatorHooks {

  public function __construct(
    private readonly GeoLocatorManager $geoLocatorManager,
    private readonly MessengerInterface $messenger,
    private readonly RequestStack $requestStack,
  ) {}

  #[Hook('page_top')]
  public function pageTop(array &$page_top): void {
    $request = $this->requestStack->getCurrentRequest();
    foreach ($this->geoLocatorManager->getDefinitions() as $plugin_id => $definition) {
      $instance = $this->geoLocatorManager->createInstance($plugin_id);
      $country_code = $instance->geolocate($request);
      if ($country_code) {
        // Add a status message.
        $this->messenger->addStatus("Country: $country_code");
        // Optionally add output to the page_top render array.
        $page_top['geolocator'] = [
          '#markup' => "Country: $country_code",
        ];
        break;
      }
    }
  }

}
