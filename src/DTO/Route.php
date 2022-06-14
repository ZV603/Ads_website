<?php

declare(strict_types=1);

namespace AdsWebsite\DTO;

class Route
{
    private ?string $resource = null;
    private ?string $id = null;
    private ?string $action = null;
    private ?string $method = null;

    // getteris
    public function getResource(): ?string
    {
        return $this->resource;
    }

    // setteris
    public function setResource(?string $resource): void
    {
        $this->resource = $resource;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(?string $action): void
    {
        $this->action = $action;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(?string $method): void
    {
        $this->method = $method;
    }


}