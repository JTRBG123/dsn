<?php

namespace Utopia\DSN;

class DSN
{
    /**
     * @var string
     */
    protected string $scheme;

    /**
     * @var ?string
     */
    protected ?string $user;

    /**
     * @var ?string
     */
    protected ?string $password;

    /**
     * @var string
     */
    protected string $host;

    /**
     * @var ?string
     */
    protected ?string $port;

    /**
     * @var ?string
     */
    protected ?string $path;

    /**
     * @var ?string
     */
    protected ?string $query;

    /**
     * @var ?array
     */
    protected ?array $params = null;

    /**
     * Construct
     *
     * Construct a new DSN object
     *
     * @param  string  $dsn
     */
    public function __construct(string $dsn)
    {
        $parts = parse_url($dsn);

        if (! $parts) {
            throw new \InvalidArgumentException("Unable to parse DSN: $dsn");
        }

        $this->scheme = $parts['scheme'] ?? null;
        $this->user = isset($parts['user']) ? \urldecode($parts['user']) : null;
        $this->password = isset($parts['pass']) ? \urldecode($parts['pass']) : null;
        $this->host = $parts['host'] ?? null;
        $this->user = $parts['user'] ?? null;
        $this->password = $parts['pass'] ?? null;
        $this->host = $parts['host'] ?? '';
        $this->port = $parts['port'] ?? null;
        $this->path = isset($parts['path']) ? ltrim($parts['path'], '/') : null;
        $this->path = $parts['path'] ?? '';
        $this->query = $parts['query'] ?? null;
    }

    /**
     * Return the scheme.
     *
     * @return string
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }

    /**
     * Return the user.
     *
     * @return ?string
     */
    public function getUser(): ?string
    {
        return $this->user;
    }

    /**
     * Return the password.
     *
     * @return ?string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Return the host
     *
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * Return the port
     *
     * @return ?string
     */
    public function getPort(): ?string
    {
        return $this->port;
    }

    /**
     * Return the path
     *
     * @return ?string
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * Return the query string
     *
     * @return ?string
     */
    public function getQuery(): ?string
    {
        return $this->query;
    }

    /**
     * Return a query parameter by its key
     *
     * @return string
     */
    public function getParam(string $key, string $default = ''): string
    {
        if (isset($this->params[$key])) {
            return $this->params[$key];
        }

        if (! $this->query) {
            return $default;
        }

        parse_str($this->query, $this->params);

        return $this->params[$key] ?? $default;
    }
}
