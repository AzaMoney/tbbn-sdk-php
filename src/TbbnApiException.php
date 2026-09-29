<?php

declare(strict_types=1);

namespace Tbbn\Sdk;

/**
 * Thrown for any non-2xx API response, with the API's own code, message, request id and — for
 * some errors, such as a listing that matched the prohibited-items screen — structured details.
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
        public readonly mixed $details = null,
    ) {
        parent::__construct($message);
    }

    /**
     * Reads either error shape the API returns: `{ "error": { "code", "message" } }` or a
     * service's own `{ "code", "message", "details" }` / `{ "statusCode", "message", "error" }`,
     * where `message` may be a list of validation messages.
     */
    public static function fromBody(int $status, mixed $body): self
    {
        $root = is_array($body) ? $body : null;
        $envelope = ($root !== null && isset($root['error']) && is_array($root['error'])) ? $root['error'] : $root;

        $raw = $envelope['message'] ?? null;
        if (is_array($raw)) {
            $message = implode('; ', array_map('strval', $raw));
        } elseif (is_string($raw) && $raw !== '') {
            $message = $raw;
        } else {
            $message = "HTTP {$status}";
        }

        if (isset($envelope['code']) && is_string($envelope['code'])) {
            $code = $envelope['code'];
        } elseif ($root !== null && isset($root['error']) && is_string($root['error'])) {
            $code = implode('_', preg_split('/\s+/', strtoupper(trim($root['error']))));
        } else {
            $code = 'UNKNOWN_ERROR';
        }

        $requestId = isset($envelope['requestId']) && is_string($envelope['requestId']) ? $envelope['requestId'] : null;

        return new self($status, $code, $message, $requestId, $envelope['details'] ?? null);
    }
}
