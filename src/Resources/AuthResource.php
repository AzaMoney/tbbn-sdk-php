<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class AuthResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function requestMerchantOtp(string $email): mixed
    {
        return $this->client->request('POST', '/v1/auth/merchant/otp/request', ['email' => $email]);
    }

    public function verifyMerchantOtp(string $email, string $code): mixed
    {
        return $this->client->request('POST', '/v1/auth/merchant/otp/verify', ['email' => $email, 'code' => $code]);
    }

    public function requestSellerOtp(string $email): mixed
    {
        return $this->client->request('POST', '/v1/auth/seller/otp/request', ['email' => $email]);
    }

    public function verifySellerOtp(string $email, string $code): mixed
    {
        return $this->client->request('POST', '/v1/auth/seller/otp/verify', ['email' => $email, 'code' => $code]);
    }

    public function requestMagicLink(string $email): mixed
    {
        return $this->client->request('POST', '/v1/auth/seller/magic-link/request', ['email' => $email]);
    }

    public function consumeMagicLink(string $token): mixed
    {
        return $this->client->request('GET', '/v1/auth/seller/magic-link/consume?token=' . urlencode($token));
    }

    public function refresh(string $refreshToken): mixed
    {
        return $this->client->request('POST', '/v1/auth/refresh', ['refreshToken' => $refreshToken]);
    }

    public function logout(string $refreshToken): mixed
    {
        return $this->client->request('POST', '/v1/auth/logout', ['refreshToken' => $refreshToken]);
    }

    public function me(): mixed
    {
        return $this->client->request('GET', '/v1/auth/me');
    }
}
