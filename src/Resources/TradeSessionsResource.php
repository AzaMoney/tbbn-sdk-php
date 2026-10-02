<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

final class TradeSessionsResource
{
    public function __construct(private readonly TbbnClient $client) {}

    public function list(string $sellerId): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery('/v1/trade-sessions', ['sellerId' => $sellerId]));
    }

    public function get(string $id): mixed
    {
        return $this->client->request('GET', "/v1/trade-sessions/{$id}");
    }

    public function cancel(string $id, string $actingSellerId, ?string $reason = null): mixed
    {
        return $this->client->request('POST', "/v1/trade-sessions/{$id}/cancel", ['actingSellerId' => $actingSellerId, 'reason' => $reason]);
    }

    /** The paid side closes a trade the other side never completed, once the hold has elapsed. */
    public function closeUnreciprocated(string $id, string $actingSellerId, string $note): mixed
    {
        return $this->client->request('POST', "/v1/trade-sessions/{$id}/close-unreciprocated", ['actingSellerId' => $actingSellerId, 'note' => $note]);
    }

    /** Peer-to-peer completion: either party confirms the exchange happened. */
    public function confirmScheduling(string $id, string $actingSellerId, ?string $confirmedByMerchantUserId = null): mixed
    {
        return $this->client->request('POST', "/v1/trade-sessions/{$id}/scheduling/confirm", ['actingSellerId' => $actingSellerId, 'confirmedByMerchantUserId' => $confirmedByMerchantUserId]);
    }

    public function failScheduling(string $id, string $actingSellerId, ?string $reason = null): mixed
    {
        return $this->client->request('POST', "/v1/trade-sessions/{$id}/scheduling/fail", ['actingSellerId' => $actingSellerId, 'reason' => $reason]);
    }

    /** Excuses the paid side from fulfilling once the counterparty hold has elapsed. */
    public function excuseFulfillment(string $id, string $note): mixed
    {
        return $this->client->request('POST', "/v1/trade-sessions/{$id}/excuse-fulfillment", ['note' => $note]);
    }

    /**
     * A matching-only side reports how it settled on your platform: 'completed', or 'failed' with
     * a reason. Unreported sides are released as failed after 14 days.
     */
    public function reportExternalSettlement(string $id, string $side, string $outcome, ?string $reason = null): mixed
    {
        return $this->client->request('POST', "/v1/trade-sessions/{$id}/external-settlement", [
            'side' => $side,
            'outcome' => $outcome,
            'reason' => $reason,
        ]);
    }

    /** Extends a matching-only side's report deadline once, by 1–14 days, before it passes. */
    public function extendExternalSettlement(string $id, string $side, int $days, string $reason): mixed
    {
        return $this->client->request('POST', "/v1/trade-sessions/{$id}/external-settlement/extend", [
            'side' => $side,
            'days' => $days,
            'reason' => $reason,
        ]);
    }

    public function acknowledgeHoldTerms(string $id, ?string $actingSellerId = null): mixed
    {
        return $this->client->request('POST', "/v1/trade-sessions/{$id}/acknowledge-hold-terms", ['actingSellerId' => $actingSellerId]);
    }

    /**
     * Proposes a meeting place. With $spaceId and $acceptTerms true, the Space is booked in your
     * name (you pay for it) when the other trader accepts; a $branchId alone proposes a location.
     */
    public function proposeSpace(
        string $id,
        ?string $branchId = null,
        ?string $actingSellerId = null,
        ?string $spaceId = null,
        ?string $scheduledAt = null,
        ?bool $acceptTerms = null,
    ): mixed {
        return $this->client->request('POST', "/v1/trade-sessions/{$id}/space-proposals", [
            'branchId' => $branchId,
            'spaceId' => $spaceId,
            'scheduledAt' => $scheduledAt,
            'acceptTerms' => $acceptTerms,
            'actingSellerId' => $actingSellerId,
        ]);
    }

    public function listSpaceProposals(string $id): mixed
    {
        return $this->client->request('GET', "/v1/trade-sessions/{$id}/space-proposals");
    }

    public function acceptSpaceProposal(string $id, string $proposalId, ?string $actingSellerId = null): mixed
    {
        return $this->client->request('POST', "/v1/trade-sessions/{$id}/space-proposals/{$proposalId}/accept", ['actingSellerId' => $actingSellerId]);
    }
}
