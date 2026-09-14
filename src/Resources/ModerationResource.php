<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class ModerationResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function listFlags(array $query = []): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery('/v1/moderation/flags', $query));
    }

    public function getFlag(string $id): mixed
    {
        return $this->client->request('GET', "/v1/moderation/flags/{$id}");
    }

    public function reviewFlag(string $id, string $reviewedBy, string $decision): mixed
    {
        return $this->client->request('POST', "/v1/moderation/flags/{$id}/review", ['reviewedBy' => $reviewedBy, 'decision' => $decision]);
    }
}
