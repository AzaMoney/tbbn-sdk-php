<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

/**
 * Live platform status.
 */
final class StatusResource
{
    public function __construct(private readonly TbbnClient $client) {}

    /** Public, no credential needed. */
    public function get(): mixed
    {
        return $this->client->request('GET', '/v1/status');
    }
}
