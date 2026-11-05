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

    /** Send the linking request from your server first; the browser then carries only request_uri. */
    public function pushRequest(string $clientId, string $clientSecret, string $redirectUri, string $codeChallenge, ?string $merchantSellerRef = null): mixed
    {
        return $this->client->request('POST', '/v1/link/oauth/par', ['client_id' => $clientId, 'client_secret' => $clientSecret, 'redirect_uri' => $redirectUri, 'scope' => 'link:seller', 'code_challenge' => $codeChallenge, 'code_challenge_method' => 'S256', 'merchant_seller_ref' => $merchantSellerRef]);
    }

    public function token(string $code, string $clientId, string $clientSecret, string $redirectUri, ?string $codeVerifier = null, ?string $merchantSellerRef = null): mixed
    {
        return $this->client->request('POST', '/v1/link/oauth/token', ['grant_type' => 'authorization_code', 'code' => $code, 'client_id' => $clientId, 'client_secret' => $clientSecret, 'redirect_uri' => $redirectUri, 'code_verifier' => $codeVerifier, 'merchant_seller_ref' => $merchantSellerRef]);
    }
}
