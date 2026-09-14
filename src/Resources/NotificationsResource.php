<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class NotificationsResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function list(string $userId): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery('/v1/notifications', ['userId' => $userId]));
    }

    public function markRead(string $id): mixed
    {
        return $this->client->request('POST', "/v1/notifications/{$id}/read");
    }
}
