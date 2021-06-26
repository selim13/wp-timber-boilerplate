<?php

namespace Local;

class AssetsManifest
{
    private array $assets = [];

    public function __construct(string $path = null)
    {
        if ($path) {
            $this->load($path);
        }
    }

    public function load(string $path): AssetsManifest
    {
        if (file_exists($path)) {
            try {
                $this->assets = array_merge(
                    $this->assets,
                    json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR)
                );
            } catch (\JsonException $e) {
            }
        }

        return $this;
    }

    public function get(string $key): string
    {
        if ($key[0] !== '/') {
            $key = '/' . $key;
        }

        if (array_key_exists($key, $this->assets)) {
            return $this->assets[$key];
        }

        return sprintf('<!-- %s not found. -->', $key);
    }
}
