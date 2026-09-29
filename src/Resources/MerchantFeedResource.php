<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

/**
 * A scheduled catalog feed from your own feed URL.
 */
final class MerchantFeedResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function get(): mixed
    {
        return $this->client->request('GET', '/v1/merchant/feed-source');
    }

    public function set(array $input): mixed
    {
        return $this->client->request('POST', '/v1/merchant/feed-source', $input);
    }

    public function fetchNow(): mixed
    {
        return $this->client->request('POST', '/v1/merchant/feed-source/fetch-now');
    }
}
