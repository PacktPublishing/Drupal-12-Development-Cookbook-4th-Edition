<?php

namespace Drupal\mymodule\Controller;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadController {

  /**
   * Downloads a file.
   *
   * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
   *   The file response.
   */
  public function page(): BinaryFileResponse {
    // File paths are relative to the document root (web.)
    $file_path = 'modules/custom/mymodule/dummy.pdf';

    /** @var \Drupal\Core\File\MimeType\MimeTypeGuesser $guesser */
    $guesser = \Drupal::service('file.mime_type.guesser');
    $mime_type = $guesser->guessMimeType($file_path);

    $response = new BinaryFileResponse($file_path);
    $response->headers->set('Content-Type', $mime_type);
    $response->setContentDisposition('attachment', basename($file_path));
    return $response;
  }

}
