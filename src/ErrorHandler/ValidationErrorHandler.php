<?php
namespace MezzioRequestValidation\ErrorHandler;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Rakit\Validation\ErrorBag;

interface ValidationErrorHandler {

    public function handle(RequestInterface $request, ErrorBag $errorBag): ResponseInterface;
}
