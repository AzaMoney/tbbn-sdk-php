<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class LocalizationResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function countries(): mixed
    {
        return $this->client->request('GET', '/v1/localization/countries');
    }

    public function languages(): mixed
    {
        return $this->client->request('GET', '/v1/localization/languages');
    }

    public function normalizePhone(string $phone): mixed
    {
        return $this->client->request('POST', '/v1/localization/normalize-phone', ['phone' => $phone]);
    }
}
