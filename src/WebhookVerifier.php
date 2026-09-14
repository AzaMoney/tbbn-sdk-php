<?php

declare(strict_types=1);

namespace Tbbn\Sdk;

/**
 * Verifies the X-TBBN-Signature header format `t=<unix_ts>,v1=<hmac_sha256_hex>`. See
 * docs/architecture/event-webhook-catalog.md. Ported faithfully from
 * packages/sdk-js/src/webhooks.ts — same algorithm, same 5-minute replay window.
 */
final class WebhookVerifier
{
    private const REPLAY_WINDOW_SECONDS = 5 * 60;

    public static function verify(string $rawBody, string $signatureHeader, string $signingSecret, ?int $now = null): bool
    {
        $now ??= time();

        $parts = [];
        foreach (explode(',', $signatureHeader) as $pair) {
            [$key, $value] = array_pad(explode('=', $pair, 2), 2, null);
            if ($key !== null && $value !== null) {
                $parts[$key] = $value;
            }
        }

        $timestamp = isset($parts['t']) ? (int) $parts['t'] : null;
        $signature = $parts['v1'] ?? null;
        if ($timestamp === null || $signature === null) {
            return false;
        }
        if (abs($now - $timestamp) > self::REPLAY_WINDOW_SECONDS) {
            return false;
        }

        $expected = hash_hmac('sha256', "{$timestamp}.{$rawBody}", $signingSecret);
        return hash_equals($expected, $signature);
    }
}
