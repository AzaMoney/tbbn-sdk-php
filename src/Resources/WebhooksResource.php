<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class WebhooksResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function createSubscription(array $input): mixed
    {
        return $this->client->request('POST', '/v1/webhooks/subscriptions', $input);
    }

    public function listSubscriptions(string $merchantId): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery('/v1/webhooks/subscriptions', ['merchantId' => $merchantId]));
    }

    public function disableSubscription(string $id, string $merchantId): mixed
    {
        return $this->client->request('POST', "/v1/webhooks/subscriptions/{$id}/disable", ['merchantId' => $merchantId]);
    }

    public function listDeliveries(?string $subscriptionId = null): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery('/v1/webhooks/deliveries', ['subscriptionId' => $subscriptionId]));
    }

    public function replayDelivery(string $id): mixed
    {
        return $this->client->request('POST', "/v1/webhooks/deliveries/{$id}/replay");
    }
}
