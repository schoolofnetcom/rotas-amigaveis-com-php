<?php

namespace SON\Router;

use Illuminate\Support\Collection;

class RouterCollection
{
    private $collection = [];

    public function add(string $method, string $path, $function)
    {
        if (!isset($this->collection[$method])) {
            $this->collection[$method] = new Collection;
        }
        $this->collection[$method]->put($path, $function);
    }

    public function filter($method) {
        if (!isset($this->collection[$method])) {
            $this->collection[$method] = new Collection;
        }

        return $this->collection[$method];
    }

    public function all() {
        return $this->collection;
    }

}
