<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class SandboxResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function fixtures(): mixed
    {
        return $this->client->request('GET', '/v1/sandbox/fixtures');
    }
}
