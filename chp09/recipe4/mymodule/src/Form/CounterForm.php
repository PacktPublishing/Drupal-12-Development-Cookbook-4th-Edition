<?php

namespace Drupal\mymodule\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\MessageCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class CounterForm extends FormBase {

  public function getFormId(): string {
    return 'mymodule_counter_form';
  }

  public function buildForm(array $form,
    FormStateInterface $form_state): array {
    $count = $form_state->get('count') ?: 0;

    $form['count'] = [
      '#markup' => "<p>Total count: $count</p>",
      '#prefix' => '<div id="counter-wrapper">',
      '#suffix' => '</div>',
    ];
    $form['increment'] = [
      '#type' => 'submit',
      '#value' => 'Increment',
      '#submit' => [[$this, 'incrementSubmit']],
      '#ajax' => [
        'callback' => [$this, 'ajaxRefresh'],
        'wrapper' => 'counter-wrapper',
      ],
    ];
    $form['decrement'] = [
      '#type' => 'submit',
      '#value' => 'Decrement',
      '#submit' => [[$this, 'decrementSubmit']],
      '#ajax' => [
        'callback' => [$this, 'ajaxRefresh'],
        'wrapper' => 'counter-wrapper',
      ],
    ];
    $form['reset'] = [
      '#type' => 'submit',
      '#value' => 'Reset',
      '#submit' => [[$this, 'resetSubmit']],
      '#ajax' => [
        'callback' => [$this, 'ajaxResetResponse'],
      ],
    ];

    return $form;
  }

  public function ajaxRefresh(array $form,
    FormStateInterface $form_state): array {
    return $form['count'];
  }

  public function incrementSubmit(array &$form,
    FormStateInterface $form_state): void {
    $count = $form_state->get('count') ?: 0;
    $count++;
    $form_state->set('count', $count);
    $form_state->setRebuild();
  }

  public function decrementSubmit(array &$form,
    FormStateInterface $form_state): void {
    $count = $form_state->get('count') ?: 0;
    $count--;
    $form_state->set('count', $count);
    $form_state->setRebuild();
  }

  public function resetSubmit(array &$form,
    FormStateInterface $form_state): void {
    $form_state->set('count', 0);
    $form_state->setRebuild();
  }

  public function ajaxResetResponse(array $form,
    FormStateInterface $form_state): AjaxResponse {
    $response = new AjaxResponse();
    $response->addCommand(
      new ReplaceCommand('#counter-wrapper', $form['count'])
    );
    $response->addCommand(
      new MessageCommand('Counter has been reset to zero.')
    );
    return $response;
  }

  public function submitForm(array &$form,
    FormStateInterface $form_state): void {
  }

}
