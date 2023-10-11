<?php
namespace MezzioRequestValidation\ErrorHandler;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Rakit\Validation\ErrorBag;
use Laminas\Diactoros\Response\JsonResponse;

class JsonValidationErrorHandler implements ValidationErrorHandler {

    public function handle(RequestInterface $request, ErrorBag $errorBag): ResponseInterface {
        return new JsonResponse(
            data: $errorBag->toArray(),
            status: 400
        );
    }
}
