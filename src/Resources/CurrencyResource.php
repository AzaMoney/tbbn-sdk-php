<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class CurrencyResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function supported(): mixed
    {
        return $this->client->request('GET', '/v1/currency/supported');
    }

    public function convert(float $amount, string $from, string $to): mixed
    {
        return $this->client->request('POST', '/v1/currency/convert', ['amount' => $amount, 'from' => $from, 'to' => $to]);
    }
}
