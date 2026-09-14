<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class SandboxResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function provisionMerchant(?string $displayName = null): mixed
    {
        return $this->client->request('POST', '/v1/sandbox/merchants', ['displayName' => $displayName]);
    }

    public function fixtures(): mixed
    {
        return $this->client->request('GET', '/v1/sandbox/fixtures');
    }
}
