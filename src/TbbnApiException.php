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
        public readonly string $code,
        string $message,
        public readonly ?string $requestId = null,
    ) {
        parent::__construct($message);
    }
}
