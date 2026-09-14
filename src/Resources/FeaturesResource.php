<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class FeaturesResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function upsert(array $input): mixed
    {
        return $this->client->request('POST', '/v1/features', $input);
    }

    public function list(?string $merchantId = null): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery('/v1/features', ['merchantId' => $merchantId]));
    }

    public function check(string $key, ?string $merchantId = null): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery("/v1/features/{$key}/check", ['merchantId' => $merchantId]));
    }
}
