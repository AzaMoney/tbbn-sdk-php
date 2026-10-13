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

    /** A member's public storefront: their profile and their own public listings. */
    public function storefront(string $slug, int $page = 1): mixed
    {
        return $this->client->request('GET', "/v1/directory/storefronts/" . rawurlencode($slug) . "?page={$page}");
    }
}
