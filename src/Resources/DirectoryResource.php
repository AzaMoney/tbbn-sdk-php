<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class DirectoryResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function list(array $query = []): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery('/v1/directory/listings', $query));
    }

    public function get(string $id): mixed
    {
        return $this->client->request('GET', "/v1/directory/listings/{$id}");
    }
}
