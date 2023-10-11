# Installation
1. Add MezzioRequestValidation\Middleware\RequestValidatorMiddleware to your pipeline.
2. Define an implementation of MezzioRequestValidation\ErrorHandler\ValidationErrorHandler in your container configuration. JsonValidationErrorHandler is provided as a simple option.
3. implement the ParameterRuleSet interface on a request handler using the options from https://github.com/rakit/validation


# Example
```
<?php
...
class IndexRequestHandler implements RequestHandlerInterface, ParameterRuleSet
{
    public function getParameterRules(): array {
        return [
            'email' => 'required|email',
            'age'   => 'numeric'
        ];
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        ...
    }
}
```
