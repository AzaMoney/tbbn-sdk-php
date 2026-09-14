<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class SearchResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function listings(array $input): mixed
    {
        return $this->client->request('POST', '/v1/search/listings', $input);
    }
}
