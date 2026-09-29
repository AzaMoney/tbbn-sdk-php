<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

/**
 * A Business's locations.
 */
final class BranchesResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function create(string $businessId, array $input): mixed
    {
        return $this->client->request('POST', "/v1/businesses/{$businessId}/branches", $input);
    }

    public function list(string $businessId): mixed
    {
        return $this->client->request('GET', "/v1/businesses/{$businessId}/branches");
    }

    public function update(string $id, array $patch): mixed
    {
        return $this->client->request('PATCH', "/v1/branches/{$id}", $patch);
    }

    public function delete(string $id): mixed
    {
        return $this->client->request('DELETE', "/v1/branches/{$id}");
    }

    /** `spaceStatus` is NOT_ENABLED or SPACE_ENABLED. */
    public function setSpaceStatus(string $id, string $spaceStatus): mixed
    {
        return $this->client->request('POST', "/v1/branches/{$id}/space-status", ['spaceStatus' => $spaceStatus]);
    }

    /** Creates or updates many locations at once, keyed by each one's `externalLocationId`. */
    public function bulkUpsert(string $businessId, array $locations): mixed
    {
        return $this->client->request('POST', "/v1/businesses/{$businessId}/branches/bulk", ['locations' => $locations]);
    }
}
