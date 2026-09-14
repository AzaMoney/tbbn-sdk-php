<?php

declare(strict_types=1);

namespace Tbbn\Sdk;

/**
 * Thrown for any non-2xx API response. Mirrors the shared
 * `{ "error": { "code", "message", "requestId" } }` envelope documented in openapi.yaml's Error
 * schema.
 */
class TbbnApiException extends \Exception
{
    public function __construct(
        public readonly int $status,
        // Named errorCode, not code — \Exception already declares a non-readonly $code
        // property, and PHP doesn't allow a subclass to redeclare an inherited property as
        // readonly. Caught by this SDK's own CI (a real bug, not a hypothetical one).
        public readonly string $errorCode,
        string $message,
        public readonly ?string $requestId = null,
    ) {
        parent::__construct($message);
    }
}
