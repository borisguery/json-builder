<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

if (!function_exists('json_last_error_msg')) {
    /**
     * @see https://github.com/php/php-src/blob/php-5.6.5RC1/ext/json/json.c
     **/
    function json_last_error_msg() {
        $errors = [
            JSON_ERROR_NONE           => "No error",
            JSON_ERROR_DEPTH          => "Maximum stack depth exceeded",
            JSON_ERROR_STATE_MISMATCH => "State mismatch (invalid or malformed JSON)",
            JSON_ERROR_CTRL_CHAR      => "Control character error, possibly incorrectly encoded",
            JSON_ERROR_SYNTAX         => 'Syntax error',
            JSON_ERROR_UTF8           => "Malformed UTF-8 characters, possibly incorrectly encoded",
        ];

        $jsonErrorCode = json_last_error();

        return array_key_exists($jsonErrorCode, $errors)
            ? $errors[$jsonErrorCode]
            : sprintf("Unknown error code: %d", $jsonErrorCode)
        ;
    }
}
