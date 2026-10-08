<?php

declare(strict_types=1);

namespace Tbbn\Sdk\Resources;

use Tbbn\Sdk\TbbnClient;

/**
 * TBBN Space — search, booking terms and bookings. Construct the client with a Space API key
 * (`sk_space_...`) to book for clients without a TBBN account.
 */
final class SpaceResource
{
    public function __construct(private readonly TbbnClient $client) {}

    /** Query keys include country, region, category, lat/lng, radiusMiles, query, minCapacity, amenity, sortBy and limit. */
    public function search(array $query = []): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery('/v1/space/search', $query));
    }

    public function listSpaces(string $branchId): mixed
    {
        return $this->client->request('GET', "/v1/space/branches/{$branchId}/spaces");
    }

    public function getSpace(string $id): mixed
    {
        return $this->client->request('GET', "/v1/space/spaces/{$id}");
    }

    /** The refund and no-show policy, processing fee and terms a guest agrees to. */
    public function bookingTerms(string $spaceId): mixed
    {
        return $this->client->request('GET', "/v1/space/spaces/{$spaceId}/booking-terms");
    }

    /** A member booking must include `acceptTerms => true`. */
    public function createBooking(array $input): mixed
    {
        return $this->client->request('POST', '/v1/space/bookings', $input);
    }

    public function listBookings(array $query): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery('/v1/space/bookings', $query));
    }

    /** A location's spot board: who should be in each spot now, who's next, who's arriving. */
    public function spotBoard(string $branchId): mixed
    {
        return $this->client->request('GET', "/v1/space/branches/{$branchId}/spot-board");
    }

    public function paymentInfo(string $bookingId, ?string $token = null): mixed
    {
        return $this->client->request('GET', TbbnClient::withQuery("/v1/space/bookings/{$bookingId}/payment-info", ['token' => $token]));
    }

    public function cancelBooking(string $bookingId, ?string $token = null): mixed
    {
        return $this->client->request('POST', TbbnClient::withQuery("/v1/space/bookings/{$bookingId}/cancel", ['token' => $token]));
    }

    public function rescheduleBooking(string $bookingId, string $scheduledAt, ?string $token = null): mixed
    {
        return $this->client->request('POST', TbbnClient::withQuery("/v1/space/bookings/{$bookingId}/reschedule", ['token' => $token]), ['scheduledAt' => $scheduledAt]);
    }

    /** The host cancels; the guest is refunded in full. */
    public function hostCancelBooking(string $bookingId, string $reason): mixed
    {
        return $this->client->request('POST', "/v1/space/bookings/{$bookingId}/host-cancel", ['reason' => $reason]);
    }
}
