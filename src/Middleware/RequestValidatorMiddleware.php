<?php
namespace MezzioRequestValidation\Middleware;

use Mezzio\Router\RouteResult;
use MezzioRequestValidation\ErrorHandler\ValidationErrorHandler;
use MezzioRequestValidation\ParameterRuleSet;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Rakit\Validation\Validator;

/**
 * Request validation on PSR-15 request handlers.
 *
 * Before execution of a matched RequestHandlerInterface, we will see if it also implements our own RequestDescription
 * interface, which defines constraints on parameters. We then check that the constraints are all met and return a 400
 * if any of them fail.
 */
final readonly class RequestValidatorMiddleware implements MiddlewareInterface {

    public function __construct(
        private ContainerInterface $container,
        private Validator $requestValidator,
        private ValidationErrorHandler $validationErrorHandler
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        $matchedRoute = $request->getAttribute(RouteResult::class)->getMatchedRoute();

        if ($matchedRoute !== false) {
            $requestHandler = $this->container->get($matchedRoute->getMiddleware()->middlewareName);

            if ($requestHandler instanceof ParameterRuleSet) {
                $validationResult = $this->requestValidator->validate(
                    array_merge($request->getQueryParams(), $request->getParsedBody()),
                    $requestHandler->getParameterRules()
                );

                if (!$validationResult->passes()) {
                    return $this->validationErrorHandler->handle($request, $validationResult->errors());
                }
            }
        }

        return $handler->handle($request);
    }
}
