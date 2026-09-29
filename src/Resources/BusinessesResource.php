<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

/**
 * Businesses — the account that owns locations (Branches), linked Merchants, billing and TBBN
 * Space hosting.
 */
final class BusinessesResource
{
    public function __construct(private readonly TbbnClient $client) {}

    /** `type` is INDIVIDUAL or REGISTERED (REGISTERED also needs `legalName`); only a verified REGISTERED Business can run a Merchant. */
    public function create(array $input): mixed
    {
        return $this->client->request('POST', '/v1/businesses', $input);
    }

    public function get(string $id): mixed
    {
        return $this->client->request('GET', "/v1/businesses/{$id}");
    }

    /** Businesses you own. */
    public function list(): mixed
    {
        return $this->client->request('GET', '/v1/businesses');
    }

    /** `stepUpToken` is required once the Business is verified. */
    public function update(string $id, array $patch, ?string $stepUpToken = null): mixed
    {
        return $this->client->request('PATCH', "/v1/businesses/{$id}", $patch, $stepUpToken !== null ? ['x-tbbn-step-up-token' => $stepUpToken] : []);
    }

    public function listUsers(string $businessId): mixed
    {
        return $this->client->request('GET', "/v1/businesses/{$businessId}/business-users");
    }
}
