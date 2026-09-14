<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class AnalyticsResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function overview(array $query = []): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery('/v1/analytics/overview', $query));
    }
}
