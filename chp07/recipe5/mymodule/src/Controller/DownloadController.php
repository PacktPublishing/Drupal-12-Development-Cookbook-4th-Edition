<?php

namespace Drupal\mymodule\Controller;

use Drupal\Core\File\MimeType\MimeTypeGuesserInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadController {

  /**
   * Constructs a DownloadController object.
   *
   * @param \Drupal\Core\File\MimeType\MimeTypeGuesserInterface $mimeTypeGuesser
   *   The MIME type guesser.
   */
  public function __construct(
    protected readonly MimeTypeGuesserInterface $mimeTypeGuesser,
  ) {}

  /**
   * Downloads a file.
   *
   * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
   *   The file response.
   */
  public function page(): BinaryFileResponse {
    // File paths are relative to the document root (web.)
    $file_path = 'modules/custom/mymodule/dummy.pdf';
    $mime_type = $this->mimeTypeGuesser->guessMimeType($file_path);

    $response = new BinaryFileResponse($file_path);
    $response->headers->set('Content-Type', $mime_type);
    $response->setContentDisposition('attachment', basename($file_path));
    return $response;
  }

}
