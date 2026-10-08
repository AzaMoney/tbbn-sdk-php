<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class OffersResource
{
    public function __construct(private readonly TbbnClient $client) {}

    /** The trade quote for these items — show it, then pass its fingerprint to create(). */
    public function quote(array $input): mixed
    {
        return $this->client->request('POST', '/v1/offers/quote', $input);
    }

    /** $input must include quoteFingerprint — the quote the sender was shown. */
    public function create(array $input): mixed
    {
        return $this->client->request('POST', '/v1/offers', $input);
    }

    public function list(string $sellerId, string $direction = 'all'): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery('/v1/offers', ['sellerId' => $sellerId, 'direction' => $direction]));
    }

    public function get(string $id): mixed
    {
        return $this->client->request('GET', "/v1/offers/{$id}");
    }

    /** An offer's quote (locked once accepted) and whether each party has confirmed it. */
    public function getQuote(string $id): mixed
    {
        return $this->client->request('GET', "/v1/offers/{$id}/quote");
    }

    public function acknowledgeQuote(string $id, string $quoteFingerprint, ?string $actingSellerId = null): mixed
    {
        return $this->client->request('POST', "/v1/offers/{$id}/quote/acknowledge", ['actingSellerId' => $actingSellerId, 'quoteFingerprint' => $quoteFingerprint]);
    }

    /** Accepting confirms the quote the recipient was shown (getQuote) and locks it. */
    public function accept(string $id, string $actingSellerId, string $quoteFingerprint): mixed
    {
        return $this->client->request('POST', "/v1/offers/{$id}/accept", ['actingSellerId' => $actingSellerId, 'quoteFingerprint' => $quoteFingerprint]);
    }

    public function reject(string $id, string $actingSellerId): mixed
    {
        return $this->client->request('POST', "/v1/offers/{$id}/reject", ['actingSellerId' => $actingSellerId]);
    }

    public function cancel(string $id, string $actingSellerId): mixed
    {
        return $this->client->request('POST', "/v1/offers/{$id}/cancel", ['actingSellerId' => $actingSellerId]);
    }

    public function counter(string $id, array $input): mixed
    {
        return $this->client->request('POST', "/v1/offers/{$id}/counter", $input);
    }
}
