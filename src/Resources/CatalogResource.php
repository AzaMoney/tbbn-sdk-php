<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class CatalogResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function categories(): mixed
    {
        return $this->client->request('GET', '/v1/catalog/categories');
    }

    public function subcategories(string $category): mixed
    {
        return $this->client->request('GET', '/v1/catalog/categories/' . urlencode($category) . '/subcategories');
    }

    public function brands(?string $category = null, ?string $subcategory = null): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery('/v1/catalog/brands', ['category' => $category, 'subcategory' => $subcategory]));
    }
}
