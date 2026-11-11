<?php

namespace Drupal\mymodule\Hook;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Hook\Attribute\Hook;

class MyModuleFormHooks {

  public function __construct(
    protected readonly ConfigFactoryInterface $configFactory,
  ) {}

  #[Hook('form_system_site_information_settings_alter')]
  public function alterSiteInformationForm(array &$form,
    FormStateInterface $form_state): void {
    $form['site_information']['site_phone'] = [
      '#type' => 'tel',
      '#title' => 'Site phone',
      '#default_value' => $this->configFactory
        ->get('mymodule.settings')
        ->get('site_phone'),
      '#description' => 'The main phone number for the site.',
    ];

    $form['#submit'][] = [$this, 'saveSitePhone'];
  }

  public function saveSitePhone(array &$form,
    FormStateInterface $form_state): void {
    $this->configFactory->getEditable('mymodule.settings')
      ->set('site_phone', $form_state->getValue('site_phone'))
      ->save();
  }

}
