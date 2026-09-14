<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class MerchantsResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function create(array $input): mixed
    {
        return $this->client->request('POST', '/v1/merchants', $input);
    }

    public function get(string $id): mixed
    {
        return $this->client->request('GET', "/v1/merchants/{$id}");
    }

    public function update(string $id, array $patch, ?string $idempotencyKey = null): mixed
    {
        return $this->client->request('PATCH', "/v1/merchants/{$id}", $patch, TbbnClient::idempotencyHeader($idempotencyKey));
    }

    public function submitApplication(string $id, ?array $submittedDocs = null): mixed
    {
        return $this->client->request('POST', "/v1/merchants/{$id}/submit-application", ['submittedDocs' => $submittedDocs]);
    }

    public function applicationStatus(string $id): mixed
    {
        return $this->client->request('GET', "/v1/merchants/{$id}/application-status");
    }

    public function inviteUser(string $id, string $email, string $role, ?string $idempotencyKey = null): mixed
    {
        return $this->client->request('POST', "/v1/merchants/{$id}/users/invite", ['email' => $email, 'role' => $role], TbbnClient::idempotencyHeader($idempotencyKey));
    }

    public function listUsers(string $id): mixed
    {
        return $this->client->request('GET', "/v1/merchants/{$id}/users");
    }

    public function changeRole(string $id, string $userId, string $role, ?string $idempotencyKey = null): mixed
    {
        return $this->client->request('PATCH', "/v1/merchants/{$id}/users/{$userId}/role", ['role' => $role], TbbnClient::idempotencyHeader($idempotencyKey));
    }
}
