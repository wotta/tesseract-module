<?php

namespace ConceptCore\Tesseract\Objects\Cache;

use ConceptCore\Tesseract\Interfaces\Cache\Cache as CacheInterface;
use Illuminate\Support\Collection;

class Cache implements CacheInterface
{
    /** @var array */
    public $storageArray = [];

    /** @var Collection */
    public $storage;

    public function __construct()
    {
        $this->storage = collect($this->storageArray);
    }

    public function all(): array
    {
        return $this->storage->all();
    }

    public function has(string $key): bool
    {
        return $this->storage->has($key);
    }

    /**
     * @param  string|array $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->storage->get($key, null);
    }

    /**
     * @param  array $keys
     * @return array
     */
    public function many(array $keys)
    {
        return $this->storage->only($keys)->toArray();
    }

    /**
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
     * @param  array $values
     * @param  float|int $minutes
     * @return void
     */
    public function putMany(array $values, $minutes)
    {
        $this->storage->offsetSet(null, collect($values));
    }

    /**
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
     * @param  string $key
     * @param  mixed $value
     * @return int|bool
     */
    public function decrement($key, $value = 1)
    {
        if ($this->storage->has($key)) {
            if (is_numeric($this->storage->get($key))) {
                return $this->storage->get($key) - $value;
            }

            return false;
        }

        return false;
    }

    public function forever($key, $value): void
    {
        $this->storage->put($key, $value);
    }

    public function forget($key): bool
    {
        $this->storage->forget($key);

        return $this->storage->has($key);
    }

    public function flush(): bool
    {
        $this->storage = new Collection();

        if ($this->storage->isEmpty()) {
            return true;
        }

        return false;
    }

    public function getPrefix(): string
    {
        return '';
    }
}