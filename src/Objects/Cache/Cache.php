<?php

namespace ConceptCore\Tesseract\Objects\Cache;

use ConceptCore\Tesseract\Interfaces\Cache\Cache as CacheInterface;
use Illuminate\Support\Collection;

class Cache implements CacheInterface
{
    /** @var Collection */
    protected $storage;

    public function __construct(Collection $collection)
    {
        $this->storage = $collection;
    }

    /**
     * Retrieve an item from the cache by key.
     *
     * @param  string|array $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->storage->get($key, null);
    }

    /**
     * Retrieve multiple items from the cache by key.
     *
     * Items not found in the cache will have a null value.
     *
     * @param  array $keys
     * @return array
     */
    public function many(array $keys)
    {
        return $this->storage->only($keys);
    }

    /**
     * Store an item in the cache for a given number of minutes.
     *
     * @param  string $key
     * @param  mixed $value
     * @param  float|int $minutes
     * @return void
     */
    public function put($key, $value, $minutes)
    {
        $this->storage->put($key, $value);
    }

    /**
     * Store multiple items in the cache for a given number of minutes.
     *
     * @param  array $values
     * @param  float|int $minutes
     * @return void
     */
    public function putMany(array $values, $minutes)
    {
        $this->storage->offsetSet(null, collect($values));
    }

    /**
     * Increment the value of an item in the cache.
     *
     * @param  string $key
     * @param  mixed $value
     * @return int|bool
     */
    public function increment($key, $value = 1)
    {
        if ($this->storage->has($key)) {
            if (is_numeric($this->storage->get($key))) {
                return $this->storage->get($key) + $value;
            }

            return false;
        }

        return false;
    }

    /**
     * Decrement the value of an item in the cache.
     *
     * @param  string $key
     * @param  mixed $value
     * @return int|bool
     */
    public function decrement($key, $value = 1)
    {
        // TODO: Implement decrement() method.
    }

    /**
     * Store an item in the cache indefinitely.
     *
     * @param  string $key
     * @param  mixed $value
     * @return void
     */
    public function forever($key, $value)
    {
        $this->put($key, $value, 0);
    }

    /**
     * Remove an item from the cache.
     *
     * @param  string $key
     * @return bool
     */
    public function forget($key)
    {
        $this->storage->forget($key);
    }

    /**
     * Remove all items from the cache.
     *
     * @return bool
     */
    public function flush()
    {
        $this->storage = new Collection();

        if ($this->storage->isEmpty()) {
            return true;
        }

        return false;
    }

    /**
     * Get the cache key prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        return '';
    }

    private function getValue(string $key, callable $callback)
    {
        if ($this->storage->has($key)) {
            return $callback;
        }

        return null;
    }
}