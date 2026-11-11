<?php

namespace Drupal\mymodule\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class ConditionalForm extends FormBase {

  public function getFormId(): string {
    return 'mymodule_conditional_form';
  }

  public function buildForm(array $form,
    FormStateInterface $form_state): array {
    $form['contact_method'] = [
      '#type' => 'select',
      '#title' => 'Preferred contact method',
      '#options' => [
        '' => '- Select -',
        'email' => 'Email',
        'phone' => 'Phone',
        'mail' => 'Mail',
      ],
    ];
    $form['email_address'] = [
      '#type' => 'email',
      '#title' => 'Email address',
      '#states' => [
        'visible' => [
          ':input[name="contact_method"]' => ['value' => 'email'],
        ],
        'required' => [
          ':input[name="contact_method"]' => ['value' => 'email'],
        ],
      ],
    ];
    $form['phone_number'] = [
      '#type' => 'tel',
      '#title' => 'Phone number',
      '#states' => [
        'visible' => [
          ':input[name="contact_method"]' => ['value' => 'phone'],
        ],
        'required' => [
          ':input[name="contact_method"]' => ['value' => 'phone'],
        ],
      ],
    ];
    $form['mailing_address'] = [
      '#type' => 'textarea',
      '#title' => 'Mailing address',
      '#rows' => 3,
      '#states' => [
        'visible' => [
          ':input[name="contact_method"]' => ['value' => 'mail'],
        ],
      ],
    ];
    $form['show_additional'] = [
      '#type' => 'checkbox',
      '#title' => 'Show additional information',
    ];
    $form['additional_info'] = [
      '#type' => 'details',
      '#title' => 'Additional information',
      '#states' => [
        'expanded' => [
          ':input[name="show_additional"]' => ['checked' => TRUE],
        ],
      ],
    ];
    $form['additional_info']['notes'] = [
      '#type' => 'textarea',
      '#title' => 'Notes',
      '#rows' => 3,
    ];
    $form['approval'] = [
      '#type' => 'checkbox',
      '#title' => 'I acknowledge that my information is correct',
      '#required' => TRUE,
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => 'Submit',
      '#states' => [
        'disabled' => [
          ':input[name="approval"]' => ['checked' => FALSE],
        ],
      ],
    ];

    return $form;
  }

  public function submitForm(array &$form,
    FormStateInterface $form_state): void {
    $this->messenger()->addStatus('Form submitted successfully.');
  }

}
