<?php

namespace App\DataCache;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;

abstract class AbstractDataCache
{
    /**
     * Concrete class must implement and return the cache key
     */
    abstract public function getCacheKey(): string;

    /**
     * Concrete class must know how to compute and return the data that need to be cached
     */
    abstract public function computeCache(): mixed;

    /**
     * By default, data will be cached for an hour
     */
    public function getCacheExpiration(): CarbonImmutable
    {
        return CarbonImmutable::now()->addHour();
    }

    public function get(): mixed
    {
        return Cache::remember(
            $this->getCacheKey(),
            $this->getCacheExpiration(),
            fn () => $this->computeCache()
        );
    }

    /**
     * Clear the cache data
     */
    public function clear(): void
    {
        Cache::forget($this->getCacheKey());
    }

    /**
     * Clear and re-cache the data
     */
    public function rebuild(): void
    {
        $this->clear();
        $this->get();
    }
}
