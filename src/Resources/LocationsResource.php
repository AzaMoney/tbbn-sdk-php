<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

/**
 * A Business's locations, for a chain's own systems, with a Space API key.
 */
final class LocationsResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function list(): mixed
    {
        return $this->client->request('GET', "/v1/locations");
    }

    public function importBatch(array $input): mixed
    {
        return $this->client->request('POST', "/v1/locations/batch", $input);
    }

    public function get(string $id): mixed
    {
        return $this->client->request('GET', "/v1/locations/{$id}");
    }

    public function update(string $id, array $input): mixed
    {
        return $this->client->request('PATCH', "/v1/locations/{$id}", $input);
    }

    public function setStatus(string $id, array $input): mixed
    {
        return $this->client->request('PATCH', "/v1/locations/{$id}/status", $input);
    }

    public function createConnectionToken(string $id, array $input): mixed
    {
        return $this->client->request('POST', "/v1/locations/{$id}/connection_tokens", $input);
    }
}
