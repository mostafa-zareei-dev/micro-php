<?php

namespace App\Kernel\Http;

class Request
{
    private string $uri;
    private array $query = [];
    private array $params = [];
    private array $body = [];
    private array $server = [];
    private array $headers = [];
    private string $method;

    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->query = $_GET;
        $this->params = [];
        $this->body = $_POST;
        $this->server = $_SERVER;
        $this->headers = $this->parseHeaders();
        $this->method = $this->server['REQUEST_METHOD'] ?? 'GET';

        if ($this->method === 'POST' && strpos($this->header('Content-Type'), 'application/json') !== false) {
            $this->body = json_decode(file_get_contents('php://input'), true) ?? [];
        }
    }

    public function uri()
    {
        return $this->uri;
    }

    public function query(string $key, $default = null): array | string | null
    {
        return $this->query[$key] ?? $default;
    }

    public function params(): array
    {
        return $this->params;
    }

    public function param(string $key, $default = null): array | string | null
    {
        return $this->params[$key] ?? $default;
    }

    public function body(string $key, $default = null): array | string | null
    {
        return $this->body[$key] ?? $default;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function server($key, $default = null): string | null
    {
        return $this->serverParams[$key] ?? $default;
    }


    public function header($key, $default = null): string | null
    {
        $key = strtolower($key);
        return $this->headers[$key] ?? $default;
    }

    public function path(): string
    {
        return parse_url($this->uri, PHP_URL_PATH);
    }

    private function parseHeaders(): array
    {
        $headers = [];
        foreach ($this->server as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $headerName = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))));
                $headers[$headerName] = $value;
            }
        }
        return $headers;
    }
}
