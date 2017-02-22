<?php

namespace SON\Router;

class Router
{
    private $path;
    private $method;
    private $collection;

    public function __construct(string $path, string $method)
    {
        $this->path = $path;
        $this->method = strtoupper($method);

        $this->collection = new RouterCollection;
    }

    public function get($path, $fn)
    {
        $this->addToCollection($path, $fn, 'GET');
    }

    public function post($path, $fn)
    {
        $this->addToCollection($path, $fn, 'POST');
    }

    public function run()
    {
        $data = $this->collection->filter($this->method);

        foreach ($data as $key => $value) {
            $result= $this->checkUrl($key, $this->path);
            $callback = $value;
            if ($result['result']) {
                break;
            }
        }

        if (!$result['result']) {
            $callback = null;
        }
        return [
            'params'=>$result['params'],
            'callback'=>$callback,
        ];
    }

    private function addToCollection($path, $fn, $method)
    {
        $this->collection->add($method, $path, $fn);
    }

    private function checkUrl(string $toFind, $subject)
    {
        preg_match_all('/\{([^\}]*)\}/', $toFind, $variables);

        $regex = str_replace('/', '\/', $toFind);

        foreach ($variables[1] as $k=>&$variable) {
            $as = explode(':', $variable);
            $replacement = $as[1] ?? '([a-zA-Z0-9\-\_\ ]+)';
            $regex = str_replace($variables[$k], $replacement, $regex);
        }
        $regex = preg_replace('/{([a-zA-Z]+)}/', '([a-zA-Z0-9]+)', $regex);
        $result = preg_match('/^'.$regex.'$/', $subject, $params);

        return compact('result', 'params');
    }
}
