<?php

namespace Drupal\mymodule\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint as SymfonyConstraint;
use Symfony\Component\Validator\ConstraintValidator;

class ValidPhoneNumberValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate(mixed $value, SymfonyConstraint $constraint): void {
    if (empty($value)) {
      return;
    }
    $phone = is_string($value) ? $value : $value->value;
    if (!preg_match($constraint->pattern, $phone)) {
      $this->context->addViolation(
        $constraint->message,
        ['%value' => $phone],
      );
    }
  }

}
