<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

/**
 * Seller account linking (OAuth 2.0). Call `token()` from your backend only.
 */
final class OAuthLinkResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function getClient(string $clientId): mixed
    {
        return $this->client->request('GET', "/v1/link/oauth/clients/{$clientId}");
    }

    public function token(string $code, string $clientId, string $clientSecret, string $redirectUri, ?string $codeVerifier = null): mixed
    {
        return $this->client->request('POST', '/v1/link/oauth/token', ['grant_type' => 'authorization_code', 'code' => $code, 'client_id' => $clientId, 'client_secret' => $clientSecret, 'redirect_uri' => $redirectUri, 'code_verifier' => $codeVerifier]);
    }
}
