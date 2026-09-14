<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class CheckoutResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function paymentWebhook(array $input): mixed
    {
        return $this->client->request('POST', '/v1/checkout/webhooks/payment', $input);
    }

    public function fulfillmentWebhook(array $input): mixed
    {
        return $this->client->request('POST', '/v1/checkout/webhooks/fulfillment', $input);
    }

    public function complete(string $tradeSessionId): mixed
    {
        return $this->client->request('POST', "/v1/checkout/trade-sessions/{$tradeSessionId}/complete");
    }

    public function payments(string $tradeSessionId): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery('/v1/checkout/payments', ['tradeSessionId' => $tradeSessionId]));
    }
}
