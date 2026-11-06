<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

/**
 * What people wrote, in another language. Public.
 */
final class TranslationsResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function available(): mixed
    {
        return $this->client->request('GET', "/v1/directory/translations/available");
    }

    public function listing(string $id, string $lang): mixed
    {
        return $this->client->request('GET', "/v1/directory/translations/listings/{$id}?lang={$lang}");
    }

    public function storeBio(string $slug, string $lang): mixed
    {
        return $this->client->request('GET', "/v1/directory/translations/storefronts/{$slug}?lang={$lang}");
    }
}
