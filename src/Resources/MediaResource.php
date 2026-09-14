<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class MediaResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function ingest(array $images): mixed
    {
        return $this->client->request('POST', '/v1/media/ingest', ['images' => $images]);
    }
}
