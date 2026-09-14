<?php

declare(strict_types=1);

namespace Tbbn\Sdk;

use Tbbn\Sdk\Resources\AnalyticsResource;
use Tbbn\Sdk\Resources\ApiKeysResource;
use Tbbn\Sdk\Resources\AuditLogsResource;
use Tbbn\Sdk\Resources\AuthResource;
use Tbbn\Sdk\Resources\BillingResource;
use Tbbn\Sdk\Resources\CatalogResource;
use Tbbn\Sdk\Resources\CheckoutResource;
use Tbbn\Sdk\Resources\CurrencyResource;
use Tbbn\Sdk\Resources\DirectoryResource;
use Tbbn\Sdk\Resources\FeaturesResource;
use Tbbn\Sdk\Resources\FraudResource;
use Tbbn\Sdk\Resources\LocalizationResource;
use Tbbn\Sdk\Resources\ListingsResource;
use Tbbn\Sdk\Resources\MatchingResource;
use Tbbn\Sdk\Resources\MediaResource;
use Tbbn\Sdk\Resources\ModerationResource;
use Tbbn\Sdk\Resources\NotificationsResource;
use Tbbn\Sdk\Resources\OffersResource;
use Tbbn\Sdk\Resources\MerchantsResource;
use Tbbn\Sdk\Resources\RecommendationsResource;
use Tbbn\Sdk\Resources\ReputationResource;
use Tbbn\Sdk\Resources\ReservationsResource;
use Tbbn\Sdk\Resources\SandboxResource;
use Tbbn\Sdk\Resources\SearchResource;
use Tbbn\Sdk\Resources\SellersResource;
use Tbbn\Sdk\Resources\TradeEngineResource;
use Tbbn\Sdk\Resources\TradeSessionsResource;
use Tbbn\Sdk\Resources\WebhooksResource;

/**
 * Status: WORKING (source only) — untested. No PHP toolchain exists in the environment this was
 * written in, so this code has not been run. Written as a faithful translation of
 * packages/sdk-js/src/client.ts's full method surface (all 27 resource groups, Phase 0-13).
 * Review before shipping to production.
 *
 * Client over the TBBN Platform API. Uses PHP's built-in curl extension — no Guzzle dependency,
 * so this SDK stays usable in any PHP 8.1+ project without a hard third-party HTTP client
 * requirement.
 */
final class TbbnClient
{
    public readonly AuthResource $auth;
    public readonly MerchantsResource $merchants;
    public readonly ApiKeysResource $apiKeys;
    public readonly SellersResource $sellers;
    public readonly ListingsResource $listings;
    public readonly CatalogResource $catalog;
    public readonly MediaResource $media;
    public readonly DirectoryResource $directory;
    public readonly SearchResource $search;
    public readonly TradeEngineResource $tradeEngine;
    public readonly CurrencyResource $currency;
    public readonly LocalizationResource $localization;
    public readonly MatchingResource $matching;
    public readonly RecommendationsResource $recommendations;
    public readonly OffersResource $offers;
    public readonly ReservationsResource $reservations;
    public readonly TradeSessionsResource $tradeSessions;
    public readonly CheckoutResource $checkout;
    public readonly BillingResource $billing;
    public readonly NotificationsResource $notifications;
    public readonly WebhooksResource $webhooks;
    public readonly AuditLogsResource $auditLogs;
    public readonly ModerationResource $moderation;
    public readonly FraudResource $fraud;
    public readonly ReputationResource $reputation;
    public readonly AnalyticsResource $analytics;
    public readonly FeaturesResource $features;
    public readonly SandboxResource $sandbox;

    public function __construct(
        private readonly string $baseUrl,
        private readonly ?string $apiKey = null,
        private readonly ?string $accessToken = null,
    ) {
        $this->auth = new AuthResource($this);
        $this->merchants = new MerchantsResource($this);
        $this->apiKeys = new ApiKeysResource($this);
        $this->sellers = new SellersResource($this);
        $this->listings = new ListingsResource($this);
        $this->catalog = new CatalogResource($this);
        $this->media = new MediaResource($this);
        $this->directory = new DirectoryResource($this);
        $this->search = new SearchResource($this);
        $this->tradeEngine = new TradeEngineResource($this);
        $this->currency = new CurrencyResource($this);
        $this->localization = new LocalizationResource($this);
        $this->matching = new MatchingResource($this);
        $this->recommendations = new RecommendationsResource($this);
        $this->offers = new OffersResource($this);
        $this->reservations = new ReservationsResource($this);
        $this->tradeSessions = new TradeSessionsResource($this);
        $this->checkout = new CheckoutResource($this);
        $this->billing = new BillingResource($this);
        $this->notifications = new NotificationsResource($this);
        $this->webhooks = new WebhooksResource($this);
        $this->auditLogs = new AuditLogsResource($this);
        $this->moderation = new ModerationResource($this);
        $this->fraud = new FraudResource($this);
        $this->reputation = new ReputationResource($this);
        $this->analytics = new AnalyticsResource($this);
        $this->features = new FeaturesResource($this);
        $this->sandbox = new SandboxResource($this);
    }

    /**
     * Issues an HTTP request against the TBBN API and decodes the JSON response. Throws
     * TbbnApiException on any non-2xx status. Internal — resource classes call this; not
     * intended for direct use.
     *
     * @param array<string, mixed>|null $body
     * @param array<string, string> $extraHeaders
     */
    public function request(string $method, string $path, ?array $body = null, array $extraHeaders = []): mixed
    {
        $headers = ['Content-Type: application/json'];
        $token = $this->apiKey ?? $this->accessToken;
        if ($token !== null) {
            $headers[] = "Authorization: Bearer {$token}";
        }
        foreach ($extraHeaders as $key => $value) {
            $headers[] = "{$key}: {$value}";
        }

        $ch = curl_init("{$this->baseUrl}{$path}");
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $body !== null ? json_encode($body) : null,
        ]);

        $responseBody = curl_exec($ch);
        if ($responseBody === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new TbbnApiException(0, 'NETWORK_ERROR', $error);
        }

        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($status === 204) {
            return null;
        }

        $data = json_decode($responseBody, true) ?? [];

        if ($status < 200 || $status >= 300) {
            $error = $data['error'] ?? [];
            throw new TbbnApiException(
                $status,
                $error['code'] ?? 'UNKNOWN_ERROR',
                $error['message'] ?? 'Unknown error',
                $error['requestId'] ?? null,
            );
        }

        return $data;
    }

    /** Builds the Idempotency-Key header, matching sdk-js's idempotencyHeader() helper. */
    public static function idempotencyHeader(?string $key): array
    {
        return $key !== null ? ['Idempotency-Key' => $key] : [];
    }

    /** Appends non-null query parameters to a path, matching sdk-js's withQuery() helper. */
    public static function withQuery(string $path, array $query): string
    {
        $params = array_filter($query, fn ($v) => $v !== null);
        if (empty($params)) {
            return $path;
        }
        return $path . '?' . http_build_query($params);
    }
}
