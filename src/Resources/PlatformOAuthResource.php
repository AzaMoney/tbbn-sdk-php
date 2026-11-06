<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

/**
 * "Connect to TBBN" for a software vendor's server, with its client secret.
 */
final class PlatformOAuthResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function pushRequest(array $input): mixed
    {
        return $this->client->request('POST', "/v1/platform-oauth/par", $input);
    }

    public function token(array $input): mixed
    {
        return $this->client->request('POST', "/v1/platform-oauth/token", $input);
    }

    public function revoke(array $input): mixed
    {
        return $this->client->request('POST', "/v1/platform-oauth/revoke", $input);
    }
}
