<?php

namespace Drupal\mymodule\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class CompanyForm extends ConfigFormBase {

  public function getFormId(): string {
    return 'company_form';
  }

  protected function getEditableConfigNames(): array {
    return ['mymodule.company_settings'];
  }

  public function buildForm(array $form,
    FormStateInterface $form_state): array {
    $company_settings = $this->config('mymodule.company_settings');

    $form['company_name'] = [
      '#type' => 'textfield',
      '#title' => 'Company name',
      '#required' => TRUE,
      '#default_value' => $company_settings->get('company_name'),
      '#description' => 'Enter the official company name (2-255 characters).',
      '#maxlength' => 255,
      '#minlength' => 2,
    ];
    $form['company_telephone'] = [
      '#type' => 'tel',
      '#title' => 'Company telephone',
      '#required' => TRUE,
      '#pattern' => '^[0-9\-\+\s\(\)]*$',
      '#default_value' => $company_settings->get('company_telephone'),
      '#description' => 'Enter a contact phone number.',
    ];
    $form['company_type'] = [
      '#type' => 'select',
      '#title' => 'Company type',
      '#options' => [
        '' => '- Select -',
        'llc' => 'LLC',
        'corporation' => 'Corporation',
        'partnership' => 'Partnership',
        'sole_proprietorship' => 'Sole Proprietorship',
        'nonprofit' => 'Nonprofit',
      ],
      '#default_value' => $company_settings->get('company_type'),
      '#description' => 'Select the type of business entity.',
    ];
    $form['company_description'] = [
      '#type' => 'textarea',
      '#title' => 'Company description',
      '#default_value' => $company_settings->get('company_description'),
      '#description' => 'Provide a brief description of the company.',
      '#rows' => 5,
    ];
    $form['company_email'] = [
      '#type' => 'email',
      '#title' => 'Company email',
      '#default_value' => $company_settings->get('company_email'),
      '#description' => 'Enter a valid company email address.',
    ];
    $form['year_founded'] = [
      '#type' => 'number',
      '#title' => 'Year founded',
      '#default_value' => $company_settings->get('year_founded'),
      '#description' => 'The year the company was founded.',
      '#min' => 1800,
      '#max' => 2030,
    ];
    $form['active'] = [
      '#type' => 'checkbox',
      '#title' => 'Company is active',
      '#default_value' => $company_settings->get('active'),
      '#description' => 'Check this box if the company is currently active.',
    ];

    return parent::buildForm($form, $form_state);
  }

  public function validateForm(array &$form,
    FormStateInterface $form_state): void {
    $company_name = $form_state->getValue('company_name');
    if (str_contains($company_name, 'foo')) {
      $form_state->setErrorByName(
        'company_name',
        'Company name cannot contain the word "foo".'
      );
    }

    $telephone = $form_state->getValue('company_telephone');
    if (!empty($telephone) && strlen($telephone) < 7) {
      $form_state->setErrorByName(
        'company_telephone',
        'Telephone number must be at least 7 characters long.'
      );
    }

    $email = $form_state->getValue('company_email');
    if (!empty($email) && !str_ends_with($email, '.com')
      && !str_ends_with($email, '.org')) {
      $form_state->setErrorByName(
        'company_email',
        'Email must use a .com or .org domain.'
      );
    }

    $year = $form_state->getValue('year_founded');
    if (!empty($year) && $year > (int) date('Y')) {
      $form_state->setErrorByName(
        'year_founded',
        'Year founded cannot be in the future.'
      );
    }
  }

  public function submitForm(array &$form,
    FormStateInterface $form_state): void {
    parent::submitForm($form, $form_state);

    $this->config('mymodule.company_settings')
      ->set('company_name', $form_state->getValue('company_name'))
      ->set('company_telephone',
        $form_state->getValue('company_telephone'))
      ->set('company_type', $form_state->getValue('company_type'))
      ->set('company_description',
        $form_state->getValue('company_description'))
      ->set('company_email', $form_state->getValue('company_email'))
      ->set('year_founded', $form_state->getValue('year_founded'))
      ->set('active', $form_state->getValue('active'))
      ->save();
  }

}
