<?php

namespace Drupal\mymodule\Plugin\Validation\Constraint;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Validation\Attribute\Constraint;
use Symfony\Component\Validator\Constraint as SymfonyConstraint;

#[Constraint(
  id: 'ValidPhoneNumber',
  label: new TranslatableMarkup('Valid phone number'),
)]
class ValidPhoneNumber extends SymfonyConstraint {

  public string $message = 'The phone number "%value" is not valid. Use the format +1-555-555-5555.';

  public string $pattern = '/^\+?[1-9]\d{0,2}[-.\s]?\d{3}[-.\s]?\d{3}[-.\s]?\d{4}$/';

}
