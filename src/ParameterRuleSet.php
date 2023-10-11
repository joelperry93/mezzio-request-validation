<?php
namespace MezzioRequestValidation;

/**
 * Defines the allowed values of request parameters
 */
interface ParameterRuleSet {

    /**
     * [
     *     'age' => 'number|min:0',
     *     'email' => 'required|email'
     * ]
     *
     * See full list of rules here: https://github.com/rakit/validation
     *
     * @return string[]
     */
    public function getParameterRules(): array;
}
