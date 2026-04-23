<?php

use \Drupal\contact\Entity\ContactForm;

/**
 * @file
 * Post-update hooks for My Module.
 */

/**
 * Update "Contact Us" form to have a reply message.
 */
function mymodule_post_update_change_contactus_reply(): void {
  $contact_form = ContactForm::load('contactus');
  if ($contact_form) {
    $contact_form->setReply(t('Thank you for contacting us, we will reply shortly'));
    $contact_form->save();
  }
}
