<?php

namespace App\DataCache;

use App\Services\GitHub\GetTotalContributions;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

class UserTodayContributionsDataCache extends AbstractDataCache
{
    public function __construct(public string $username)
    {
    }

    public function getCacheKey(): string
    {
        return 'user-today-contributions-' . $this->username;
    }

    public function computeCache(): string
    {
        return GetTotalContributions::get(
            $this->username,
            Carbon::now()->startOfDay(),
            Carbon::now()->endOfDay(),
        );
    }

    public function getCacheExpiration(): CarbonImmutable
    {
        return CarbonImmutable::now()->addMinutes(10);
    }
}
